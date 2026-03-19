<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    /**
     * Daftar bahan baku milik user.
     */
    public function index()
    {
        $materials = Material::where('user_id', Auth::id())->orderBy('name')->get();
        return view('materials.index', compact('materials'));
    }

    /**
     * Simpan bahan baku baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:100',
        ]);

        Material::create([
            'user_id' => Auth::id(),
            'purchase_date' => now()->toDateString(),
            'type' => 'General',
            'name' => $data['name'],
            'color' => $data['color'] ?? null,
            'price' => $data['price'],
            'purchase_volume' => 1,
            'unit' => $data['unit'],
        ]);

        return redirect()->route('materials.index')->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    /**
     * Hapus bahan baku.
     */
    public function destroy($id)
    {
        $material = Material::where('user_id', Auth::id())->findOrFail($id);
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Bahan baku berhasil dihapus.');
    }
}
