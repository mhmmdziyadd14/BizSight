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
     * Menampilkan form Decision Engine.
     */
    public function index()
    {
        // HPP list untuk mengisi pilihan ID Produk dari HPP yang sudah dibuat
        $hppOptions = HppCalculation::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Clarity Visual list untuk mengisi pilihan ID Produk dari Decision Engine yang sudah dibuat
        $clarityVisuals = BusinessCalculation::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('business.index', compact('hppOptions', 'clarityVisuals'));
    }

    /**
     * Menampilkan daftar hasil Decision Engine.
     */
    public function decisionsList()
    {
        $calculations = BusinessCalculation::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('business.decisions_list', compact('calculations'));
    }

    /**
     * Menampilkan detail hasil Decision Engine.
     */
    public function showDecision($id)
    {
        $calc = BusinessCalculation::where('user_id', Auth::id())->findOrFail($id);

        $hppPct = $calc->selling_price > 0 ? ($calc->hpp / $calc->selling_price) * 100 : 0;
        $adminPct = $calc->admin_fee_percent ?? 0;
        $adsPct = $calc->ads_per_unit ?? 0;
        $affiliatePct = $calc->affiliate_percent ?? 0;
        $promoPct = $calc->promo_percent ?? 0;
        $overheadPct = $calc->overhead_percent ?? 0;
        $taxPct = $calc->tax_percent ?? 0;

        $totalCostPct = $hppPct + $adminPct + $adsPct + $affiliatePct + $promoPct + $overheadPct + $taxPct;
        $netProfitPct = $calc->net_margin_percent;

        $costs = [
            ['hpp', $hppPct],
            ['admin', $adminPct],
            ['ads', $adsPct],
            ['affiliate', $affiliatePct],
            ['promo', $promoPct],
            ['overhead', $overheadPct],
            ['tax', $taxPct]
        ];
        usort($costs, function($a, $b) { return $b[1] <=> $a[1]; });
        $topCosts = array_slice($costs, 0, 3);

        $insight = $calc->status_label === 'CRITICAL' ? 'Cost structure terlalu berat bahkan sebelum scaling dimulai.' : ($calc->status_label === 'FRAGILE' ? 'Margin tertekan oleh kombinasi ads + platform fee.' : 'Cost structure masih dalam batas sehat dan scalable.');
        $risks = $calc->status_label === 'CRITICAL' ? ['Product is not profitable', 'Cashflow drain risk'] : ($calc->status_label === 'FRAGILE' ? ['Margin pressure', 'Avoid large production'] : ['No significant risks']);
        $strategy = $calc->status_label === 'HEALTHY' ? 'Scale Aggressive' : ($calc->status_label === 'FRAGILE' ? 'Optimization' : 'Stop & Redesign');
        $focus = $calc->status_label === 'CRITICAL' ? 'memperbaiki unit economics, bukan jualan' : ($calc->status_label === 'FRAGILE' ? 'jaga margin & cashflow' : 'scale & expansion');
        
        $adsStatus = $adsPct > 20 ? 'DANGEROUS' : ($adsPct > 10 ? 'PRESSURING' : 'SAFE');
        $adsMessage = $adsPct > 20 ? 'Ads cost is too high' : 'Ads cost is manageable';

        $actionPlan = array_map('trim', explode("\n", $calc->action_required));
        $actionPlan = array_filter($actionPlan, function($value) { return !empty($value); });

        return view('business.decisions_show', compact(
            'calc', 'hppPct', 'totalCostPct', 'topCosts', 'insight', 'risks', 
            'strategy', 'focus', 'adsStatus', 'adsMessage', 'actionPlan'
        ));
    }

    /**
     * Menampilkan halaman daftar HPP.
     */
    public function hppIndex()
    {
        $hppCalculations = HppCalculation::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        $products = $hppCalculations; // same data as hppCalculations

        $materials = Material::where('user_id', Auth::id())
                        ->orderBy('name')
                        ->get();

        $bomList = HppCalculation::with('items.material')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('business.hpp_index', compact('hppCalculations', 'products', 'materials', 'bomList'));
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
                'purchase_volume' => $group->first()->purchase_volume,
                'colors' => $group->map(function($material) {
                    return [
                        'id' => $material->id,
                        'color' => $material->color,
                        'price' => $material->price,
                        'purchase_volume' => $material->purchase_volume
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
        try {
            $request->validate([
                'product_name' => 'required|string|max:255',
                'product_id_source' => 'required|in:manual,existing',
                'product_id_manual' => 'required_if:product_id_source,manual|nullable|string|max:255',
                'product_id_existing' => 'required_if:product_id_source,existing|nullable|string|max:255',
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

            // Match frontend logic: fees are percentage of selling price
            $feesPctTotal = $adminFeePct + $overheadPct + $taxPct + $affiliatePct;
            $totalFeesPerUnit = ($sellingPrice * $feesPctTotal) / 100;
            
            // Ads are also percentage of selling price
            $adsPerUnit = ($sellingPrice * $adsPct) / 100;

            // Margin normal (tanpa promo)
            $totalCostPerUnit = $hpp + $totalFeesPerUnit;
            $netProfitPerUnit = $sellingPrice - $totalCostPerUnit - $adsPerUnit;
            $totalNetProfit = $netProfitPerUnit * $qty;
            $marginPercent = ($sellingPrice > 0) ? ($netProfitPerUnit / $sellingPrice) * 100 : 0;

            // Margin setelah promo
            $sellingPricePromo = $sellingPrice * (1 - ($promoPct / 100));
            // Fees on promo price (usually fees apply to the final selling price)
            $totalFeesPromoPerUnit = ($sellingPricePromo * $feesPctTotal) / 100;
            $netProfitPromoPerUnit = $sellingPricePromo - $hpp - $totalFeesPromoPerUnit - $adsPerUnit;
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
                    "Sangat tidak disarankan untuk scale!";
                $action = "STOP MARKETING & RE-EVALUATE STRUCTURE";
            } elseif ($status === 'FRAGILE') {
                $reason = "FRAGILE ZONE: Margin 20% - 40% adalah zona kuning.\n\n" .
                    "What it means:\n" .
                    "- ada profit, namun tipis\n" .
                    "- biaya marketing harus sangat efisien\n" .
                    "- tidak disarankan untuk tim marketing yang belum expert\n\n" .
                    "Saran: Gunakan sistem PO untuk meminimalkan risiko.";
                $action = "OPTIMIZE ADS & EFFICIENCY";
            } else {
                $reason = "HEALTHY ZONE: Margin di atas 40% adalah zona hijau yang ideal.\n\n" .
                    "What it means:\n" .
                    "- ada ruang untuk error (marketing test, waste, dll)\n" .
                    "- cashflow biasanya lebih sehat\n" .
                    "- bisa test produk baru\n\n" .
                    "Catatan: jangan reckless, jangan buang margin demi volume";
                $action = "GREEN LIGHT TO SCALE";
            }

            $marginMatch = $sellingPrice - $totalCostPerUnit;
            $bepUnit = ($marginMatch > 0) ? ceil(($adsPerUnit * $qty) / $marginMatch) : 0;

            $productId = $request->product_id_source === 'manual' 
                ? $request->product_id_manual 
                : $request->product_id_existing;

            $hppCalcId = null;
            if ($request->product_id_source === 'existing') {
                // Check if the selected ID exists in HppCalculation
                $hppCalc = HppCalculation::where('user_id', Auth::id())
                            ->where('hpp_id', $request->product_id_existing)
                            ->first();
                if ($hppCalc) {
                    $hppCalcId = $hppCalc->id;
                }
            }

            $confidence = 50;
            if ($marginPercent > 25) $confidence += 15;
            
            BusinessCalculation::create([
                'user_id' => Auth::id(),
                'product_name' => $request->product_name,
                'product_id' => $productId,
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
                'bep_unit' => $bepUnit,
                'hpp_calculation_id' => $hppCalcId,
                'confidence' => $confidence
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'status' => $status,
                        'grossProfit' => ($sellingPrice - $hpp) * $qty,
                        'netProfit' => $totalNetProfit,
                        'netMargin' => $marginPercent / 100,
                        'promoMargin' => $promoMarginPercent / 100,
                        'marginDiff' => $marginDiffPercent / 100,
                        'bepUnit' => $bepUnit,
                        'confidence' => $confidence,
                        'strategy' => ($status === 'HEALTHY' ? 'Scale Aggressive' : ($status === 'FRAGILE' ? 'Optimization' : 'Stop & Redesign')),
                        'production' => [
                            'model' => 'Batch Limited',
                            'batch' => $qty
                        ],
                        'logic' => [
                            'reason' => $reason,
                            'action' => $action
                        ],
                        'hero' => [
                            'title' => ($status === 'HEALTHY' ? 'Green Light to Scale' : ($status === 'FRAGILE' ? 'Proceed with Caution' : 'Critical - Optimization Needed')),
                            'subtext' => ($status === 'HEALTHY' ? 'Produk ini memiliki margin yang sangat sehat.' : ($status === 'FRAGILE' ? 'Produk memiliki potensi, namun margin cukup tipis.' : 'Produk ini memerlukan perbaikan struktur biaya segera.'))
                        ],
                        'costBreakdown' => [
                            'hpp' => $sellingPrice > 0 ? round(($hpp / $sellingPrice) * 100, 1) : 0,
                            'admin' => $adminFeePct,
                            'ads' => $adsPct,
                            'affiliate' => $affiliatePct,
                            'promo' => $promoPct,
                            'overhead' => $overheadPct,
                            'tax' => $taxPct,
                            'total' => $sellingPrice > 0 ? round((($totalCostPerUnit + $adsPerUnit) / $sellingPrice) * 100, 1) : 0,
                            'netProfit' => round($marginPercent, 1)
                        ],
                        'topCosts' => [
                            ['hpp', $sellingPrice > 0 ? $hpp / $sellingPrice : 0],
                            ['ads', $adsPct / 100],
                            ['overhead', $overheadPct / 100]
                        ],
                        'risks' => ($status === 'CRITICAL' ? ['Product is not profitable', 'Cashflow drain risk'] : ($status === 'FRAGILE' ? ['Margin pressure', 'Avoid large production'] : ['No significant risks'])),
                        'ads' => [
                            'status' => ($adsPct > 20 ? 'DANGEROUS' : ($adsPct > 10 ? 'PRESSURING' : 'SAFE')),
                            'message' => ($adsPct > 20 ? 'Ads cost is too high' : 'Ads cost is manageable')
                        ],
                        'actions' => ($status === 'CRITICAL' ? ['Stop ads', 'Recalculate pricing'] : ($status === 'FRAGILE' ? ['Optimize ads', 'Avoid large production'] : ['Scale ads gradually']))
                    ]
                ]);
            }

            return redirect()->route('business.index')->with('success', 'Analisis berhasil disimpan!');
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            throw $e;
        }
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

    public function printHppPdf($id)
    {
        $hpp = HppCalculation::with('items.material')->where('user_id', Auth::id())->findOrFail($id);

        if (! $hpp->printed_at) {
            $hpp->printed_at = now();
            $hpp->save();
        }

        $pdf = Pdf::loadView('business.hpp_pdf', compact('hpp'));
        return $pdf->download("hpp-{$hpp->hpp_id}.pdf");
    }

    public function printDecisionEnginePdf($id)
    {
        $calc = BusinessCalculation::where('user_id', Auth::id())->findOrFail($id);

        $pdf = Pdf::loadView('business.pdf', compact('calc'));
        return $pdf->download("business-report-{$id}.pdf");
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

    /**
     * Menampilkan halaman Visual Clarity Pack (VCP).
     */
    public function clarityVisual()
    {
        return view('business.visual');
    }

    /**
     * Menyimpan data visual (VCP).
     */
    public function storeVisual(Request $request)
    {
        // Logic untuk menyimpan data visual jika diperlukan di masa depan
        return redirect()->back()->with('success', 'Data visual berhasil disimpan.');
    }
}