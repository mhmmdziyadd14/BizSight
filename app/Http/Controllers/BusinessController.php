<?php

namespace App\Http\Controllers;

use App\Models\BusinessCalculation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BusinessController extends Controller
{
    public function index()
    {
        $calculations = BusinessCalculation::where('user_id', auth()->id())->latest()->get();
        return view('business.index', compact('calculations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'hpp' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'ads_per_unit' => 'required|numeric',
            'est_batch_quantity' => 'required|integer',
        ]);

        // LOGIKA PERHITUNGAN (SESUAI GAMBAR)
        $sellingPrice = $request->selling_price;
        $hpp = $request->hpp;
        $ads = $request->ads_per_unit;
        $qty = $request->est_batch_quantity;
        
        // Ops Fee diasumsikan 5% otomatis dari Selling Price sesuai gambar referensi
        $opsFee = 0.05 * $sellingPrice; 

        $netProfit = $sellingPrice - $hpp - $ads - $opsFee;
        $marginPercent = ($netProfit / $sellingPrice) * 100;
        $bepUnit = ceil(($hpp * $qty) / $sellingPrice);

        // THE VERDICT LOGIC
        if ($marginPercent < 20) {
            $status = "🔴 STOP (KILL IT)";
            $reason = "Margin lo di bawah 20%. Bisnis ini terlalu berisiko dan tidak profitable.";
            $action = "Cari supplier lain untuk tekan HPP atau ganti model bisnis.";
        } elseif ($marginPercent < 30) {
            $status = "🟡 EVALUASI";
            $reason = "Margin lo di bawah 30%. Terlalu berisiko kalau ada retur atau diskon tambahan.";
            $action = "Coba tekan biaya ads atau naikkan harga jual 10% agar status jadi LANJUT.";
        } else {
            $status = "🟢 LANJUT";
            $reason = "Margin lo sangat sehat (di atas 30%). Potensi scaling besar.";
            $action = "Segera eksekusi produksi batch pertama!";
        }

        BusinessCalculation::create([
            'user_id' => auth()->id(),
            'product_name' => $request->product_name,
            'hpp' => $hpp,
            'selling_price' => $sellingPrice,
            'ads_per_unit' => $ads,
            'operational_fee' => $opsFee,
            'est_batch_quantity' => $qty,
            'net_profit' => $netProfit,
            'net_margin_percent' => $marginPercent,
            'bep_unit' => $bepUnit,
            'status_label' => $status,
            'logic_reason' => $reason,
            'action_required' => $action
        ]);

        return redirect()->back()->with('success', 'Perhitungan berhasil disimpan!');
    }

    public function printPdf($id)
    {
        $data = BusinessCalculation::where('user_id', auth()->id())->findOrFail($id);
        $pdf = Pdf::loadView('pdf.business_report', compact('data'));
        return $pdf->download('Business_Report_'.$data->product_name.'.pdf');
    }
}