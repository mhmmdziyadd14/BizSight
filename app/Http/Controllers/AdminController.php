<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BusinessCalculation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Admin.
     */
    public function index()
    {
        // Mengambil semua user (untuk statistik dan tabel otorisasi)
        // Kita urutkan agar yang belum di-approve muncul di atas
        $users = User::orderBy('is_approved', 'asc')->get();

        // Mengambil semua perhitungan bisnis dari seluruh pengguna (global monitoring)
        $allCalculations = BusinessCalculation::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('users', 'allCalculations'));
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
     * Halaman manajemen user (opsional jika dipisah).
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Halaman monitoring produk (opsional jika dipisah).
     */
    public function product()
    {
        $allCalculations = BusinessCalculation::with('user')->get();
        return view('admin.product', compact('allCalculations'));
    }
}