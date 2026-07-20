<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserAccess;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaterialSearchTest extends TestCase
{
    use RefreshDatabase;

    private function createAuthorizedUser(): User
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'is_approved' => true,
        ]);

        UserAccess::create([
            'user_id' => $user->id,
            'feature_code' => 'pcc',
            'is_trial' => false,
            'expires_at' => null,
            'granted_at' => now(),
        ]);

        return $user;
    }

    public function test_user_can_search_materials_by_name()
    {
        $user = $this->createAuthorizedUser();

        Material::create([
            'user_id' => $user->id,
            'purchase_date' => now()->toDateString(),
            'type' => 'Bahan Utama',
            'name' => 'Kain Katun Combed 30s',
            'color' => 'Hitam',
            'price' => 120000,
            'purchase_volume' => 1,
            'unit' => 'kg',
            'stock_initial' => 0,
            'stock_in' => 1,
            'stock_out' => 0,
        ]);

        Material::create([
            'user_id' => $user->id,
            'purchase_date' => now()->toDateString(),
            'type' => 'Bahan Pendukung',
            'name' => 'Benang Jahit Polyester',
            'color' => 'Putih',
            'price' => 15000,
            'purchase_volume' => 5,
            'unit' => 'roll',
            'stock_initial' => 0,
            'stock_in' => 5,
            'stock_out' => 0,
        ]);

        $response = $this->actingAs($user)->get('/materials?search=Katun');

        $response->assertStatus(200);
        $response->assertSee('Kain Katun Combed 30s');
        $response->assertDontSee('Benang Jahit Polyester');
    }

    public function test_user_can_filter_materials_by_type()
    {
        $user = $this->createAuthorizedUser();

        Material::create([
            'user_id' => $user->id,
            'purchase_date' => now()->toDateString(),
            'type' => 'Bahan Utama',
            'name' => 'Kain Denim Stretch',
            'color' => 'Navy',
            'price' => 150000,
            'purchase_volume' => 2,
            'unit' => 'meter',
            'stock_initial' => 0,
            'stock_in' => 2,
            'stock_out' => 0,
        ]);

        Material::create([
            'user_id' => $user->id,
            'purchase_date' => now()->toDateString(),
            'type' => 'Bahan Lainnya',
            'name' => 'Label Woven Brand',
            'color' => 'Merah',
            'price' => 500,
            'purchase_volume' => 100,
            'unit' => 'pcs',
            'stock_initial' => 0,
            'stock_in' => 100,
            'stock_out' => 0,
        ]);

        $response = $this->actingAs($user)->get('/materials?type=Bahan+Utama');

        $response->assertStatus(200);
        $response->assertSee('Kain Denim Stretch');
        $response->assertDontSee('Label Woven Brand');
    }
}
