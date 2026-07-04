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
        // 3. Extract all purchased product/variant IDs from Scalev payload
        $allPurchasedIds = [];
        if ($request->input('product_id')) {
            $allPurchasedIds[] = (string) $request->input('product_id');
        }
        $productsList = $request->input('products') ?? $request->input('data.products') ?? [];
        if (is_array($productsList)) {
            foreach ($productsList as $pItem) {
                $vId = $pItem['variant_id'] ?? $pItem['product_id'] ?? null;
                if ($vId) {
                    $allPurchasedIds[] = (string) $vId;
                }
            }
        }
        $allPurchasedIds = array_unique($allPurchasedIds);

        $pccBumpId = (string) config('services.scalev.pcc_bump_id');
        $vcpBumpId = (string) config('services.scalev.vcp_bump_id');
        $deBumpId  = (string) config('services.scalev.de_bump_id');

        $hasPccBump = !empty($pccBumpId) && in_array($pccBumpId, $allPurchasedIds);
        $hasVcpBump = !empty($vcpBumpId) && in_array($vcpBumpId, $allPurchasedIds);
        $hasDeBump  = !empty($deBumpId)  && in_array($deBumpId, $allPurchasedIds);

        $additionalAmount = 0;
        if ($hasPccBump) $additionalAmount += 49000;
        if ($hasVcpBump) $additionalAmount += 39000;
        if ($hasDeBump)  $additionalAmount += 49000;

        // Create Order & OrderItem
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'total_amount' => $product->price + $additionalAmount,
            'status' => 'success',
            'payment_method' => 'Scalev',
        ]);

        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'price' => $product->price,
        ]);

        // 4. Assign Main Product Access (Lifetime)
        $features = $product->features ?? [];
        $purchasedFeatureCodes = [];

        foreach ($features as $featureCode) {
            $fCode = strtolower($featureCode);
            $purchasedFeatureCodes[] = $fCode;

            $existingAccess = $user->accesses()->where('feature_code', $fCode)->first();
            if ($existingAccess) {
                if ($existingAccess->is_trial) {
                    $existingAccess->update([
                        'is_trial' => false,
                        'expires_at' => null,
                        'order_id' => $order->id,
                    ]);
                }
            } else {
                $user->accesses()->create([
                    'feature_code' => $fCode,
                    'order_id' => $order->id,
                    'is_trial' => false,
                    'expires_at' => null,
                ]);
            }
        }

        // 5. Grant Trial Bonuses
        $trialFeature = null;
        $duration = 7;

        if (in_array('pcc', $purchasedFeatureCodes) && in_array('de', $purchasedFeatureCodes) && !in_array('vcp', $purchasedFeatureCodes)) {
            // Clarity Essentials bundle -> VCP trial
            $trialFeature = 'vcp';
        } elseif (count($purchasedFeatureCodes) === 1) {
            $fCode = $purchasedFeatureCodes[0];
            if ($fCode === 'pcc') {
                $trialFeature = 'de';
                if ($hasPccBump) {
                    $duration = 37;
                }
            } elseif ($fCode === 'vcp') {
                $trialFeature = 'pcc';
                if ($hasVcpBump) {
                    $duration = 37;
                }
            } elseif ($fCode === 'de') {
                $trialFeature = 'pcc';
                if ($hasDeBump) {
                    $duration = 37;
                }
            }
        }

        if ($trialFeature) {
            $hasLifetime = $user->accesses()
                ->where('feature_code', $trialFeature)
                ->where('is_trial', false)
                ->exists();

            if (!$hasLifetime) {
                $expiresAt = now()->addDays($duration);
                $existingTrial = $user->accesses()
                    ->where('feature_code', $trialFeature)
                    ->where('is_trial', true)
                    ->first();

                if ($existingTrial) {
                    if ($existingTrial->expires_at && $expiresAt->greaterThan($existingTrial->expires_at)) {
                        $existingTrial->update([
                            'expires_at' => $expiresAt,
                            'order_id' => $order->id,
                        ]);
                    }
                } else {
                    $user->accesses()->create([
                        'feature_code' => $trialFeature,
                        'order_id' => $order->id,
                        'is_trial' => true,
                        'expires_at' => $expiresAt,
                    ]);
                }
            }
        }

        // 6. Send Email
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
