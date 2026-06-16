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

        $endpoints = [
            '/api/orders',
            '/v1/orders',
            '/api/v1/orders',
            '/orders'
        ];

        $results = [];

        foreach ($endpoints as $ep) {
            try {
                $url = rtrim($this->base, '/') . $ep;
                $resp = Http::withHeaders($this->authHeaders())->timeout(30)
                    ->get($url, ['email' => $email]);

                if (! $resp->ok()) continue;

                $json = $resp->json();
                // common shapes: { orders: [...] } or array of orders
                $orders = [];
                if (isset($json['orders']) && is_array($json['orders'])) {
                    $orders = $json['orders'];
                } elseif (is_array($json) && array_keys($json) !== range(0, count($json) - 1)) {
                    // associative response maybe contains data
                    $orders = $json['data'] ?? [];
                } elseif (is_array($json)) {
                    $orders = $json;
                }

                foreach ($orders as $o) {
                    // try to extract product/variant
                    $productId = $o['product_id'] ?? $o['variant_id'] ?? null;
                    if (! $productId && isset($o['products']) && is_array($o['products']) && count($o['products'])>0) {
                        $first = $o['products'][0];
                        $productId = $first['variant_id'] ?? $first['product_id'] ?? null;
                    }

                    $results[] = [
                        'product_id' => $productId,
                        'raw' => $o
                    ];
                }

                // If we found orders, stop trying other endpoints
                if (count($results) > 0) break;
            } catch (\Throwable $e) {
                Log::warning('ScalevClient error: ' . $e->getMessage());
                continue;
            }
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
