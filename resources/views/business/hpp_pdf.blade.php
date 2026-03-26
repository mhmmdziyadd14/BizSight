{{-- File: hpp-report-print.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HPP Report #{{ $hpp->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FEF3C7 0%, #FFFFFF 50%, #F1F5F9 100%);
            padding: 40px 20px;
            min-height: 100vh;
        }
        
        .report-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            border: 1px solid rgba(249, 115, 22, 0.2);
        }
        
        /* Header Section */
        .report-header {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            padding: 32px 40px;
            border-bottom: 4px solid #F97316;
        }
        
        .logo-section {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }
        
        .logo-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }
        
        .logo-text h1 {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: white;
        }
        
        .logo-text h1 span {
            background: linear-gradient(135deg, #F97316, #F59E0B);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .logo-text p {
            font-size: 11px;
            font-weight: 600;
            color: #F59E0B;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 4px;
        }
        
        .report-title {
            border-top: 1px solid rgba(249, 115, 22, 0.3);
            padding-top: 20px;
            margin-top: 8px;
        }
        
        .report-title h2 {
            font-size: 24px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.3px;
        }
        
        .report-title p {
            font-size: 13px;
            color: #94A3B8;
            margin-top: 8px;
        }
        
        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            padding: 24px 40px;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
        }
        
        .info-card {
            background: white;
            padding: 16px 20px;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            transition: all 0.2s ease;
        }
        
        .info-card:hover {
            border-color: #F97316;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.1);
        }
        
        .info-label {
            font-size: 10px;
            font-weight: 800;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 700;
            color: #0F172A;
        }
        
        /* Table Section */
        .table-section {
            padding: 32px 40px;
        }
        
        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .section-title .badge {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #F97316, #F59E0B);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 14px;
        }
        
        .section-title h3 {
            font-size: 18px;
            font-weight: 800;
            color: #0F172A;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        th {
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
            padding: 14px 16px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #F97316;
            border-bottom: 2px solid #F97316;
            text-align: left;
        }
        
        td {
            padding: 14px 16px;
            font-size: 14px;
            color: #1E293B;
            border-bottom: 1px solid #F1F5F9;
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        tr:hover td {
            background: #FEF3C7;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .material-name {
            font-weight: 700;
            color: #0F172A;
        }
        
        .unit-badge {
            display: inline-block;
            padding: 4px 8px;
            background: #F1F5F9;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
        }
        
        /* Summary Section */
        .summary-section {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            margin: 0 40px 32px 40px;
            border-radius: 24px;
            padding: 24px 32px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(249, 115, 22, 0.2);
        }
        
        .summary-item:last-child {
            border-bottom: none;
        }
        
        .summary-label {
            font-size: 13px;
            font-weight: 600;
            color: #94A3B8;
            letter-spacing: 0.3px;
        }
        
        .summary-value {
            font-size: 16px;
            font-weight: 800;
            color: white;
        }
        
        .total-value {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, #F97316, #F59E0B);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        /* Profit Indicator */
        .profit-section {
            margin: 0 40px 32px 40px;
            padding: 20px 28px;
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .profit-info {
            display: flex;
            align-items: baseline;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .profit-label {
            font-size: 12px;
            font-weight: 600;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .profit-value {
            font-size: 28px;
            font-weight: 800;
            color: #0F172A;
        }
        
        .profit-margin {
            display: inline-block;
            padding: 6px 14px;
            background: #10B981;
            color: white;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 800;
        }
        
        /* Footer */
        .report-footer {
            padding: 24px 40px;
            background: #F8FAFC;
            border-top: 1px solid #E2E8F0;
            text-align: center;
        }
        
        .footer-text {
            font-size: 11px;
            color: #64748B;
            font-weight: 500;
        }
        
        .footer-text strong {
            color: #F97316;
            font-weight: 700;
        }
        
        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .report-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .info-card:hover {
                box-shadow: none;
            }
            
            tr:hover td {
                background: none;
            }
            
            .profit-section {
                break-inside: avoid;
            }
            
            @page {
                size: A4;
                margin: 2cm;
            }
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .report-header {
                padding: 24px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                padding: 20px;
            }
            
            .table-section {
                padding: 24px;
            }
            
            .summary-section {
                margin: 0 20px 24px 20px;
                padding: 20px;
            }
            
            .profit-section {
                margin: 0 20px 24px 20px;
                padding: 16px 20px;
            }
            
            .summary-grid {
                grid-template-columns: 1fr;
            }
            
            .report-footer {
                padding: 20px;
            }
            
            th, td {
                padding: 10px 12px;
                font-size: 12px;
            }
            
            .profit-value {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header -->
        <div class="report-header">
            <div class="logo-section">
                <div class="logo-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="logo-text">
                    <h1><span>Biz</span>Sight</h1>
                    <p>HPP Precision Report</p>
                </div>
            </div>
            <div class="report-title">
                <h2>HPP Calculation Report</h2>
                <p>Generated on {{ now()->format('d F Y, H:i') }}</p>
            </div>
        </div>
        
        <!-- Info Cards -->
        <div class="info-grid">
            <div class="info-card">
                <div class="info-label">HPP ID</div>
                <div class="info-value">{{ $hpp->hpp_id }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Product Name</div>
                <div class="info-value">{{ $hpp->name }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Category</div>
                <div class="info-value">{{ $hpp->category }}</div>
            </div>
        </div>
        
        <!-- Materials Table -->
        <div class="table-section">
            <div class="section-title">
                <div class="badge">03</div>
                <h3>Bill of Materials</h3>
            </div>
            
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
                            <td class="material-name">{{ $item->material?->name ?? 'N/A' }}</td>
                            <td><span class="unit-badge">{{ $item->material?->unit ?? '-' }}</span></td>
                            <td class="text-right">Rp{{ number_format($item->material?->price ?? 0,0,',','.') }}</td>
                            <td class="text-right">{{ number_format($item->usage_amount, 2, ',', '.') }}</td>
                            <td class="text-right">Rp{{ number_format($item->subtotal_cost,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-grid">
                <div>
                    <div class="summary-item">
                        <span class="summary-label">Total Bahan Baku</span>
                        <span class="summary-value">Rp{{ number_format($hpp->total_raw_material_cost,0,',','.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Biaya Sablon</span>
                        <span class="summary-value">Rp{{ number_format($hpp->screen_printing_fee,0,',','.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Biaya Jahit</span>
                        <span class="summary-value">Rp{{ number_format($hpp->sewing_fee,0,',','.') }}</span>
                    </div>
                </div>
                <div>
                    <div class="summary-item">
                        <span class="summary-label">Biaya Lainnya</span>
                        <span class="summary-value">Rp{{ number_format($hpp->other_fees,0,',','.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Target Harga Jual</span>
                        <span class="summary-value">Rp{{ number_format($hpp->target_selling_price,0,',','.') }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Total HPP / Unit</span>
                        <span class="summary-value total-value">Rp{{ number_format($hpp->total_hpp_per_unit,0,',','.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profit Analysis Section -->
        @php
            $profit = $hpp->target_selling_price - $hpp->total_hpp_per_unit;
            $profitMargin = $hpp->target_selling_price > 0 ? ($profit / $hpp->target_selling_price) * 100 : 0;
        @endphp
        <div class="profit-section">
            <div class="profit-info">
                <span class="profit-label">Estimated Profit per Unit</span>
                <span class="profit-value">Rp{{ number_format($profit, 0, ',', '.') }}</span>
            </div>
            <div class="profit-margin">
                {{ number_format($profitMargin, 1) }}% Margin
            </div>
        </div>
        
        <!-- Footer -->
        <div class="report-footer">
            <p class="footer-text">
                This report was generated by <strong>BizSight</strong> • HPP Precision Engine v2.0<br>
                {{ now()->format('d/m/Y H:i:s') }} • AVS Store Business Intelligence Platform
            </p>
        </div>
    </div>
</body>
</html>