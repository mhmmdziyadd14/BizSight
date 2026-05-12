<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BOM Report #{{ $hpp->hpp_id }}</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            background: #ffffff;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        /* Header */
        table.header-table {
            width: 100%;
            background-color: #1E293B;
            color: #ffffff;
            padding: 30px;
        }
        .header-title {
            font-size: 28px;
            font-weight: bold;
        }
        .header-title span {
            color: #F97316;
        }
        .header-subtitle {
            font-size: 12px;
            color: #F59E0B;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .report-info {
            text-align: right;
        }
        .report-info h2 {
            font-size: 20px;
            margin: 0;
            color: #ffffff;
        }
        .report-info p {
            font-size: 12px;
            color: #94A3B8;
            margin-top: 5px;
        }
        
        /* Info Cards */
        table.info-table {
            width: 100%;
            background-color: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
        }
        table.info-table td {
            padding: 20px 30px;
            width: 33.33%;
            vertical-align: top;
            border-right: 1px solid #E2E8F0;
        }
        table.info-table td:last-child {
            border-right: none;
        }
        .info-label {
            font-size: 10px;
            font-weight: bold;
            color: #F97316;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }
        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #0F172A;
            display: block;
        }

        /* Materials section */
        .content-section {
            padding: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0F172A;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #F97316;
            display: inline-block;
        }

        table.materials-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.materials-table th {
            background-color: #FEF3C7;
            padding: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #F97316;
            text-align: left;
            border-bottom: 2px solid #F97316;
        }
        table.materials-table td {
            padding: 12px;
            font-size: 12px;
            color: #1E293B;
            border-bottom: 1px solid #E2E8F0;
        }
        table.materials-table tr:nth-child(even) td {
            background-color: #F8FAFC;
        }
        .text-right {
            text-align: right !important;
        }
        .text-center {
            text-align: center !important;
        }

        /* Summary section */
        table.summary-container {
            width: 100%;
            background-color: #1E293B;
            color: #ffffff;
            border-radius: 8px;
            margin: 0 auto;
        }
        table.summary-container td.col {
            width: 50%;
            padding: 20px;
            vertical-align: top;
        }
        table.summary-inner {
            width: 100%;
            border-collapse: collapse;
        }
        table.summary-inner td {
            padding: 10px 0;
            border-bottom: 1px solid rgba(249, 115, 22, 0.2);
            font-size: 12px;
        }
        table.summary-inner tr:last-child td {
            border-bottom: none;
        }
        .summary-label {
            color: #94A3B8;
        }
        .summary-value {
            text-align: right;
            font-weight: bold;
        }
        .total-value {
            color: #F59E0B !important;
            font-size: 18px !important;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding: 20px 30px;
            text-align: center;
            font-size: 11px;
            color: #64748B;
            border-top: 1px solid #E2E8F0;
        }
        .footer strong {
            color: #F97316;
        }
    </style>
</head>
<body>
    @php $qty = $qty ?? 1; @endphp
    <div class="container">
        <!-- Header -->
        <table class="header-table" cellspacing="0" cellpadding="0">
            <tr>
                <td width="50%">
                    <div class="header-title"><span>Clarity</span>Labs</div>
                    <div class="header-subtitle">BOM Precision Report</div>
                </td>
                <td width="50%" class="report-info">
                    <h2>Bill of Materials Report</h2>
                    <p>Generated on {{ now()->format('d F Y, H:i') }} | Qty: <strong>{{ $qty }} Unit</strong></p>
                </td>
            </tr>
        </table>

        <!-- Info Cards -->
        <table class="info-table" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <span class="info-label">HPP ID</span>
                    <span class="info-value">{{ $hpp->hpp_id }}</span>
                </td>
                <td>
                    <span class="info-label">Product Name</span>
                    <span class="info-value">{{ $hpp->name }}</span>
                </td>
                <td>
                    <span class="info-label">Category</span>
                    <span class="info-value">{{ $hpp->category }}</span>
                </td>
            </tr>
        </table>

        <!-- Content -->
        <div class="content-section">
            <div class="section-title">Bill of Materials Details</div>
            
            <table class="materials-table">
                <thead>
                    <tr>
                        <th>Material Name</th>
                        <th class="text-center">Satuan</th>
                        <th class="text-right">Harga/Unit</th>
                        <th class="text-right">Usage ({{ $qty }} Unit)</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hpp->items as $item)
                        <tr>
                            <td><strong>{{ $item->material?->name ?? 'N/A' }}</strong></td>
                            <td class="text-center">{{ $item->material?->unit ?? '-' }}</td>
                            <td class="text-right">Rp{{ number_format($item->material?->price ?? 0,0,',','.') }}</td>
                            <td class="text-right">{{ number_format($item->usage_amount * $qty, 2, ',', '.') }}</td>
                            <td class="text-right"><strong>Rp{{ number_format($item->subtotal_cost * $qty,0,',','.') }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="summary-container" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="col" style="border-right: 1px solid rgba(249, 115, 22, 0.2);">
                        <table class="summary-inner">
                            <tr>
                                <td class="summary-label">Total Bahan Baku ({{ $qty }} Unit)</td>
                                <td class="summary-value">Rp{{ number_format($hpp->total_raw_material_cost * $qty,0,',','.') }}</td>
                            </tr>
                            <tr>
                                <td class="summary-label">Biaya Sablon ({{ $qty }} Unit)</td>
                                <td class="summary-value">Rp{{ number_format($hpp->screen_printing_fee * $qty,0,',','.') }}</td>
                            </tr>
                            <tr>
                                <td class="summary-label">Biaya Jahit ({{ $qty }} Unit)</td>
                                <td class="summary-value">Rp{{ number_format($hpp->sewing_fee * $qty,0,',','.') }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="col">
                        <table class="summary-inner">
                            <tr>
                                <td class="summary-label">Total HPP ({{ $qty }} Unit)</td>
                                <td class="summary-value total-value">Rp{{ number_format($hpp->total_hpp_per_unit * $qty,0,',','.') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            Generated by <strong>ClarityLabs System</strong> • BOM Precision Engine v2.0
        </div>
    </div>
</body>
</html>