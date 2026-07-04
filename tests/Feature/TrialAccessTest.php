<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\UserAccess;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class TrialAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed products
        $this->seed(ProductSeeder::class);

        // Configure test bump IDs in services config
        Config::set('services.scalev.pcc_bump_id', 'pcc-bump-123');
        Config::set('services.scalev.vcp_bump_id', 'vcp-bump-123');
        Config::set('services.scalev.de_bump_id', 'de-bump-123');
    }

    public function test_purchase_pcc_gives_7_day_de_trial(): void
    {
        $payload = [
            'email' => 'buyer@example.com',
            'name' => 'John Doe',
            'phone' => '081234567890',
            'product_id' => '497385', // PCC
        ];

        $response = $this->postJson(route('scalev.webhook'), $payload);

        $response->assertStatus(200);

        $user = User::where('email', 'buyer@example.com')->first();
        $this->assertNotNull($user);

        // Check user has accesses
        $accesses = $user->accesses;
        $this->assertCount(2, $accesses);

        // Check PCC is lifetime
        $pccAccess = $accesses->where('feature_code', 'pcc')->first();
        $this->assertNotNull($pccAccess);
        $this->assertFalse($pccAccess->is_trial);
        $this->assertNull($pccAccess->expires_at);

        // Check DE is trial for 7 days
        $deAccess = $accesses->where('feature_code', 'de')->first();
        $this->assertNotNull($deAccess);
        $this->assertTrue($deAccess->is_trial);
        $this->assertNotNull($deAccess->expires_at);
        $this->assertTrue($deAccess->expires_at->isFuture());
        $this->assertEquals(now()->addDays(7)->toDateString(), $deAccess->expires_at->toDateString());
    }

    public function test_purchase_pcc_with_bump_gives_37_day_de_trial(): void
    {
        $payload = [
            'email' => 'buyer_bump@example.com',
            'name' => 'John Doe',
            'phone' => '081234567890',
            'product_id' => '497385', // PCC
            'products' => [
                ['variant_id' => '497385'],
                ['variant_id' => 'pcc-bump-123']
            ]
        ];

        $response = $this->postJson(route('scalev.webhook'), $payload);

        $response->assertStatus(200);

        $user = User::where('email', 'buyer_bump@example.com')->first();
        $this->assertNotNull($user);

        $deAccess = $user->accesses->where('feature_code', 'de')->first();
        $this->assertNotNull($deAccess);
        $this->assertTrue($deAccess->is_trial);
        $this->assertEquals(now()->addDays(37)->toDateString(), $deAccess->expires_at->toDateString());
    }

    public function test_middleware_blocks_expired_trial(): void
    {
        $user = User::factory()->create(['is_approved' => true]);

        // Create expired trial access to 'pcc'
        UserAccess::create([
            'user_id' => $user->id,
            'feature_code' => 'pcc',
            'is_trial' => true,
            'expires_at' => now()->subDay(), // Expired 1 day ago
            'granted_at' => now()->subDays(8),
        ]);

        $this->actingAs($user);

        // Should redirect back to front page because of expired access
        $response = $this->get('/business');
        $response->assertRedirect(route('welcome'));
        $response->assertSessionHas('error');
    }

    public function test_middleware_allows_active_trial(): void
    {
        $user = User::factory()->create(['is_approved' => true]);

        // Create active trial access to 'pcc'
        UserAccess::create([
            'user_id' => $user->id,
            'feature_code' => 'pcc',
            'is_trial' => true,
            'expires_at' => now()->addDays(5),
            'granted_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->get('/business');
        $response->assertStatus(200);
    }

    public function test_purchased_product_upgrades_existing_trial_to_lifetime(): void
    {
        $user = User::factory()->create(['email' => 'existing_trial@example.com', 'is_approved' => true]);

        // First grant a DE trial to this user
        UserAccess::create([
            'user_id' => $user->id,
            'feature_code' => 'de',
            'is_trial' => true,
            'expires_at' => now()->addDays(7),
            'granted_at' => now(),
        ]);

        // Now purchase DE main product through webhook
        $payload = [
            'email' => 'existing_trial@example.com',
            'name' => 'John Doe',
            'phone' => '081234567890',
            'product_id' => '497390', // DE product id
        ];

        $response = $this->postJson(route('scalev.webhook'), $payload);
        $response->assertStatus(200);

        // Check user access has been upgraded to lifetime
        $deAccess = $user->accesses()->where('feature_code', 'de')->first();
        $this->assertNotNull($deAccess);
        $this->assertFalse($deAccess->is_trial);
        $this->assertNull($deAccess->expires_at);
    }
}
