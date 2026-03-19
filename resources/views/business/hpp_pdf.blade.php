<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HPP Report #{{ $hpp->id }}</title>
    <style>
        body{font-family:sans-serif;}
        table{width:100%;border-collapse:collapse;}
        td,th{border:1px solid #ccc;padding:8px;text-align:left;}
        th{background:#f4f4f4;}
        .text-right{text-align:right;}
        .summary{margin-top:16px;width:100%;}
        .summary td{border:none;padding:4px;}
        .summary .label{font-weight:600;}
    </style>
</head>
<body>
    <h1>HPP Calculation</h1>
    <p><strong>HPP ID:</strong> {{ $hpp->hpp_id }}</p>
    <p><strong>Name:</strong> {{ $hpp->name }}</p>
    <p><strong>Category:</strong> {{ $hpp->category }}</p>
    <table>
        <thead>
            <tr>
                <th>Material</th>
                <th>Satuan</th>
                <th class="text-right">Harga/Unit</th>
                <th class="text-right">Usage</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hpp->items as $item)
                <tr>
                    <td>{{ $item->material?->name ?? 'N/A' }}</td>
                    <td>{{ $item->material?->unit ?? '-' }}</td>
                    <td class="text-right">Rp{{ number_format($item->material?->price ?? 0,0,',','.') }}</td>
                    <td class="text-right">{{ $item->usage_amount }}</td>
                    <td class="text-right">Rp{{ number_format($item->subtotal_cost,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="summary">
        <tr>
            <td class="label">Total Bahan:</td>
            <td class="text-right">Rp{{ number_format($hpp->total_raw_material_cost,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="label">Biaya Sablon:</td>
            <td class="text-right">Rp{{ number_format($hpp->screen_printing_fee,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="label">Biaya Jahit:</td>
            <td class="text-right">Rp{{ number_format($hpp->sewing_fee,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="label">Biaya Lainnya:</td>
            <td class="text-right">Rp{{ number_format($hpp->other_fees,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="label">Total HPP/unit:</td>
            <td class="text-right">Rp{{ number_format($hpp->total_hpp_per_unit,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="label">Target Harga Jual:</td>
            <td class="text-right">Rp{{ number_format($hpp->target_selling_price,0,',','.') }}</td>
        </tr>
    </table>
</body>
</html>