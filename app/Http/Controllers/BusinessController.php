<?php

namespace App\Http\Controllers;

use App\Models\BusinessCalculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Placeholder data materials agar view tidak error saat render @foreach
        $materials = collect(); 
        
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
        return redirect()->route('business.index')->with('success', 'Data HPP berhasil diproses!');
    }

    public function printPdf($id)
    {
        $calculation = BusinessCalculation::where('user_id', Auth::id())->findOrFail($id);
        return view('pdf.business_report', compact('calculation'));
    }

    public function destroy($id)
    {
        $calc = BusinessCalculation::where('user_id', Auth::id())->findOrFail($id);
        $calc->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}