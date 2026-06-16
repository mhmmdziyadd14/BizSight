<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\ScalevClient;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class SyncScalevPurchases
{
    protected $client;

    public function __construct(ScalevClient $client)
    {
        $this->client = $client;
    }

    public function handle(Login $event)
    {
        $user = $event->user;
        if (! $user || ! $user->email) return;

        try {
            $items = $this->client->getPurchasesByEmail($user->email);
            if (!is_array($items) || empty($items)) return;

            foreach ($items as $it) {
                $pid = $it['product_id'] ?? null;
                if (! $pid) continue;

                // Try to find a Product by slug (which stores the variant ID)
                $product = Product::where('slug', $pid)->first();
                if (! $product) {
                    // try numeric id mapping
                    $product = Product::where('id', $pid)->first();
                }

                if ($product) {
                    $features = $product->features ?? [];
                    foreach ($features as $featureCode) {
                        $has = $user->accesses()->where('feature_code', $featureCode)->exists();
                        if (! $has) {
                            $user->accesses()->create(['feature_code' => $featureCode, 'order_id' => null]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('SyncScalevPurchases failed: ' . $e->getMessage());
        }
    }
}
