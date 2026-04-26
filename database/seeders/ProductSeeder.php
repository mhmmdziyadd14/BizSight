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
            'type' => 'single_tool',
            'price' => 149000,
            'features' => ['PCC'],
        ]);

        Product::create([
            'name' => 'Decision Engine',
            'type' => 'single_tool',
            'price' => 249000,
            'features' => ['DE'],
        ]);

        Product::create([
            'name' => 'Visual Clarity Pack',
            'type' => 'single_tool',
            'price' => 149000,
            'features' => ['VCP'],
        ]);

        Product::create([
            'name' => 'Clarity Essentials',
            'type' => 'bundle',
            'price' => 279000,
            'features' => ['PCC', 'DE'],
        ]);

        Product::create([
            'name' => 'Clarity Full',
            'type' => 'bundle',
            'price' => 389000,
            'features' => ['PCC', 'DE', 'VCP'],
        ]);
    }
}
