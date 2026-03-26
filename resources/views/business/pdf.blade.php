{{-- File: business-viability-report-print.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Report #{{ $calc->id }}</title>
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
            max-width: 900px;
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
        
        /* Product Info Cards */
        .product-info {
            padding: 24px 40px;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
        }
        
        .info-item {
            flex: 1;
            min-width: 200px;
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
        
        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 60px;
            font-weight: 800;
            font-size: 14px;
        }
        
        .status-healthy {
            background: linear-gradient(135deg, #10B98110 0%, #05966920 100%);
            color: #059669;
            border: 1px solid #10B98130;
        }
        
        .status-risky {
            background: linear-gradient(135deg, #F59E0B10 0%, #F9731620 100%);
            color: #F59E0B;
            border: 1px solid #F9731630;
        }
        
        .status-danger {
            background: linear-gradient(135deg, #EF444410 0%, #DC262620 100%);
            color: #DC2626;
            border: 1px solid #EF444430;
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
            padding: 14px 20px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #F97316;
            border-bottom: 2px solid #F97316;
            text-align: left;
        }
        
        td {
            padding: 14px 20px;
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
        
        .field-name {
            font-weight: 700;
            color: #0F172A;
        }
        
        .value-positive {
            color: #10B981;
            font-weight: 800;
        }
        
        .value-negative {
            color: #EF4444;
            font-weight: 800;
        }
        
        /* Analysis Cards */
        .analysis-section {
            margin: 0 40px 32px 40px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .analysis-card {
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
            border-radius: 20px;
            padding: 24px;
        }
        
        .analysis-card h4 {
            font-size: 11px;
            font-weight: 800;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }
        
        .analysis-card p {
            font-size: 14px;
            line-height: 1.6;
            color: #1E293B;
            font-weight: 500;
        }
        
        .action-card {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border-radius: 20px;
            padding: 24px;
        }
        
        .action-card h4 {
            font-size: 11px;
            font-weight: 800;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }
        
        .action-card p {
            font-size: 14px;
            line-height: 1.6;
            color: white;
            font-weight: 500;
        }
        
        /* Profit Summary */
        .profit-summary {
            margin: 0 40px 32px 40px;
            background: linear-gradient(135deg, #F97316 0%, #F59E0B 100%);
            border-radius: 20px;
            padding: 20px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .profit-item {
            display: flex;
            flex-direction: column;
        }
        
        .profit-label {
            font-size: 10px;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        
        .profit-value {
            font-size: 24px;
            font-weight: 800;
            color: white;
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
            
            tr:hover td {
                background: none;
            }
            
            .analysis-card, .action-card, .profit-summary {
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
            
            .product-info {
                padding: 20px;
                flex-direction: column;
                gap: 16px;
            }
            
            .table-section {
                padding: 24px;
            }
            
            .analysis-section {
                margin: 0 20px 24px 20px;
                grid-template-columns: 1fr;
            }
            
            .profit-summary {
                margin: 0 20px 24px 20px;
                flex-direction: column;
                text-align: center;
            }
            
            .report-footer {
                padding: 20px;
            }
            
            th, td {
                padding: 10px 12px;
                font-size: 12px;
            }
            
            .profit-value {
                font-size: 20px;
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="logo-text">
                    <h1><span>Biz</span>Sight</h1>
                    <p>Business Viability Report</p>
                </div>
            </div>
            <div class="report-title">
                <h2>Business Viability Report</h2>
                <p>Generated on {{ now()->format('d F Y, H:i') }}</p>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="product-info">
            <div class="info-item">
                <div class="info-label">Product Name</div>
                <div class="info-value">{{ $calc->product_name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Analysis Date</div>
                <div class="info-value">{{ $calc->created_at->format('d M Y, H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Report ID</div>
                <div class="info-value">#{{ $calc->id }}</div>
            </div>
        </div>
        
        <!-- Financial Details Table -->
        <div class="table-section">
            <div class="section-title">
                <div class="badge">01</div>
                <h3>Financial Analysis</h3>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th class="text-right">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="field-name">HPP (Cost of Goods Sold)</td>
                        <td class="text-right">Rp{{ number_format($calc->hpp, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="field-name">Selling Price</td>
                        <td class="text-right">Rp{{ number_format($calc->selling_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="field-name">Ads Cost per Unit</td>
                        <td class="text-right">Rp{{ number_format($calc->ads_per_unit, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="field-name">Batch Quantity</td>
                        <td class="text-right">{{ number_format($calc->est_batch_quantity, 0, ',', '.') }} pcs</td>
                    </tr>
                    <tr>
                        <td class="field-name">Total Ads Cost</td>
                        <td class="text-right">Rp{{ number_format($calc->ads_per_unit * $calc->est_batch_quantity, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="field-name">Gross Profit per Unit</td>
                        <td class="text-right">Rp{{ number_format($calc->selling_price - $calc->hpp, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="field-name">Net Profit per Unit</td>
                        <td class="text-right {{ $calc->net_profit >= 0 ? 'value-positive' : 'value-negative' }}">
                            Rp{{ number_format($calc->net_profit, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="field-name">Net Margin</td>
                        <td class="text-right {{ $calc->net_margin_percent >= 20 ? 'value-positive' : ($calc->net_margin_percent >= 10 ? '' : 'value-negative') }}">
                            {{ number_format($calc->net_margin_percent, 1) }}%
                        </td>
                    </tr>
                    <tr>
                        <td class="field-name">Break Even Point (BEP)</td>
                        <td class="text-right">{{ number_format($calc->bep_unit, 0, ',', '.') }} pcs</td>
                    </tr>
                    <tr>
                        <td class="field-name">Business Status</td>
                        <td class="text-right">
                            @php
                                $statusClass = 'status-healthy';
                                $statusLabel = $calc->status_label;
                                if (strtoupper($calc->status_label) === 'HEALTHY') {
                                    $statusClass = 'status-healthy';
                                } elseif (strtoupper($calc->status_label) === 'RISKY') {
                                    $statusClass = 'status-risky';
                                } else {
                                    $statusClass = 'status-danger';
                                }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                @if(strtoupper($calc->status_label) === 'HEALTHY')
                                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @elseif(strtoupper($calc->status_label) === 'RISKY')
                                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                {{ $calc->status_label }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Analysis Cards -->
        <div class="analysis-section">
            <div class="analysis-card">
                <h4>📊 Logic Reasoning</h4>
                <p>{{ $calc->logic_reason }}</p>
            </div>
            <div class="action-card">
                <h4>⚡ Action Required</h4>
                <p>{{ $calc->action_required }}</p>
            </div>
        </div>
        
        <!-- Profit Summary -->
        @php
            $profit = $calc->selling_price - $calc->hpp;
            $profitMargin = $calc->selling_price > 0 ? ($profit / $calc->selling_price) * 100 : 0;
        @endphp
        <div class="profit-summary">
            <div class="profit-item">
                <div class="profit-label">Gross Profit / Unit</div>
                <div class="profit-value">Rp{{ number_format($profit, 0, ',', '.') }}</div>
            </div>
            <div class="profit-item">
                <div class="profit-label">Gross Margin</div>
                <div class="profit-value">{{ number_format($profitMargin, 1) }}%</div>
            </div>
            <div class="profit-item">
                <div class="profit-label">Net Profit / Unit</div>
                <div class="profit-value">Rp{{ number_format($calc->net_profit, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="report-footer">
            <p class="footer-text">
                This report was generated by <strong>BizSight</strong> • Business Viability Engine v2.0<br>
                {{ now()->format('d/m/Y H:i:s') }} • AVS Store Business Intelligence Platform
            </p>
        </div>
    </div>
</body>
</html>