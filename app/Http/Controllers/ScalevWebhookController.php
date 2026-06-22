<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ScalevWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Scalev Webhook Received', $request->all());

        // Ekstrak email, nama, dan telepon secara dinamis
        $email = $request->input('email') ?? $request->input('customer.email') ?? $request->input('data.customer.email');
        $name = $request->input('name') ?? $request->input('customer.name') ?? $request->input('data.customer.name') ?? 'User';
        $phone = $request->input('phone') ?? $request->input('customer.phone') ?? $request->input('data.customer.phone') ?? null;
        
        // Ambil product_id atau dari array products[0].variant_id
        $productId = $request->input('product_id');
        if (!$productId) {
            $products = $request->input('products') ?? $request->input('data.products');
            if (is_array($products) && count($products) > 0) {
                $productId = $products[0]['variant_id'] ?? $products[0]['product_id'] ?? null;
            }
        }

        if (!$email || !$productId) {
            Log::info('Scalev Webhook Ping or Invalid Payload Received', $request->all());
            return response()->json([
                'message' => 'Scalev Webhook is active and reachable!',
                'status' => 'success'
            ], 200);
        }

        // 1. Cari Product berdasarkan slug
        $product = Product::where('slug', $productId)->first();

        if (!$product) {
            Log::warning("Scalev Webhook: Product ID {$productId} tidak ditemukan di database.");
            return response()->json(['message' => 'Product not found'], 404);
        }

        // 2. Create / Update User
        $user = User::where('email', $email)->first();

        $isNewUser = false;
        if (!$user) {
            $isNewUser = true;
            $randomPassword = Str::random(10);
            
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($randomPassword),
                'role' => 'user',
                'is_approved' => true // Asumsi user yang bayar otomatis di-approve
            ]);
        } else {
            // Update phone if it's set in the webhook and empty on the user
            if ($phone && !$user->phone) {
                $user->update(['phone' => $phone]);
            }
        }

        // 3. Create Order & OrderItem so it shows up in Purchase History and counts in stats
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'total_amount' => $product->price,
            'status' => 'success',
            'payment_method' => 'Scalev',
        ]);

        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
        ]);

        // 4. Assign Product Access (Pivot / User Access)
        // Ambil features dari product
        $features = $product->features ?? [];

        foreach ($features as $featureCode) {
            // Cek apakah user sudah punya akses ini
            $hasAccess = $user->accesses()->where('feature_code', $featureCode)->exists();
            if (!$hasAccess) {
                $user->accesses()->create([
                    'feature_code' => $featureCode,
                    'order_id' => $order->id,
                ]);
            }
        }

        // 4. Send Email
        if ($isNewUser) {
            // Karena sistem otomatis membuat akun, kami mengarahkan pengguna
            // untuk menggunakan fitur lupa password agar bisa mengatur password sendiri.
            try {
                $token = app('auth.password.broker')->createToken($user);
                $user->sendPasswordResetNotification($token);
                Log::info("Scalev Webhook: New user {$email} created and sent reset password link.");
            } catch (\Exception $e) {
                Log::error("Scalev Webhook: Failed to send password reset to {$email}. Error: " . $e->getMessage());
            }
        } else {
            Log::info("Scalev Webhook: Existing user {$email} updated with new product {$productId}.");
        }

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}
