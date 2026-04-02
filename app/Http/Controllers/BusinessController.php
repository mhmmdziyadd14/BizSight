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
        
        // Kelompokkan bahan berdasarkan nama untuk menampilkan warna sebagai dropdown
        $materialsByName = $materials->groupBy('name')->map(function($group) {
            return [
                'name' => $group->first()->name,
                'type' => $group->first()->type,
                'unit' => $group->first()->unit,
                'colors' => $group->map(function($material) {
                    return [
                        'id' => $material->id,
                        'color' => $material->color,
                        'price' => $material->price
                    ];
                })->toArray()
            ];
        })->values();

        return view('business.hpp_create', compact('materials', 'materialsByName'));
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
            'ads_percent' => 'nullable|numeric|min:0|max:100',
            'affiliate_percent' => 'nullable|numeric|min:0|max:100',
            'admin_fee_percent' => 'nullable|numeric|min:0|max:100',
            'overhead_percent' => 'nullable|numeric|min:0|max:100',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'promo_percent' => 'nullable|numeric|min:0|max:100',
            'est_batch_quantity' => 'required|integer|min:1',
        ]);

        $hpp = (float) $request->hpp;
        $sellingPrice = (float) $request->selling_price;
        $adsPct = (float) ($request->ads_percent ?? 0);
        $affiliatePct = (float) ($request->affiliate_percent ?? 0);
        $adminFeePct = (float) ($request->admin_fee_percent ?? 0);
        $overheadPct = (float) ($request->overhead_percent ?? 0);
        $taxPct = (float) ($request->tax_percent ?? 0);
        $promoPct = (float) ($request->promo_percent ?? 0);
        $qty = (int) $request->est_batch_quantity;

        // Biaya langsung per unit termasuk biaya proportional
        $costMultiplier = 1 + ($adminFeePct + $overheadPct + $taxPct + $affiliatePct) / 100;
        $totalCostPerUnit = $hpp * $costMultiplier;

        // Ads disesuaikan dalam persen terhadap harga jual
        $adsPerUnit = ($sellingPrice * $adsPct) / 100;

        // Margin normal (tanpa promo)
        $netProfitPerUnit = $sellingPrice - $totalCostPerUnit - $adsPerUnit;
        $totalNetProfit = $netProfitPerUnit * $qty;
        $marginPercent = ($sellingPrice > 0) ? ($netProfitPerUnit / $sellingPrice) * 100 : 0;

        // Margin setelah promo
        $sellingPricePromo = $sellingPrice * (1 - ($promoPct / 100));
        $netProfitPromoPerUnit = $sellingPricePromo - $totalCostPerUnit - $adsPerUnit;
        $promoMarginPercent = ($sellingPricePromo > 0) ? ($netProfitPromoPerUnit / $sellingPricePromo) * 100 : 0;

        // Perbandingan margin normal vs promo
        $marginDiffPercent = $marginPercent - $promoMarginPercent;

        // Logika status (CRITICAL/FRAGILE/HEALTHY) sesuai batas baru 20-34-40
        if ($marginPercent < 20) {
            $status = 'CRITICAL';
        } elseif ($marginPercent < 40) {
            $status = 'FRAGILE';
        } else {
            $status = 'HEALTHY';
        }

        if ($status === 'CRITICAL') {
            $reason = "CRITICAL ZONE: Margin di bawah 20% menunjukkan bahwa bisnis hampir tidak punya ruang bernapas.\n\n" .
                "What it means:\n" .
                "- bisnis berjalan namun hampir tanpa buffer\n" .
                "- sangat sensitif pada biaya marketing, operational, overhead, dan waste\n\n" .
                "Logic reasoning:\n" .
                "- Contribution margin terlalu kecil untuk menyerap biaya lain\n" .
                "- Sedikit kenaikan biaya (ads, bahan, produksi) langsung bikin rugi\n" .
                "- Tidak ada buffer untuk scaling\n" .
                "- Tidak sustainable dalam jangka menengah";

            $action = "Decision implication:\n" .
                "- Jangan scale\n" .
                "- Jangan tambah stock\n" .
                "- Jangan tambah SKU\n\n" .
                "Evaluate ulang:\n" .
                "- optimize cost\n" .
                "- improve pricing\n" .
                "- improve efficiency\n" .
                "- pertimbangkan stop product atau redesign model bisnis\n\n" .
                "Alasan: margin terlalu rendah; tanpa tindakan, risiko kerugian agravasi dan cashflow buruk meningkat.";
        } elseif ($status === 'FRAGILE') {
            $reason = "FRAGILE ZONE: Margin 20-39% menunjukkan bisnis masih berjalan namun rentan.\n\n" .
                "What it means:\n" .
                "- masih profit tetapi tidak kuat menghadapi tekanan\n" .
                "- sensitif terhadap diskon, kenaikan biaya, dan inefficiency kecil\n\n" .
                "Logic reasoning:\n" .
                "- cukup untuk survive, tetapi belum siap untuk aggressive growth\n" .
                "- profit terjaga tapi mudah terganggu\n" .
                "- scaling terasa berat; perlu sering promo untuk maintain sales\n" .
                "- sedikit salah keputusan langsung terasa";

            $action = "Decision implication:\n" .
                "- jalan tapi hati-hati\n" .
                "- jangan terlalu cepat scale\n" .
                "- jangan over-expand SKU\n\n" .
                "Fokus utama:\n" .
                "- optimize cost\n" .
                "- improve pricing\n" .
                "- improve efficiency";
        } else {
            $reason = "HEALTHY ZONE: Margin >=40% menunjukkan ruang pertumbuhan yang baik.\n\n" .
                "What it means:\n" .
                "- ada buffer dan fleksibilitas\n" .
                "- siap absorb marketing cost, operational inefficiency, dan eksperimen\n" .
                "- bisa handle diskon tanpa langsung collapse\n\n" .
                "Logic reasoning:\n" .
                "- sampai saat ini cashflow lebih sehat\n" .
                "- bisa test channel baru dan invest ke growth\n" .
                "- keputusan bisa lebih tenang, tidak panik";

            $action = "Decision implication:\n" .
                "- bisa mulai scale\n" .
                "- bisa tambah channel\n" .
                "- bisa test produk baru\n\n" .
                "Catatan: jangan reckless, jangan buang margin demi volume";
        }

        $marginMatch = $sellingPrice - $totalCostPerUnit;
        $bepUnit = ($marginMatch > 0) ? ceil(($adsPerUnit * $qty) / $marginMatch) : 0;

        BusinessCalculation::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'hpp' => $hpp,
            'selling_price' => $sellingPrice,
            'ads_per_unit' => $adsPct,
            'admin_fee_percent' => $adminFeePct,
            'overhead_percent' => $overheadPct,
            'tax_percent' => $taxPct,
            'promo_percent' => $promoPct,
            'operational_fee' => 0,
            'est_batch_quantity' => $qty,
            'net_profit' => $netProfitPerUnit,
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
        $inventoryUpdates = []; // Track inventory changes

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

            // Track inventory deduction
            $inventoryUpdates[$matId] = ($inventoryUpdates[$matId] ?? 0) + $usage;
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

        // Update inventory - reduce stock_out from each material used
        foreach ($inventoryUpdates as $materialId => $usageAmount) {
            $material = Material::find($materialId);
            if ($material) {
                $material->increment('stock_out', $usageAmount);
            }
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
        // Attempt decision-engine BusinessCalculation first
        $calc = BusinessCalculation::where('user_id', Auth::id())->find($id);

        if ($calc) {
            $pdf = Pdf::loadView('business.pdf', compact('calc'));
            return $pdf->download("business-report-{$id}.pdf");
        }

        // Fallback to HPP report for backward compatibility
        $hpp = HppCalculation::with('items.material')->where('user_id', Auth::id())->findOrFail($id);

        if (! $hpp->printed_at) {
            $hpp->printed_at = now();
            $hpp->save();
        }

        $pdf = Pdf::loadView('business.hpp_pdf', compact('hpp'));
        return $pdf->download("hpp-{$id}.pdf");
    }

    public function printBomPdf($id)
    {
        $hpp = HppCalculation::with('items.material')->where('user_id', Auth::id())->findOrFail($id);

        $pdf = Pdf::loadView('business.bom_pdf', compact('hpp'));
        return $pdf->download("bom-{$hpp->hpp_id}.pdf");
    }

    public function destroy($id)
    {
        $calc = BusinessCalculation::where('user_id', Auth::id())->findOrFail($id);
        $calc->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Hapus HPP Calculation
     */
    public function destroyHpp($id)
    {
        $hpp = HppCalculation::where('user_id', Auth::id())->findOrFail($id);
        
        // Delete related items (cascade)
        HppMaterialItem::where('hpp_calculation_id', $id)->delete();
        
        // Delete the HPP calculation itself
        $hpp->delete();
        
        return redirect()->route('hpp.index')->with('success', 'HPP berhasil dihapus beserta data materialnya.');
    }
}