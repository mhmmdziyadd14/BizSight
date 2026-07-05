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
        // Configure test bump IDs in services config (Must be set BEFORE seeding so ProductSeeder uses these slugs)
        Config::set('services.scalev.pcc_bump_id', 'pcc-bump-123');
        Config::set('services.scalev.vcp_bump_id', 'vcp-bump-123');
        Config::set('services.scalev.de_bump_id', 'de-bump-123');
        Config::set('services.scalev.webhook_secret', null);

        // Seed products
        $this->seed(ProductSeeder::class);
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

    public function test_webhook_blocks_without_secret_when_configured(): void
    {
        // Set secret
        Config::set('services.scalev.webhook_secret', 'secret-token-xyz');

        $payload = [
            'email' => 'buyer@example.com',
            'name' => 'John Doe',
            'phone' => '081234567890',
            'product_id' => '497385', // PCC
        ];

        // 1. Sending without secret should get 401
        $response = $this->postJson(route('scalev.webhook'), $payload);
        $response->assertStatus(401);

        // 2. Sending with wrong secret should get 401
        $response = $this->postJson(route('scalev.webhook') . '?secret=wrong-secret', $payload);
        $response->assertStatus(401);

        // 3. Sending with correct secret should get 200
        $response = $this->postJson(route('scalev.webhook') . '?secret=secret-token-xyz', $payload);
        $response->assertStatus(200);
    }

    public function test_purchase_trial_extension_via_webhook(): void
    {
        // 1. Create a user
        $user = User::create([
            'name' => 'Trial Buyer',
            'email' => 'trial_buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Buy a trial extension standalone (slug: de-bump-123 which is PCC extension)
        $payload = [
            'email' => 'trial_buyer@example.com',
            'name' => 'Trial Buyer',
            'phone' => '081234567890',
            'product_id' => 'de-bump-123', // DE bump key (PCC extension)
        ];

        $response = $this->postJson(route('scalev.webhook'), $payload);
        $response->assertStatus(200);

        // 3. User should have trial access to PCC (expires in 30 days)
        $pccAccess = $user->accesses()->where('feature_code', 'pcc')->first();
        $this->assertNotNull($pccAccess);
        $this->assertTrue($pccAccess->is_trial);
        $this->assertNotNull($pccAccess->expires_at);
        $this->assertTrue($pccAccess->expires_at->isAfter(now()->addDays(29)));
    }

    public function test_purchase_trial_extension_via_midtrans(): void
    {
        $user = User::create([
            'name' => 'Midtrans Trial Buyer',
            'email' => 'midtrans_trial_buyer@example.com',
            'password' => bcrypt('password'),
        ]);

        $product = Product::where('name', 'Decision Engine - 30 Days Extension')->first();

        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'total_amount' => $product->price,
            'status' => 'pending',
        ]);

        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
        ]);

        // Mock Midtrans Callback
        $serverKey = config('midtrans.server_key');
        $statusCode = '200';
        $grossAmount = $product->price;
        $signature = hash("sha512", $order->id . $statusCode . $grossAmount . $serverKey);

        $payload = [
            'order_id' => $order->id,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
        ];

        $response = $this->postJson(route('midtrans.callback'), $payload);
        $response->assertStatus(200);

        // Check user access has been granted trial
        $deAccess = $user->accesses()->where('feature_code', 'de')->first();
        $this->assertNotNull($deAccess);
        $this->assertTrue($deAccess->is_trial);
        $this->assertNotNull($deAccess->expires_at);
        $this->assertTrue($deAccess->expires_at->isAfter(now()->addDays(29)));
    }
}
