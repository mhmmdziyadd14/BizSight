<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BusinessCalculation;
use App\Models\UserAccess;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Admin.
     */
    public function index()
    {
        $users = User::with('accesses')->orderBy('created_at', 'desc')->get();
        $allCalculations = BusinessCalculation::with('user')->orderBy('created_at', 'desc')->get();

        // Hitung statistik per fitur
        $featureStats = [
            'vcp' => UserAccess::where('feature_code', 'vcp')->count(),
            'pcc' => UserAccess::where('feature_code', 'pcc')->count(),
            'de' => UserAccess::where('feature_code', 'de')->count(),
        ];

        // Inisialisasi statistik produk detail
        $productStats = [
            'pcc' => ['name' => 'Profit Clarity Calculator', 'buyers' => 0, 'revenue' => 0],
            'de' => ['name' => 'Decision Engine', 'buyers' => 0, 'revenue' => 0],
            'vcp' => ['name' => 'Visual Clarity Pack', 'buyers' => 0, 'revenue' => 0],
        ];

        // Hitung secara dinamis
        foreach ($users as $user) {
            if ($user->isAdmin()) {
                continue;
            }

            $accesses = $user->accesses;
            if ($accesses->isEmpty()) {
                continue;
            }

            $midtransAccesses = $accesses->whereNotNull('order_id');
            $scalevAccesses = $accesses->whereNull('order_id');

            // 1. Process Midtrans orders
            if ($midtransAccesses->isNotEmpty()) {
                $orderIds = $midtransAccesses->pluck('order_id')->unique();
                foreach ($orderIds as $orderId) {
                    $order = Order::with('items.product')->find($orderId);
                    if ($order && $order->status === 'success') {
                        foreach ($order->items as $item) {
                            $prod = $item->product;
                            if ($prod) {
                                if ($prod->type === 'bundle') {
                                    $features = $prod->features;
                                    $numFeatures = count($features);
                                    if ($numFeatures > 0) {
                                        $share = $item->price / $numFeatures;
                                        foreach ($features as $f) {
                                            $fCode = strtolower($f);
                                            if (isset($productStats[$fCode])) {
                                                $productStats[$fCode]['revenue'] += $share;
                                            }
                                        }
                                    }
                                } else {
                                    $fCode = strtolower($prod->features[0] ?? '');
                                    if (isset($productStats[$fCode])) {
                                        $productStats[$fCode]['revenue'] += $item->price;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            // 2. Process Scalev / manual accesses
            if ($scalevAccesses->isNotEmpty()) {
                $featureCodes = $scalevAccesses->pluck('feature_code')->map(fn($c) => strtolower($c))->toArray();
                
                $hasPcc = in_array('pcc', $featureCodes);
                $hasDe = in_array('de', $featureCodes);
                $hasVcp = in_array('vcp', $featureCodes);

                if ($hasPcc && $hasDe && $hasVcp) {
                    $share = 389000 / 3;
                    $productStats['pcc']['revenue'] += $share;
                    $productStats['de']['revenue'] += $share;
                    $productStats['vcp']['revenue'] += $share;
                } elseif ($hasPcc && $hasDe) {
                    $share = 279000 / 2;
                    $productStats['pcc']['revenue'] += $share;
                    $productStats['de']['revenue'] += $share;
                } else {
                    if ($hasPcc) {
                        $productStats['pcc']['revenue'] += 149000;
                    }
                    if ($hasDe) {
                        $productStats['de']['revenue'] += 249000;
                    }
                    if ($hasVcp) {
                        $productStats['vcp']['revenue'] += 149000;
                    }
                }
            }

            // 3. Count buyers
            $userFeatures = $accesses->pluck('feature_code')->map(fn($c) => strtolower($c))->unique();
            foreach ($userFeatures as $fCode) {
                if (isset($productStats[$fCode])) {
                    $productStats[$fCode]['buyers']++;
                }
            }
        }

        return view('admin.dashboard', compact('users', 'allCalculations', 'featureStats', 'productStats'));
    }

    /**
     * Menyetujui akses pengguna (Otorisasi).
     */
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('success', 'User access granted successfully.');
    }

    /**
     * Mengupdate detail user (Email/Nama).
     */
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'User details updated successfully.');
    }

    /**
     * Halaman manajemen user.
     */
    public function users()
    {
        $users = User::with('accesses')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Halaman monitoring produk.
     */
    public function product()
    {
        $allCalculations = BusinessCalculation::with('user')->get();
        return view('admin.product', compact('allCalculations'));
    }

    /**
     * Halaman daftar Product Notifications (Notify Me).
     */
    public function notifications()
    {
        $notifications = \App\Models\ProductNotification::latest()->get();
        return view('admin.notifications', compact('notifications'));
    }
}