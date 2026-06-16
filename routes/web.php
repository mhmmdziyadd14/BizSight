<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    $products = \App\Models\Product::all();
    return view('welcome', compact('products'));
})->name('welcome');

// Success Page for Scalev redirect
Route::get('/payment-success', function () {
    return view('payment-success');
})->name('payment.success');

// Product Notification
Route::post('/notify', [\App\Http\Controllers\ProductNotificationController::class, 'store'])->name('notify.store');

// Midtrans Webhook (No CSRF)
Route::post('/api/midtrans/callback', [PaymentController::class, 'callback'])->name('midtrans.callback');

// Scalev Webhook (No CSRF)
Route::post('/api/scalev/webhook', [\App\Http\Controllers\ScalevWebhookController::class, 'handleWebhook'])->name('scalev.webhook');

// Temporary DB Migration Route
Route::get('/migrasi-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true
        ]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response()->json([
            'status' => 'success',
            'message' => 'Database successfully migrated and seeded!',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Temporary Route to test Scalev API Sync
Route::get('/test-sync', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        
        $base = env('SCALEV_API_BASE');
        $key = env('SCALEV_API_KEY');
        $email = 'muhammadziyad810@gmail.com';
        
        $headers = [
            'Accept' => 'application/json',
        ];
        if ($key) {
            $headers['Authorization'] = 'Bearer ' . $key;
        }
        
        $found_order = null;
        $pages_scanned = 0;
        $last_id = null;
        $has_next = true;
        
        $all_scanned_emails = [];
        
        while ($has_next && $pages_scanned < 15) {
            $pages_scanned++;
            $url = rtrim($base, '/') . '/v2/order';
            
            $query = [];
            if ($last_id) {
                $query['last_id'] = $last_id;
            }
            
            $resp = \Illuminate\Support\Facades\Http::withHeaders($headers)
                ->timeout(10)
                ->get($url, $query);
            
            if (!$resp->ok()) {
                throw new \Exception("Scalev API error on page {$pages_scanned}: " . $resp->status());
            }
            
            $json = $resp->json();
            $data = $json['data'] ?? [];
            $results = $data['results'] ?? [];
            $has_next = $data['has_next'] ?? false;
            $last_id = $data['last_id'] ?? null;
            
            foreach ($results as $order) {
                $custEmail = $order['customer']['email'] ?? '';
                $all_scanned_emails[] = $custEmail;
                
                if (strtolower($custEmail) === strtolower($email)) {
                    $found_order = $order;
                    break 2; // break out of both foreach and while
                }
            }
            
            if (!$last_id) {
                $has_next = false;
            }
        }
        
        // Extract all keys and values related to product/id/slug/variant
        $product_related = [];
        if ($found_order) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($found_order));
            foreach ($iterator as $key => $value) {
                // Get path to this key
                $path = [];
                foreach (range(0, $iterator->getDepth()) as $depth) {
                    $path[] = $iterator->getSubIterator($depth)->key();
                }
                $pathStr = implode('.', $path);
                
                if (preg_match('/product|variant|item|slug|id|name/i', $key)) {
                    $product_related[$pathStr] = $value;
                }
            }
        }
        
        return response()->json([
            'status' => 'success',
            'email' => $email,
            'pages_scanned' => $pages_scanned,
            'found' => !is_null($found_order),
            'product_related_fields' => $product_related
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Middleware Auth
Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- FITUR ADMIN (Prefix /admin) ---
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/product', [AdminController::class, 'product'])->name('admin.product');

        // Rute untuk Approve User (WAJIB ADA untuk tombol Grant Access)
        Route::patch('/users/{id}/approve', [AdminController::class, 'approve'])->name('admin.users.approve');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');

        // Product Notifications
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    });

    // --- FITUR BUSINESS & HPP (Profit Clarity Calculator - PCC) ---
    Route::middleware('feature:PCC')->group(function () {
        Route::get('/business', [BusinessController::class, 'index'])->name('business.index');
        Route::get('/hpp/create', [BusinessController::class, 'create'])->name('hpp.create');
        Route::get('/hpp/bahan', [BusinessController::class, 'bahan'])->name('hpp.bahan');
        Route::post('/hpp/store', [BusinessController::class, 'store'])->name('hpp.store');
        Route::get('/hpp', [BusinessController::class, 'hppIndex'])->name('hpp.index');
        Route::get('/hpp/products', [BusinessController::class, 'products'])->name('hpp.products');
        Route::get('/hpp/inventory', [BusinessController::class, 'inventory'])->name('hpp.inventory');
        Route::get('/hpp/bom', [BusinessController::class, 'bom'])->name('hpp.bom');
        Route::get('/hpp/{id}/print', [BusinessController::class, 'printHppPdf'])->name('hpp.print');
        Route::get('/hpp/{id}/bom/print', [BusinessController::class, 'printBomPdf'])->name('hpp.bom.print');
        Route::get('/hpp/{id}', [BusinessController::class, 'show'])->name('hpp.show');
        Route::get('/hpp/{id}/edit', [BusinessController::class, 'edit'])->name('hpp.edit');
        Route::put('/hpp/{id}', [BusinessController::class, 'update'])->name('hpp.update');
        Route::delete('/hpp/{id}', [BusinessController::class, 'destroyHpp'])->name('hpp.destroy');
        
        // Materials (Bagian dari HPP)
        Route::get('/materials', [\App\Http\Controllers\MaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/{id}/edit', [\App\Http\Controllers\MaterialController::class, 'edit'])->name('materials.edit');
        Route::put('/materials/{id}', [\App\Http\Controllers\MaterialController::class, 'update'])->name('materials.update');
        Route::post('/materials', [\App\Http\Controllers\MaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materials/{id}', [\App\Http\Controllers\MaterialController::class, 'destroy'])->name('materials.destroy');
    });

    // --- FITUR DECISION ENGINE (DE) ---
    Route::middleware('feature:DE')->group(function () {
        Route::get('/decisions', [BusinessController::class, 'decisionsList'])->name('decisions.list');
        Route::get('/decisions/{id}', [BusinessController::class, 'showDecision'])->name('decisions.show');
        Route::get('/business/{id}/print', [BusinessController::class, 'printDecisionEnginePdf'])->name('business.print');
        Route::post('/calculate', [BusinessController::class, 'calculate'])->name('calculate');
        Route::get('/print-pdf/{id}', [BusinessController::class, 'printPdf'])->name('print.pdf');
        Route::delete('/business/{id}', [BusinessController::class, 'destroy'])->name('business.destroy');
    });

    // --- FITUR VISUAL CLARITY PACK (VCP) ---
    Route::middleware('feature:VCP')->group(function () {
        Route::get('/clarity-visual/list', [BusinessController::class, 'visualList'])->name('visual.list');
        Route::get('/clarity-visual/{id?}', [BusinessController::class, 'clarityVisual'])->name('clarity.visual');
        Route::post('/business/visual', [BusinessController::class, 'storeVisual'])->name('business.store-visual');
        Route::post('/clarity-visual/analyze', [BusinessController::class, 'analyzeImage'])->name('visual.analyze');
        Route::delete('/business/visual/{id}', [BusinessController::class, 'destroyVisual'])->name('visual.destroy');
        Route::get('/download-template', function () {
            return response()->json(['status' => 'success', 'message' => 'Resource siap']);
        })->name('download.template');

            // Lightweight polling API endpoints for realtime UI updates
            Route::get('/api/hpp/list', [BusinessController::class, 'apiHppList'])->name('api.hpp.list');
            Route::get('/api/materials/list', [BusinessController::class, 'apiMaterialsList'])->name('api.materials.list');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
