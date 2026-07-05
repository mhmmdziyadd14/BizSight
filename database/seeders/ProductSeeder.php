<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::updateOrCreate(
            ['name' => 'Profit Clarity Calculator'],
            [
                'slug' => '497385',
                'type' => 'single_tool',
                'price' => 149000,
                'features' => ['PCC'],
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Decision Engine'],
            [
                'slug' => '497390',
                'type' => 'single_tool',
                'price' => 249000,
                'features' => ['DE'],
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Visual Clarity Pack'],
            [
                'slug' => '497388',
                'type' => 'single_tool',
                'price' => 149000,
                'features' => ['VCP'],
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Clarity Essentials'],
            [
                'slug' => '497399',
                'type' => 'bundle',
                'price' => 279000,
                'features' => ['PCC', 'DE'],
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Clarity Full'],
            [
                'slug' => '497401',
                'type' => 'bundle',
                'price' => 389000,
                'features' => ['PCC', 'DE', 'VCP'],
            ]
        );

        // Standalone Trial / Monthly Extensions
        $pccBumpId = config('services.scalev.pcc_bump_id') ?: 'pcc_bump_id_placeholder';
        $vcpBumpId = config('services.scalev.vcp_bump_id') ?: 'vcp_bump_id_placeholder';
        $deBumpId = config('services.scalev.de_bump_id') ?: 'de_bump_id_placeholder';

        Product::updateOrCreate(
            ['name' => 'Decision Engine - 30 Days Extension'],
            [
                'slug' => $pccBumpId,
                'type' => 'trial_extension',
                'price' => 49000,
                'features' => ['DE'],
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Profit Clarity Calculator - 30 Days Extension (VCP Buyer)'],
            [
                'slug' => $vcpBumpId,
                'type' => 'trial_extension',
                'price' => 39000,
                'features' => ['PCC'],
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Profit Clarity Calculator - 30 Days Extension (DE Buyer)'],
            [
                'slug' => $deBumpId,
                'type' => 'trial_extension',
                'price' => 49000,
                'features' => ['PCC'],
            ]
        );
    }
}
