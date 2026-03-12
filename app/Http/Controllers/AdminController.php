<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BusinessCalculation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Method untuk menampilkan daftar user
    public function users()
    {
        // Ambil user dengan role 'user'
        $users = \App\Models\User::where('role', 'user')->get();
        // Ambil semua kalkulasi produk
        $allCalculations = \App\Models\BusinessCalculation::with('user')->latest()->get();
        return view('admin.dashboard', compact('users', 'allCalculations'));
    }

    // Method untuk menyetujui user
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => 1]);

        return back()->with('success', 'User berhasil disetujui!');
    }

    // Method untuk melihat semua produk yang dicoba user
    public function allProducts()
    {
        // Ambil data produk/kalkulasi dari project AVS Store
        $calculations = \App\Models\BusinessCalculation::with('user')->latest()->get();
        return view('admin.product', compact('calculations'));
    }
}