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

        // HPP list hanya digunakan untuk mengisi pilihan HPP yang sudah dibuat (bukan untuk ditampilkan di halaman Business)
        $hppOptions = HppCalculation::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('business.index', compact('calculations', 'hppOptions'));
    }

    /**
     * Menampilkan halaman daftar HPP.
     */
    public function hppIndex()
    {
        $hppCalculations = HppCalculation::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('business.hpp_index', compact('hppCalculations'));
    }

    /**
     * Menampilkan halaman Bahan (Material) untuk HPP.
     */
    public function bahan()
    {
        $materials = Material::where('user_id', Auth::id())
                        ->orderBy('name')
                        ->get();

        return view('business.hpp_bahan', compact('materials'));
    }

    /**
     * Menampilkan data produk (HPP master).
     */
    public function products()
    {
        $products = HppCalculation::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('business.hpp_products', compact('products'));
    }

    /**
     * Menampilkan data persediaan bahan (Inventory).
     */
    public function inventory()
    {
        $materials = Material::where('user_id', Auth::id())
                        ->orderBy('name')
                        ->get();

        return view('business.hpp_inventory', compact('materials'));
    }

    /**
     * Menampilkan Bill of Material (BOM) data.
     */
    public function bom()
    {
        $bomList = HppCalculation::with('items.material')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('business.hpp_bom', compact('bomList'));
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
            'ads_per_unit' => 'nullable|numeric|min:0',
            'admin_fee_percent' => 'nullable|numeric|min:0|max:100',
            'overhead_percent' => 'nullable|numeric|min:0|max:100',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'promo_percent' => 'nullable|numeric|min:0|max:100',
            'est_batch_quantity' => 'required|integer',
        ]);

        $hpp = $request->hpp;
        $sellingPrice = $request->selling_price;
        $ads = $request->ads_per_unit ?? 0;
        $adminFeePct = $request->admin_fee_percent ?? 0;
        $overheadPct = $request->overhead_percent ?? 0;
        $taxPct = $request->tax_percent ?? 0;
        $promoPct = $request->promo_percent ?? 0;
        $qty = $request->est_batch_quantity;

        // Total biaya (menambahkan biaya admin, overhead, dan pajak sebagai persen di atas HPP)
        $costMultiplier = 1 + ($adminFeePct + $overheadPct + $taxPct) / 100;
        $totalCostPerUnit = $hpp * $costMultiplier;

        // Margin normal (tanpa promo)
        $netProfitPerUnit = $sellingPrice - $totalCostPerUnit - $ads;
        $totalNetProfit = $netProfitPerUnit * $qty;
        $marginPercent = ($sellingPrice > 0) ? ($netProfitPerUnit / $sellingPrice) * 100 : 0;

        // Margin setelah promo
        $sellingPricePromo = $sellingPrice * (1 - ($promoPct / 100));
        $netProfitPromoPerUnit = $sellingPricePromo - $totalCostPerUnit - $ads;
        $promoMarginPercent = ($sellingPricePromo > 0) ? ($netProfitPromoPerUnit / $sellingPricePromo) * 100 : 0;

        // Perbandingan margin normal vs promo
        $marginDiffPercent = $marginPercent - $promoMarginPercent;

        // Logic Verdict (berdasarkan margin promo)
        $status = $promoMarginPercent >= 20 ? 'HEALTHY' : ($promoMarginPercent > 0 ? 'RISKY' : 'DANGER');
        
        $reason = "Margin keuntungan " . number_format($promoMarginPercent, 1) . "%.";
        $action = $status == 'HEALTHY' ? 'Bisnis sehat, silakan lanjut.' : 'Evaluasi harga atau biaya produksi.';

        $marginMatch = $sellingPrice - $totalCostPerUnit;
        $bepUnit = ($marginMatch > 0) ? ceil(($ads * $qty) / $marginMatch) : 0;

        BusinessCalculation::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'hpp' => $hpp,
            'selling_price' => $sellingPrice,
            'ads_per_unit' => $ads,
            'admin_fee_percent' => $adminFeePct,
            'overhead_percent' => $overheadPct,
            'tax_percent' => $taxPct,
            'promo_percent' => $promoPct,
            'operational_fee' => 0, // default karena Business Checker tidak meminta input ini
            'est_batch_quantity' => $qty,
            'net_profit' => $totalNetProfit,
            'net_margin_percent' => $marginPercent,
            'promo_margin_percent' => $promoMarginPercent,
            'margin_diff_percent' => $marginDiffPercent,
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
            'hpp_id' => 'nullable|string|max:100|unique:hpp_calculations,hpp_id',
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
            $unitPrice = $material->purchase_volume > 0
                ? ($material->price / $material->purchase_volume)
                : $material->price;
            $subtotal = $unitPrice * $usage;

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
            'hpp_id' => $data['hpp_id'] ?? ('BZS-' . strtoupper(uniqid())),
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

        return redirect()->route('hpp.index')->with('success', 'HPP calculation saved.');
    }

    public function show($id)
    {
        $hpp = HppCalculation::with('items.material')->where('user_id', Auth::id())->findOrFail($id);
        return view('business.hpp_show', compact('hpp'));
    }

    public function printPdf($id)
    {
        $hpp = HppCalculation::with('items.material')->where('user_id', Auth::id())->findOrFail($id);

        if (! $hpp->printed_at) {
            $hpp->printed_at = now();
            $hpp->save();
        }

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