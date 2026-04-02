<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Middleware Auth
Route::middleware(['auth', 'verified', 'approved'])->group(function () {
    
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
    });

    // --- FITUR BUSINESS & HPP ---
    // Halaman List HPP (Index)
    Route::get('/business', [BusinessController::class, 'index'])->name('business.index');
    // Halaman Form HPP (Sesuai nama file Anda: hpp_create)
    Route::get('/hpp/create', [BusinessController::class, 'create'])->name('hpp.create');
    Route::get('/hpp/bahan', [BusinessController::class, 'bahan'])->name('hpp.bahan');
    // Proses Simpan HPP
    Route::post('/hpp/store', [BusinessController::class, 'store'])->name('hpp.store');
    // Daftar HPP (List)
    Route::get('/hpp', [BusinessController::class, 'hppIndex'])->name('hpp.index');
    // Data Produk (HPP master)
    Route::get('/hpp/products', [BusinessController::class, 'products'])->name('hpp.products');
    // Data Persediaan Bahan
    Route::get('/hpp/inventory', [BusinessController::class, 'inventory'])->name('hpp.inventory');
    // Bill of Material (BOM)
    Route::get('/hpp/bom', [BusinessController::class, 'bom'])->name('hpp.bom');
    // Cetak PDF HPP
    Route::get('/hpp/{id}/print', [BusinessController::class, 'printPdf'])->name('hpp.print');
    // Lihat detail hasil HPP
    Route::get('/hpp/{id}', [BusinessController::class, 'show'])->name('hpp.show');

    // --- FITUR BAHAN BAKU (MATERIALS) ---
    Route::get('/materials', [\App\Http\Controllers\MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{id}/edit', [\App\Http\Controllers\MaterialController::class, 'edit'])->name('materials.edit');
    Route::put('/materials/{id}', [\App\Http\Controllers\MaterialController::class, 'update'])->name('materials.update');
    Route::post('/materials', [\App\Http\Controllers\MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{id}', [\App\Http\Controllers\MaterialController::class, 'destroy'])->name('materials.destroy');

    // --- FITUR HPP CALCULATION (CRUD) ---
    Route::get('/hpp/{id}/edit', [BusinessController::class, 'edit'])->name('hpp.edit');
    Route::put('/hpp/{id}', [BusinessController::class, 'update'])->name('hpp.update');
    Route::delete('/hpp/{id}', [BusinessController::class, 'destroyHpp'])->name('hpp.destroy');

    // Proses Kalkulasi Cepat (Business Checker)
    Route::post('/calculate', [BusinessController::class, 'calculate'])->name('calculate');

    // Utility
    Route::get('/print-pdf/{id}', [BusinessController::class, 'printPdf'])->name('print.pdf');
    Route::delete('/business/{id}', [BusinessController::class, 'destroy'])->name('business.destroy');
    Route::get('/download-template', function() {
        return response()->json(['status' => 'success', 'message' => 'Resource siap']);
    })->name('download.template');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';