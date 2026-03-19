<?php

namespace App\Http\Controllers;

use App\Models\BusinessCalculation;
use App\Models\HppCalculation;
use App\Models\HppMaterialItem;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BusinessController extends Controller
{
    /**
     * Menampilkan riwayat perhitungan (Business Checker).
     */
    public function index()
    {
        $calculations = BusinessCalculation::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('business.index', compact('calculations'));
    }

    /**
     * Menampilkan halaman Input HPP.
     * MENGARAH KE: resources/views/business/hpp_create.blade.php
     */
    public function create()
    {
        // Muat bahan baku milik user untuk dropdown
        $materials = Material::where('user_id', Auth::id())->get();

        return view('business.hpp_create', compact('materials'));
    }

    /**
     * Memproses logika "Business Checker" (Rute: calculate).
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'hpp' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'est_batch_quantity' => 'required|integer',
        ]);

        $hpp = $request->hpp;
        $sellingPrice = $request->selling_price;
        $ads = $request->ads_per_unit ?? 0;
        $qty = $request->est_batch_quantity;

        $netProfitPerUnit = $sellingPrice - $hpp - $ads;
        $totalNetProfit = $netProfitPerUnit * $qty;
        $marginPercent = ($sellingPrice > 0) ? ($netProfitPerUnit / $sellingPrice) * 100 : 0;

        // Logic Verdict
        $status = $marginPercent >= 20 ? 'HEALTHY' : ($marginPercent > 0 ? 'RISKY' : 'DANGER');
        
        $reason = "Margin keuntungan " . number_format($marginPercent, 1) . "%.";
        $action = $status == 'HEALTHY' ? 'Bisnis sehat, silakan lanjut.' : 'Evaluasi harga atau biaya produksi.';

        $marginMatch = $sellingPrice - $hpp;
        $bepUnit = ($marginMatch > 0) ? ceil(($ads * $qty) / $marginMatch) : 0;

        BusinessCalculation::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'hpp' => $hpp,
            'selling_price' => $sellingPrice,
            'ads_per_unit' => $ads,
            'est_batch_quantity' => $qty,
            'net_profit' => $totalNetProfit,
            'net_margin_percent' => $marginPercent,
            'status_label' => $status,
            'logic_reason' => $reason,
            'action_required' => $action,
            'bep_unit' => $bepUnit
        ]);

        return redirect()->route('business.index')->with('success', 'Analisis berhasil disimpan!');
    }

    /**
     * Menyimpan hasil dari Kalkulator HPP (Rute: hpp.store).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'material_ids' => 'required|array|min:1',
            'material_ids.*' => 'required|integer|exists:materials,id',
            'usage_amounts' => 'required|array|min:1',
            'usage_amounts.*' => 'required|numeric|min:0',
            'screen_printing_fee' => 'nullable|numeric|min:0',
            'sewing_fee' => 'nullable|numeric|min:0',
            'other_fees' => 'nullable|numeric|min:0',
            'target_selling_price' => 'nullable|numeric|min:0',
        ]);

        $materialIds = $request->input('material_ids', []);
        $usages = $request->input('usage_amounts', []);

        $totalRaw = 0;
        $items = [];

        foreach ($materialIds as $idx => $matId) {
            $material = Material::where('user_id', Auth::id())->find($matId);
            if (! $material) {
                continue;
            }

            $usage = floatval($usages[$idx] ?? 0);
            $price = floatval($material->price);
            $subtotal = $price * $usage;

            $totalRaw += $subtotal;

            $items[] = [
                'material_id' => $material->id,
                'usage_amount' => $usage,
                'subtotal_cost' => $subtotal,
            ];
        }

        $screenPrinting = floatval($request->input('screen_printing_fee', 0));
        $sewing = floatval($request->input('sewing_fee', 0));
        $otherFees = floatval($request->input('other_fees', 0));

        $totalHpp = $totalRaw + $screenPrinting + $sewing + $otherFees;

        $calculation = HppCalculation::create([
            'user_id' => Auth::id(),
            'hpp_id' => 'BZS-' . strtoupper(uniqid()),
            'name' => $data['name'],
            'category' => $data['category'],
            'total_raw_material_cost' => $totalRaw,
            'screen_printing_fee' => $screenPrinting,
            'sewing_fee' => $sewing,
            'other_fees' => $otherFees,
            'total_hpp_per_unit' => $totalHpp,
            'target_selling_price' => floatval($request->input('target_selling_price', 0)),
        ]);

        foreach ($items as $item) {
            HppMaterialItem::create(array_merge($item, ['hpp_calculation_id' => $calculation->id]));
        }

        return redirect()->route('hpp.show', $calculation->id)->with('success', 'HPP calculation saved.');
    }

    public function show($id)
    {
        $hpp = HppCalculation::with('items.material')->where('user_id', Auth::id())->findOrFail($id);
        return view('business.hpp_show', compact('hpp'));
    }

    public function printPdf($id)
    {
        $hpp = HppCalculation::with('items.material')->where('user_id', Auth::id())->findOrFail($id);
        $pdf = Pdf::loadView('business.hpp_pdf', compact('hpp'));
        return $pdf->download("hpp-{$id}.pdf");
    }

    public function destroy($id)
    {
        $calc = BusinessCalculation::where('user_id', Auth::id())->findOrFail($id);
        $calc->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}