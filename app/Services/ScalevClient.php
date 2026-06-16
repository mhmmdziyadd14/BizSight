<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScalevClient
{
    protected $base;
    protected $key;

    public function __construct()
    {
        $this->base = env('SCALEV_API_BASE', null);
        $this->key = env('SCALEV_API_KEY', null);
    }

    /**
     * Try to fetch purchases/orders for an email from Scalev.
     * Returns array of products (each item: ['product_id' => , 'variant_id' => , 'raw' => ...])
     */
    public function getPurchasesByEmail(string $email): array
    {
        if (! $this->base) {
            Log::warning('ScalevClient: SCALEV_API_BASE not configured');
            return [];
        }

        $results = [];
        $headers = $this->authHeaders();

        try {
            $has_next = true;
            $last_id = null;
            $pages_scanned = 0;
            $found_orders = [];

            // Scan through pages of orders to find matching emails
            while ($has_next && $pages_scanned < 15) {
                $pages_scanned++;
                $url = rtrim($this->base, '/') . '/v2/order';
                
                $query = [];
                if ($last_id) {
                    $query['last_id'] = $last_id;
                }

                $resp = Http::withHeaders($headers)->timeout(30)->get($url, $query);

                if (! $resp->ok()) {
                    Log::warning("ScalevClient: Request failed on page {$pages_scanned} with status " . $resp->status());
                    break;
                }

                $json = $resp->json();
                $data = $json['data'] ?? [];
                $order_list = $data['results'] ?? [];
                $has_next = $data['has_next'] ?? false;
                $last_id = $data['last_id'] ?? null;

                foreach ($order_list as $order) {
                    $custEmail = $order['customer']['email'] ?? '';
                    if (strtolower($custEmail) === strtolower($email)) {
                        $found_orders[] = $order;
                    }
                }

                if (!$last_id) {
                    $has_next = false;
                }
            }

            // For each found order, fetch details to get the variant IDs (orderlines)
            foreach ($found_orders as $orderObj) {
                $uuid = $orderObj['id'] ?? null;
                if (!$uuid) continue;

                $detailUrl = rtrim($this->base, '/') . '/v2/order/' . $uuid;
                $detailResp = Http::withHeaders($headers)->timeout(15)->get($detailUrl);

                if ($detailResp->ok()) {
                    $detailJson = $detailResp->json();
                    $orderData = $detailJson['data'] ?? [];
                    
                    // Extract variant IDs from orderlines
                    $orderlines = $orderData['orderlines'] ?? [];
                    foreach ($orderlines as $line) {
                        $variantId = $line['variant'] ?? null;
                        if ($variantId) {
                            $results[] = [
                                'product_id' => (string) $variantId,
                                'raw' => $orderData
                            ];
                        }
                    }
                }
            }

        } catch (\Throwable $e) {
            Log::error('ScalevClient error: ' . $e->getMessage());
        }

        return $results;
    }

    protected function authHeaders(): array
    {
        $h = ['Accept' => 'application/json'];
        if ($this->key) {
            $h['Authorization'] = 'Bearer ' . $this->key;
        }
        return $h;
    }
}
