<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| BIZSIGHT SECURE ROUTES
|--------------------------------------------------------------------------
*/

// 1. AKSES PUBLIK
Route::get('/', function () { 
    return view('welcome'); 
})->name('landing');

// 2. AKSES PROTEKSI (Hanya User Login yang bisa buka HPP & Checker)
// Laravel akan otomatis mengarahkan Tamu ke halaman Login jika mencoba akses rute di bawah ini.
Route::middleware(['auth', \App\Http\Middleware\CheckAppApproved::class])->group(function () {
    
    // Fitur Utama (Sekarang di dalam Auth agar tidak error layout)
    Route::get('/hpp-calculator', [BusinessController::class, 'hppCreate'])->name('hpp.create');
    Route::get('/viability-checker', [BusinessController::class, 'index'])->name('business.index');
    Route::get('/starter-kit', [BusinessController::class, 'downloadTemplate'])->name('download.template');

    // Proses Simpan Data
    Route::post('/calculate-viability', [BusinessController::class, 'store'])->name('calculate');
    Route::post('/save-hpp', [BusinessController::class, 'hppStore'])->name('hpp.store');
    
    // Cetak Laporan
    Route::get('/print-pdf/{id}', [BusinessController::class, 'printPdf'])->name('print.pdf');
    Route::get('/print-hpp/{id}', [BusinessController::class, 'hppPrint'])->name('hpp.print');

    // Dashboard Hub
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.users');
        }
        return redirect()->route('business.index');
    })->name('dashboard');
});

// 3. AKSES ADMIN
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/users/{id}/approve', [AdminController::class, 'approve'])->name('admin.users.approve');
    Route::get('/all-products', [AdminController::class, 'allProducts'])->name('admin.products');
});

// Rute Tunggu Approval
Route::get('/waiting-approval', function () {
    return view('errors.waiting_approval');
})->name('waiting.approval');

require __DIR__.'/auth.php';