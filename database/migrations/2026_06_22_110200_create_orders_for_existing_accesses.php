<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan tabel-tabel utama ada sebelum melakukan migrasi data
        if (!Schema::hasTable('user_accesses') || !Schema::hasTable('orders') || !Schema::hasTable('products') || !Schema::hasTable('order_items')) {
            return;
        }

        // Cari semua accesses yang order_id-nya null
        $accesses = DB::table('user_accesses')->whereNull('order_id')->get();

        // Kelompokkan berdasarkan user_id
        $grouped = $accesses->groupBy('user_id');

        foreach ($grouped as $userId => $userAccesses) {
            $orderId = (string) Str::uuid();
            $totalAmount = 0;

            // Buat order terlebih dahulu
            DB::table('orders')->insert([
                'id' => $orderId,
                'user_id' => $userId,
                'total_amount' => 0,
                'status' => 'success',
                'payment_method' => 'Scalev',
                'created_at' => $userAccesses->first()->created_at ?? now(),
                'updated_at' => $userAccesses->first()->updated_at ?? now(),
            ]);

            foreach ($userAccesses as $access) {
                $feature = strtolower($access->feature_code);

                // Cari product yang memiliki feature_code ini (case-insensitive)
                $product = DB::table('products')
                    ->where('is_active', true)
                    ->get()
                    ->filter(function($p) use ($feature) {
                        $feats = json_decode($p->features, true) ?? [];
                        return in_array(strtoupper($feature), array_map('strtoupper', $feats));
                    })
                    ->first();

                if (!$product) {
                    $product = DB::table('products')
                        ->get()
                        ->filter(function($p) use ($feature) {
                            $feats = json_decode($p->features, true) ?? [];
                            return in_array(strtoupper($feature), array_map('strtoupper', $feats));
                        })
                        ->first();
                }

                if ($product) {
                    DB::table('order_items')->insert([
                        'order_id' => $orderId,
                        'product_id' => $product->id,
                        'price' => $product->price,
                        'created_at' => $access->created_at ?? now(),
                        'updated_at' => $access->updated_at ?? now(),
                    ]);

                    $totalAmount += $product->price;
                }

                // Update user access dengan order_id yang baru dibuat
                DB::table('user_accesses')
                    ->where('id', $access->id)
                    ->update(['order_id' => $orderId]);
            }

            // Update total_amount order
            DB::table('orders')
                ->where('id', $orderId)
                ->update(['total_amount' => $totalAmount]);
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
