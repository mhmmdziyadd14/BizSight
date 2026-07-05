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

        // Standalone Trial / Monthly Extensions with direct Scalev URLs as slugs
        Product::updateOrCreate(
            ['name' => 'Profit Clarity Calculator - 30 Days Extension'],
            [
                'slug' => 'extended-access-profit-clarity-calculator-30-days-50-off-checkout-only-7qvgkr',
                'type' => 'trial_extension',
                'price' => 39000,
                'features' => ['PCC'],
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Decision Engine - 30 Days Extension'],
            [
                'slug' => 'extended-access-decision-engine-30-days-60-off-checkout-only-qemluw',
                'type' => 'trial_extension',
                'price' => 59000,
                'features' => ['DE'],
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Visual Clarity Pack - 30 Days Extension'],
            [
                'slug' => 'extended-access-visual-clarity-pack-30-days-50-off-checkout-only-5hdlxm',
                'type' => 'trial_extension',
                'price' => 39000,
                'features' => ['VCP'],
            ]
        );
    }
}
