<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BusinessCalculation;
use App\Models\UserAccess;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Admin.
     */
    public function index()
    {
        $users = User::with('accesses')->orderBy('is_approved', 'asc')->get();
        $allCalculations = BusinessCalculation::with('user')->orderBy('created_at', 'desc')->get();

        // Hitung statistik per fitur
        $featureStats = [
            'vcp' => UserAccess::where('feature_code', 'vcp')->count(),
            'pcc' => UserAccess::where('feature_code', 'pcc')->count(),
            'de' => UserAccess::where('feature_code', 'de')->count(),
        ];

        return view('admin.dashboard', compact('users', 'allCalculations', 'featureStats'));
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
}