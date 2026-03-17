<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HPP Report #{{ $hpp->id }}</title>
    <style>body{font-family:sans-serif;}table{width:100%;border-collapse:collapse;}td,th{border:1px solid #ccc;padding:8px;text-align:left;}</style>
</head>
<body>
    <h1>HPP Calculation</h1>
    <p><strong>HPP ID:</strong> {{ $hpp->hpp_id }}</p>
    <p><strong>Name:</strong> {{ $hpp->name }}</p>
    <p><strong>Category:</strong> {{ $hpp->category }}</p>
    <table>
        <thead><tr><th>Material</th><th>Usage</th><th>Subtotal</th></tr></thead>
        <tbody>
            @foreach($hpp->items as $item)
                <tr>
                    <td>{{ $item->material?->name ?? 'N/A' }}</td>
                    <td>{{ $item->usage_amount }}</td>
                    <td>Rp{{ number_format($item->subtotal_cost,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total HPP/unit:</strong> Rp{{ number_format($hpp->total_hpp_per_unit,0,',','.') }}</p>
</body>
</html>