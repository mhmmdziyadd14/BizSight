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
        Product::create([
            'name' => 'Profit Clarity Calculator',
            'slug' => '497385',
            'type' => 'single_tool',
            'price' => 149000,
            'features' => ['PCC'],
        ]);

        Product::create([
            'name' => 'Decision Engine',
            'slug' => '497390',
            'type' => 'single_tool',
            'price' => 249000,
            'features' => ['DE'],
        ]);

        Product::create([
            'name' => 'Visual Clarity Pack',
            'slug' => '497388',
            'type' => 'single_tool',
            'price' => 149000,
            'features' => ['VCP'],
        ]);

        Product::create([
            'name' => 'Clarity Essentials',
            'slug' => '497399',
            'type' => 'bundle',
            'price' => 279000,
            'features' => ['PCC', 'DE'],
        ]);

        Product::create([
            'name' => 'Clarity Full',
            'slug' => '497401',
            'type' => 'bundle',
            'price' => 389000,
            'features' => ['PCC', 'DE', 'VCP'],
        ]);
    }
}
