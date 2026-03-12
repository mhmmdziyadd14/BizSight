<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kelayakan Bisnis - {{ $data->product_name }}</title>
    <style>
        /* CSS khusus untuk dompdf agar rapi saat diprint */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            text-transform: uppercase;
            font-size: 20px;
            color: #1a202c;
        }
        .header p {
            margin: 5px 0 0;
            color: #718096;
        }
        .section-title {
            background-color: #f7fafc;
            padding: 8px 12px;
            font-weight: bold;
            border-left: 4px solid #ecc94b; /* Warna kuning sesuai tema app */
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #edf2f7;
        }
        table th {
            background-color: #fdfdfd;
            color: #4a5568;
            width: 40%;
        }
        .verdict-box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-top: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            border-radius: 99px;
            font-weight: bold;
            font-size: 14px;
            background-color: #fefcbf;
            border: 1px solid #ecc94b;
            color: #744210;
        }
        .reason-text {
            font-style: italic;
            color: #4a5568;
            margin-top: 10px;
        }
        .action-box {
            background-color: #ebf8ff;
            border-left: 4px solid #4299e1;
            padding: 15px;
            margin-top: 15px;
        }
        .action-box strong {
            display: block;
            margin-bottom: 5px;
            color: #2b6cb0;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #a0aec0;
            padding: 10px 0;
            border-top: 1px solid #edf2f7;
        }
        .metric-row {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        .metric-col {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            text-align: center;
            border: 1px solid #edf2f7;
        }
        .metric-value {
            font-size: 16px;
            font-weight: bold;
            display: block;
        }
        .metric-label {
            font-size: 9px;
            color: #718096;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Kelayakan Bisnis</h1>
        <p>Produk: <strong>{{ $data->product_name }}</strong> | Tanggal: {{ $data->created_at->format('d F Y') }}</p>
    </div>

    <div class="section-title">A. Data Input (Variabel Bisnis)</div>
    <table>
        <tr>
            <th>HPP (COGS)</th>
            <td>Rp {{ number_format($data->hpp, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Harga Jual ke Customer</th>
            <td>Rp {{ number_format($data->selling_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Budget Iklan per Unit</th>
            <td>Rp {{ number_format($data->ads_per_unit, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Biaya Operasional (5%)</th>
            <td>Rp {{ number_format($data->operational_fee, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Estimasi Produksi (Batch)</th>
            <td>{{ $data->est_batch_quantity }} pcs</td>
        </tr>
    </table>

    <div class="section-title">B. Hasil Perhitungan Otomatis</div>
    <div class="metric-row">
        <div class="metric-col">
            <span class="metric-label">Net Profit / Unit</span>
            <span class="metric-value">Rp {{ number_format($data->net_profit, 0, ',', '.') }}</span>
        </div>
        <div class="metric-col">
            <span class="metric-label">Net Margin (%)</span>
            <span class="metric-value">{{ number_format($data->net_margin_percent, 1) }}%</span>
        </div>
        <div class="metric-col">
            <span class="metric-label">BEP (Balik Modal)</span>
            <span class="metric-value">{{ $data->bep_unit }} Unit</span>
        </div>
    </div>

    <div class="section-title">C. THE VERDICT (Analisis & Rekomendasi)</div>
    <div class="verdict-box">
        <div style="margin-bottom: 15px;">
            <span style="font-size: 10px; color: #a0aec0; font-weight: bold; text-transform: uppercase; display: block; margin-bottom: 5px;">Profitability Status:</span>
            <div class="status-badge">
                {{ $latest->status_label ?? $data->status_label }}
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <span style="font-size: 10px; color: #a0aec0; font-weight: bold; text-transform: uppercase; display: block;">Logic Reason:</span>
            <p class="reason-text">"{{ $data->logic_reason }}"</p>
        </div>

        <div class="action-box">
            <strong>Action Required:</strong>
            {{ $data->action_required }}
        </div>
    </div>

    <div class="footer">
        Laporan ini digenerate secara otomatis oleh Business Viability System pada {{ date('d/m/Y H:i') }}.
    </div>

</body>
</html>