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
Route::middleware(['auth', 'verified'])->group(function () {
    
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
    Route::get('/business', [BusinessController::class, 'index'])->name('business.index');
    Route::post('/calculate', [BusinessController::class, 'calculate'])->name('calculate');
    Route::get('/hpp/create', [BusinessController::class, 'create'])->name('hpp.create');
    Route::post('/hpp/store', [BusinessController::class, 'store'])->name('hpp.store');

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