<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #1a1a1a; line-height: 1.5; }
        .header { border-bottom: 3px solid #FACC15; padding-bottom: 20px; margin-bottom: 30px; }
        .brand { font-size: 24px; font-weight: 900; font-style: italic; color: #000; letter-spacing: -1px; }
        .brand span { color: #FACC15; }
        .doc-title { float: right; font-size: 10px; font-weight: bold; color: #666; text-transform: uppercase; letter-spacing: 2px; }
        .meta-grid { width: 100%; margin-bottom: 30px; }
        .meta-label { font-size: 9px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px; }
        .meta-value { font-size: 14px; font-weight: bold; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background-color: #f8f8f8; color: #666; font-size: 9px; font-weight: bold; text-transform: uppercase; padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; }
        td { padding: 12px 15px; border-bottom: 1px solid #f1f1f1; }
        .text-right { text-align: right; }
        .footer-note { margin-top: 50px; border-top: 1px solid #eee; pt-10; color: #999; font-size: 9px; text-align: center; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; }
        .total-container { float: right; width: 250px; background: #000; color: #fff; padding: 20px; border-radius: 10px; }
        .total-label { font-size: 9px; color: #FACC15; text-transform: uppercase; margin-bottom: 5px; }
        .total-amount { font-size: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <span class="brand"><span>Biz</span>Sight</span>
        <span class="doc-title">Business Analysis Report</span>
    </div>

    <table class="meta-grid">
        <tr>
            <td style="border:none; width:50%;">
                <div class="meta-label">ID Perhitungan</div>
                <div class="meta-value">#{{ $data->hpp_id ?? 'BZS-REF-'.rand(100,999) }}</div>
            </td>
            <td style="border:none; width:50%;">
                <div class="meta-label">Nama Produk</div>
                <div class="meta-value">{{ $data->name ?? 'Project Tanpa Nama' }}</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Komponen Bahan Baku</th>
                <th>Volume</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data->items) && $data->items->count() > 0)
                @foreach($data->items as $item)
                <tr>
                    <td><strong>{{ $item->material->name }}</strong><br><span style="color:#999; font-size:8px;">{{ $item->material->type }}</span></td>
                    <td>{{ $item->usage_amount }} {{ $item->material->unit }}</td>
                    <td class="text-right">Rp {{ number_format($item->material->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal_cost, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @else
                <tr><td colspan="4" style="text-align:center; color:#999;">Tidak ada rincian bahan baku.</td></tr>
            @endif
        </tbody>
    </table>

    <div class="total-container">
        <div class="total-label">Total HPP Produksi / Unit</div>
        <div class="total-amount">Rp {{ number_format($data->total_hpp_per_unit ?? 0, 0, ',', '.') }}</div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer-note">
        Analyzed by BizSight System • Developed by Muhammad Ziyad • ITENAS Bandung
    </div>
</body>
</html>