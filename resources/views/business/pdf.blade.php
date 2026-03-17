<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Report #{{ $calc->id }}</title>
    <style>body{font-family:sans-serif;}table{width:100%;border-collapse:collapse;}td,th{border:1px solid #ccc;padding:8px;text-align:left;}</style>
</head>
<body>
    <h1>Business Viability Report</h1>
    <p><strong>Product:</strong> {{ $calc->product_name }}</p>
    <p><strong>Date:</strong> {{ $calc->created_at->format('Y-m-d H:i') }}</p>
    <table>
        <thead><tr><th>Field</th><th>Value</th></tr></thead>
        <tbody>
            <tr><td>HPP</td><td>Rp{{ number_format($calc->hpp,0,',','.') }}</td></tr>
            <tr><td>Selling Price</td><td>Rp{{ number_format($calc->selling_price,0,',','.') }}</td></tr>
            <tr><td>Ads/Unit</td><td>Rp{{ number_format($calc->ads_per_unit,0,',','.') }}</td></tr>
            <tr><td>Batch Qty</td><td>{{ $calc->est_batch_quantity }} pcs</td></tr>
            <tr><td>Net Profit/Unit</td><td>Rp{{ number_format($calc->net_profit,0,',','.') }}</td></tr>
            <tr><td>Net Margin</td><td>{{ number_format($calc->net_margin_percent,1) }}%</td></tr>
            <tr><td>BEP Unit</td><td>{{ $calc->bep_unit }} pcs</td></tr>
            <tr><td>Status</td><td>{{ $calc->status_label }}</td></tr>
            <tr><td>Logic</td><td>{{ $calc->logic_reason }}</td></tr>
            <tr><td>Action</td><td>{{ $calc->action_required }}</td></tr>
        </tbody>
    </table>
</body>
</html>