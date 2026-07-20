<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\HppMaterialItem;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    /**
     * Daftar bahan baku milik user.
     */
    public function index(Request $request)
    {
        $query = Material::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('unit', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $materials = $query->orderBy('name')->get();
        return view('materials.index', compact('materials'));
    }

    /**
     * Simpan bahan baku baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'purchase_date' => 'required|date',
            'type' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'purchase_volume' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:100',
        ]);

        // Check if material with same name already exists
        $existingMaterial = Material::where('user_id', Auth::id())
                                    ->where('name', $data['name'])
                                    ->where('color', $data['color'] ?? null)
                                    ->first();

        if ($existingMaterial) {
            // Update existing material - only add to stock_in, keep stock_initial fixed
            $existingMaterial->update([
                'stock_in' => $existingMaterial->stock_in + $data['purchase_volume'],
                'purchase_date' => $data['purchase_date'],
                'price' => $data['price'],
                'purchase_volume' => $data['purchase_volume'],
            ]);
        } else {
            // Create new material - set stock_initial to 0, only stock_in increments
            Material::create([
                'user_id' => Auth::id(),
                'purchase_date' => $data['purchase_date'],
                'type' => $data['type'],
                'name' => $data['name'],
                'color' => $data['color'] ?? null,
                'price' => $data['price'],
                'purchase_volume' => $data['purchase_volume'],
                'unit' => $data['unit'],
                'stock_initial' => 0,
                'stock_in' => $data['purchase_volume'],
                'stock_out' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit bahan baku.
     */
    public function edit($id)
    {
        $material = Material::where('user_id', Auth::id())->findOrFail($id);
        return view('materials.edit', compact('material'));
    }

    /**
     * Update bahan baku.
     */
    public function update(Request $request, $id)
    {
        $material = Material::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'purchase_date' => 'required|date',
            'type' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'purchase_volume' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:100',
        ]);

        $material->update([
            'purchase_date' => $data['purchase_date'],
            'type' => $data['type'],
            'name' => $data['name'],
            'unit' => $data['unit'],
            'price' => $data['price'],
            'purchase_volume' => $data['purchase_volume'],
            'color' => $data['color'] ?? null,
        ]);

        if ($request->query('from') === 'hpp') {
            return redirect()->route('hpp.bahan', ['embed' => 1])->with('success', 'Bahan baku berhasil diperbarui.');
        }
        return redirect()->route('materials.index')->with('success', 'Bahan baku berhasil diperbarui.');
    }

    /**
     * Hapus bahan baku.
     */
    public function destroy(Request $request, $id)
    {
        $material = Material::where('user_id', Auth::id())->findOrFail($id);

        if (HppMaterialItem::where('material_id', $id)->exists()) {
            $redirect = $request->query('from') === 'hpp' ? redirect()->route('hpp.bahan', ['embed' => 1]) : redirect()->route('materials.index');
            return $redirect->with('error', 'Bahan tidak dapat dihapus karena digunakan pada perhitungan HPP. Hapus terlebih dahulu penggunaan pada HPP terkait.');
        }

        try {
            $material->delete();
            $redirect = $request->query('from') === 'hpp' ? redirect()->route('hpp.bahan', ['embed' => 1]) : redirect()->route('materials.index');
            return $redirect->with('success', 'Bahan baku berhasil dihapus.');
        } catch (QueryException $exception) {
            $redirect = $request->query('from') === 'hpp' ? redirect()->route('hpp.bahan', ['embed' => 1]) : redirect()->route('materials.index');
            return $redirect->with('error', 'Terjadi error saat menghapus bahan. Pastikan tidak terkait data lain.');
        }
    }
}

