<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

// --- PENGATUR LALU LINTAS (Dashboard) ---
// Route ini yang dipanggil Laravel Breeze setelah login sukses
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.users');
    }
    return redirect()->route('business.index');
})->middleware(['auth'])->name('dashboard');


// --- AKSES USER (Wajib Login & Wajib Approved) ---
Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/viability-checker', [BusinessController::class, 'index'])->name('business.index');
    Route::post('/calculate', [BusinessController::class, 'store'])->name('calculate');
    Route::get('/print-pdf/{id}', [BusinessController::class, 'printPdf'])->name('print.pdf');
});


// --- AKSES ADMIN (Wajib Login & Role Admin) ---
// Admin dipisah dari middleware 'approved' agar tidak ikut terblokir
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    // Hilangkan kata 'admin' di depan /users karena sudah ada prefix
    Route::patch('/users/{id}/approve', [AdminController::class, 'approve'])->name('admin.users.approve');
    Route::get('/all-products', [AdminController::class, 'allProducts'])->name('admin.product');
});


// Route Menunggu Persetujuan (Halaman statis)
Route::get('/waiting-approval', function () {
    return view('errors.waiting_approval');
})->name('waiting.approval');

require __DIR__.'/auth.php';