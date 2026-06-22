<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('user_accesses') || !Schema::hasTable('orders') || !Schema::hasTable('products') || !Schema::hasTable('order_items')) {
            return;
        }

        // Ambil semua accesses yang memiliki order_id
        $accesses = DB::table('user_accesses')->whereNotNull('order_id')->get();

        foreach ($accesses as $access) {
            $feature = strtoupper($access->feature_code);

            // Cari product yang memiliki feature_code ini (case-insensitive)
            $product = DB::table('products')
                ->get()
                ->filter(function($p) use ($feature) {
                    $feats = json_decode($p->features, true) ?? [];
                    return in_array($feature, array_map('strtoupper', $feats));
                })
                ->first();

            if ($product) {
                // Cek apakah order_items untuk order_id dan product_id ini sudah ada
                $itemExists = DB::table('order_items')
                    ->where('order_id', $access->order_id)
                    ->where('product_id', $product->id)
                    ->exists();

                if (!$itemExists) {
                    DB::table('order_items')->insert([
                        'order_id' => $access->order_id,
                        'product_id' => $product->id,
                        'price' => $product->price,
                        'created_at' => $access->created_at ?? now(),
                        'updated_at' => $access->updated_at ?? now(),
                    ]);
                }
            }
        }

        // Update total_amount untuk semua orders berdasarkan sum order_items
        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            $sum = DB::table('order_items')
                ->where('order_id', $order->id)
                ->sum('price');

            DB::table('orders')
                ->where('id', $order->id)
                ->update(['total_amount' => $sum]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data migration does not need reverse logic
    }
};
