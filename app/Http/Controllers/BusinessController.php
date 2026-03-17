<?php

namespace App\Http\Controllers;

use App\Models\BusinessCalculation;
use App\Models\Material; // Pastikan model ini sudah ada
use App\Models\HppCalculation;
use App\Models\HppMaterialItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Halaman Utama Business Checker (Viability Checker)
     * Bisa diakses oleh Tamu (Guest)
     */
    public function index()
    {
        // Ambil riwayat kalkulasi hanya jika user login
        $calculations = collect();
        if (auth()->check()) {
            $calculations = BusinessCalculation::where('user_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('business.index', compact('calculations'));
    }

    /**
     * Halaman Form Pembuatan HPP
     * Bisa diakses oleh Tamu (Guest)
     */
    public function hppCreate()
    {
        // Ambil daftar bahan baku jika ada
        $materials = collect();
        if (auth()->check()) {
            $materials = Material::where('user_id', auth()->id())->get();
        }

        return view('business.hpp_create', compact('materials'));
    }

    /**
     * Fungsi Download Template
     */
    public function downloadTemplate()
    {
        $file = public_path('documents/BizSight_Starter_Kit.zip');
        
        if (!file_exists($file)) {
            return back()->with('error', 'File template belum tersedia di server.');
        }

        return response()->download($file);
    }

    // ... method store dan lain-lain tetap di bawah proteksi auth

    /**
     * Simpan hasil perhitungan business viability ke database
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'hpp' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'ads_per_unit' => 'required|numeric|min:0',
            'est_batch_quantity' => 'required|integer|min:1',
        ]);

        // tambahan fee ops bila dikirim (form belum ada)
        $data['operational_fee'] = $request->input('operational_fee', 0);

        // hitung profit per unit
        $netProfit = $data['selling_price'] - $data['hpp'] - $data['ads_per_unit'] - $data['operational_fee'];
        $netMargin = $data['selling_price'] > 0
            ? ($netProfit / $data['selling_price']) * 100
            : 0;

        // hitung BEP (unit) sederhana: biaya tetap dibagi margin per unit
        $unitMargin = $data['selling_price'] - $data['hpp'];
        $totalAdsCost = $data['ads_per_unit'] * $data['est_batch_quantity'];
        $bepUnit = $unitMargin > 0
            ? (int) ceil(($totalAdsCost + $data['operational_fee']) / $unitMargin)
            : 0;

        // sederhana menilai status
        if ($netProfit <= 0) {
            $status = 'Unprofitable';
            $reason = 'Cost lebih besar dari harga jual.';
            $action = 'Kurangi biaya atau naikkan harga jual.';
        } else {
            $status = 'Healthy';
            $reason = 'Profit positif per unit.';
            $action = 'Tingkatkan volume penjualan untuk memaksimalkan keuntungan.';
        }

        BusinessCalculation::create(array_merge($data, [
            'user_id' => auth()->id(),
            'net_profit' => $netProfit,
            'net_margin_percent' => round($netMargin, 2),
            'bep_unit' => $bepUnit,
            'status_label' => $status,
            'logic_reason' => $reason,
            'action_required' => $action,
            'hpp_calculation_id' => null, // not linked yet
        ]));

        return redirect()->route('business.index')->with('success', 'Calculation saved.');
    }

    /**
     * HPP calculation saving
     */
    public function hppStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'materials' => 'array',
            'usage' => 'array',
        ]);

        $materials = $request->input('materials', []);
        $usage = $request->input('usage', []);
        $totalRaw = 0;

        foreach ($materials as $i => $matId) {
            $price = Material::find($matId)?->unit_price ?? 0;
            $totalRaw += $price * ($usage[$i] ?? 0);
        }

        $calculation = HppCalculation::create([
            'user_id' => auth()->id(),
            'hpp_id' => 'BZS-' . strtoupper(uniqid()),
            'name' => $request->name,
            'category' => $request->category,
            'total_raw_material_cost' => $totalRaw,
            'screen_printing_fee' => $request->input('screen_printing_fee', 0),
            'sewing_fee' => $request->input('sewing_fee', 0),
            'other_fees' => 0,
            'total_hpp_per_unit' => $totalRaw + $request->input('screen_printing_fee', 0) + $request->input('sewing_fee', 0),
            'target_selling_price' => 0,
        ]);

        foreach ($materials as $i => $matId) {
            $price = Material::find($matId)?->unit_price ?? 0;
            HppMaterialItem::create([
                'hpp_calculation_id' => $calculation->id,
                'material_id' => $matId,
                'usage_amount' => $usage[$i] ?? 0,
                'subtotal_cost' => $price * ($usage[$i] ?? 0),
            ]);
        }

        return redirect()->route('hpp.create')->with('success', 'HPP calculation saved.');
    }

    /**
     * PDF report for business calculation
     */
    public function printPdf($id)
    {
        $calc = BusinessCalculation::findOrFail($id);
        $pdf = Pdf::loadView('business.pdf', compact('calc'));
        return $pdf->download("business-{$id}.pdf");
    }

    /**
     * PDF report for HPP calculation
     */
    public function hppPrint($id)
    {
        $hpp = HppCalculation::with('items.material')->findOrFail($id);
        $pdf = Pdf::loadView('business.hpp_pdf', compact('hpp'));
        return $pdf->download("hpp-{$id}.pdf");
    }
}
