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
        
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found in ClarityLab database.'
            ], 404);
        }
        
        $client = new \App\Services\ScalevClient();
        $purchases = $client->getPurchasesByEmail($email);
        
        $synced_features = [];
        $matched_products = [];
        
        foreach ($purchases as $it) {
            $pid = $it['product_id'];
            $product = \App\Models\Product::where('slug', $pid)->first();
            if ($product) {
                $matched_products[] = $product->name;
                $features = $product->features ?? [];
                foreach ($features as $featureCode) {
                    $has = $user->accesses()->where('feature_code', $featureCode)->exists();
                    if (!$has) {
                        $user->accesses()->create([
                            'feature_code' => $featureCode,
                            'order_id' => null
                        ]);
                        $synced_features[] = $featureCode;
                    }
                }
            }
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Sync executed successfully!',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'purchases_found_count' => count($purchases),
            'matched_products' => $matched_products,
            'new_synced_features' => $synced_features,
            'all_user_accesses' => $user->accesses()->get()
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
