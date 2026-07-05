<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Fix untuk error "CURL Error: SSL certificate problem" di localhost Windows
        // Serta fix untuk "Undefined array key 10023" (CURLOPT_HTTPHEADER) pada PHP 8
        Config::$curlOptions = [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [],
        ];
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak aktif.');
        }

        $user = auth()->user();

        // Admin tidak perlu membeli
        if ($user->isAdmin()) {
            return redirect()->route('dashboard')->with('success', 'Sebagai Admin, Anda memiliki akses penuh ke semua fitur tanpa perlu membeli. Silakan gunakan fitur melalui menu Dashboard.');
        }

        // Cek apakah user sudah memiliki akses ke semua fitur di dalam produk ini
        if ($product->features && is_array($product->features)) {
            $alreadyOwned = true;
            foreach ($product->features as $featureCode) {
                $exists = \App\Models\UserAccess::where('user_id', $user->id)
                    ->where('feature_code', $featureCode)
                    ->exists();
                if (!$exists) {
                    $alreadyOwned = false;
                    break;
                }
            }

            if ($alreadyOwned) {
                return redirect()->route('dashboard')->with('info', 'Anda sudah memiliki akses ke fitur ini. Silakan langsung menggunakannya dari Dashboard.');
            }
        }

        DB::beginTransaction();
        try {
            // Buat Order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $product->price,
                'status' => 'pending',
            ]);

            // Buat Order Item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->price,
            ]);

            // Persiapkan Data Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $product->price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
                'item_details' => [
                    [
                        'id' => $product->id,
                        'price' => $product->price,
                        'quantity' => 1,
                        'name' => $product->name,
                    ]
                ]
            ];

            $snapToken = Snap::getSnapToken($params);
            
            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return view('payment.checkout', compact('snapToken', 'order', 'product'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            $order = Order::find($request->order_id);
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                if ($order->status != 'success') {
                    $order->update([
                        'status' => 'success',
                        'payment_method' => $request->payment_type
                    ]);

                    // Berikan hak akses
                    $orderItem = $order->items()->first(); // Asumsi 1 order = 1 product
                    if ($orderItem) {
                        $product = $orderItem->product;
                        if ($product->features) {
                            foreach ($product->features as $featureCode) {
                                $fCode = strtolower($featureCode);
                                $existingAccess = UserAccess::where('user_id', $order->user_id)
                                    ->where('feature_code', $fCode)
                                    ->first();
                                
                                if ($product->type === 'trial_extension') {
                                    $expiresAt = now()->addDays(30);
                                    if ($existingAccess) {
                                        if ($existingAccess->is_trial) {
                                            $currentExpiry = $existingAccess->expires_at && $existingAccess->expires_at->greaterThan(now())
                                                ? $existingAccess->expires_at
                                                : now();
                                            $existingAccess->update([
                                                'expires_at' => $currentExpiry->addDays(30),
                                                'order_id' => $order->id,
                                            ]);
                                        }
                                    } else {
                                        UserAccess::create([
                                            'user_id' => $order->user_id,
                                            'feature_code' => $fCode,
                                            'order_id' => $order->id,
                                            'is_trial' => true,
                                            'expires_at' => $expiresAt,
                                            'granted_at' => now(),
                                        ]);
                                    }
                                } else {
                                    // Regular lifetime product
                                    if ($existingAccess) {
                                        if ($existingAccess->is_trial) {
                                            $existingAccess->update([
                                                'is_trial' => false,
                                                'expires_at' => null,
                                                'order_id' => $order->id,
                                            ]);
                                        }
                                    } else {
                                        UserAccess::create([
                                            'user_id' => $order->user_id,
                                            'feature_code' => $fCode,
                                            'order_id' => $order->id,
                                            'is_trial' => false,
                                            'expires_at' => null,
                                            'granted_at' => now(),
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            } else if ($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
                $order->update(['status' => 'failed']);
            }

            return response()->json(['message' => 'Success']);
        }

        return response()->json(['message' => 'Invalid signature'], 403);
    }
}
