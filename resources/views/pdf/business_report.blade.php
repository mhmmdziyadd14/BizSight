{{-- File: hpp-production-report-print.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>HPP Production Report - {{ $data->hpp_id ?? 'BZS-REF' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap');
        
        @page {
            margin: 1.5cm;
            size: A4;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            color: #1E293B;
            line-height: 1.5;
            background: #F8FAFC;
            margin: 0;
            padding: 20px;
        }
        
        .report-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.1);
        }
        
        /* Header Section */
        .header {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            padding: 32px 40px;
            border-bottom: 4px solid #F97316;
        }
        
        .logo-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .brand {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }
        
        .brand-main {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
            color: white;
        }
        
        .brand-highlight {
            background: linear-gradient(135deg, #F97316, #F59E0B);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
        }
        
        .doc-title {
            font-size: 10px;
            font-weight: 800;
            color: #F59E0B;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: rgba(249, 115, 22, 0.2);
            padding: 6px 12px;
            border-radius: 40px;
        }
        
        .report-info {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(249, 115, 22, 0.3);
        }
        
        .report-info h1 {
            font-size: 24px;
            font-weight: 800;
            color: white;
            margin: 0 0 8px 0;
        }
        
        .report-info p {
            font-size: 12px;
            color: #94A3B8;
            margin: 0;
        }
        
        /* Meta Grid */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            padding: 32px 40px;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
        }
        
        .meta-item {
            background: white;
            padding: 16px 20px;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            transition: all 0.2s ease;
        }
        
        .meta-label {
            font-size: 9px;
            font-weight: 800;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .meta-value {
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
        
        .section-badge {
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
            font-size: 16px;
            font-weight: 800;
            color: #0F172A;
            margin: 0;
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
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #F97316;
            border-bottom: 2px solid #F97316;
            text-align: left;
        }
        
        td {
            padding: 14px 16px;
            font-size: 12px;
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
        
        .material-name {
            font-weight: 700;
            color: #0F172A;
        }
        
        .material-type {
            font-size: 9px;
            color: #F97316;
            font-weight: 600;
            display: block;
            margin-top: 4px;
        }
        
        .unit-badge {
            display: inline-block;
            padding: 4px 8px;
            background: #F1F5F9;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            color: #475569;
        }
        
        /* Total Card */
        .total-container {
            margin: 0 40px 32px 40px;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border-radius: 20px;
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            border: 1px solid rgba(249, 115, 22, 0.3);
        }
        
        .total-label {
            font-size: 11px;
            font-weight: 800;
            color: #F59E0B;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .total-amount {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(135deg, #F97316, #F59E0B);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        /* Profit Section (if available) */
        .profit-section {
            margin: 0 40px 32px 40px;
            background: linear-gradient(135deg, #FEF3C7 0%, #FFEDD5 100%);
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
            font-size: 9px;
            font-weight: 800;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        
        .profit-value {
            font-size: 20px;
            font-weight: 800;
            color: #0F172A;
        }
        
        .profit-positive {
            color: #10B981;
        }
        
        .profit-negative {
            color: #EF4444;
        }
        
        /* Footer */
        .footer-note {
            padding: 24px 40px;
            background: #F8FAFC;
            border-top: 1px solid #E2E8F0;
            text-align: center;
        }
        
        .footer-text {
            font-size: 9px;
            color: #64748B;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .footer-text strong {
            color: #F97316;
            font-weight: 700;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94A3B8;
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
            
            .total-container, .profit-section {
                break-inside: avoid;
            }
            
            @page {
                margin: 1.5cm;
            }
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .header {
                padding: 24px;
            }
            
            .meta-grid {
                padding: 24px;
                grid-template-columns: 1fr;
            }
            
            .table-section {
                padding: 24px;
            }
            
            .total-container {
                margin: 0 24px 24px 24px;
                padding: 20px;
            }
            
            .profit-section {
                margin: 0 24px 24px 24px;
                padding: 16px 20px;
            }
            
            .footer-note {
                padding: 20px;
            }
            
            .total-amount {
                font-size: 24px;
            }
            
            th, td {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <div class="brand">
                    <span class="brand-highlight">Clarity</span>
                    <span class="brand-main">Labs</span>
                </div>
                <div class="doc-title">HPP Production Report</div>
            </div>
            <div class="report-info">
                <h1>HPP Calculation Report</h1>
                <p>Generated on {{ now()->format('d F Y, H:i') }} • Precision Business Analysis</p>
            </div>
        </div>

        <!-- Meta Information -->
        <div class="meta-grid">
            <div class="meta-item">
                <div class="meta-label">ID Perhitungan</div>
                <div class="meta-value">{{ $data->hpp_id ?? 'BZS-REF-' . rand(100, 999) }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Nama Produk</div>
                <div class="meta-value">{{ $data->name ?? 'Project Tanpa Nama' }}</div>
            </div>
            @if(isset($data->category))
            <div class="meta-item">
                <div class="meta-label">Kategori</div>
                <div class="meta-value">{{ $data->category }}</div>
            </div>
            @endif
            @if(isset($data->created_at))
            <div class="meta-item">
                <div class="meta-label">Tanggal Pembuatan</div>
                <div class="meta-value">{{ $data->created_at->format('d M Y') }}</div>
            </div>
            @endif
        </div>

        <!-- Materials Table -->
        <div class="table-section">
            <div class="section-title">
                <div class="section-badge">01</div>
                <h3>Bill of Materials</h3>
            </div>

            @if(isset($data->items) && $data->items->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Komponen Bahan Baku</th>
                        <th class="text-right">Volume</th>
                        <th class="text-right">Harga Satuan</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->items as $item)
                    <tr>
                        <td>
                            <span class="material-name">{{ $item->material->name }}</span>
                            <span class="material-type">{{ $item->material->type }}</span>
                        </td>
                        <td class="text-right">
                            <span class="unit-badge">{{ number_format($item->usage_amount, 2, ',', '.') }} {{ $item->material->unit }}</span>
                        </td>
                        <td class="text-right">Rp {{ number_format($item->material->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal_cost, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 16px;">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p>Tidak ada rincian bahan baku.</p>
            </div>
            @endif
        </div>

        <!-- Total HPP Card -->
        <div class="total-container">
            <div>
                <div class="total-label">Total HPP Produksi / Unit</div>
                <div class="total-amount">Rp {{ number_format($data->total_hpp_per_unit ?? 0, 0, ',', '.') }}</div>
            </div>
            <div>
                <div class="total-label">Status</div>
                <div style="font-size: 14px; font-weight: 700; color: #F59E0B;">
                    {{ isset($data->total_hpp_per_unit) && $data->total_hpp_per_unit > 0 ? 'Calculated' : 'Pending' }}
                </div>
            </div>
        </div>

        <!-- Profit Analysis Section (if target price exists) -->
        @if(isset($data->target_selling_price) && $data->target_selling_price > 0)
            @php
                $profit = $data->target_selling_price - ($data->total_hpp_per_unit ?? 0);
                $profitMargin = $data->target_selling_price > 0 ? ($profit / $data->target_selling_price) * 100 : 0;
            @endphp
            <div class="profit-section">
                <div class="profit-item">
                    <div class="profit-label">Target Harga Jual</div>
                    <div class="profit-value">Rp {{ number_format($data->target_selling_price, 0, ',', '.') }}</div>
                </div>
                <div class="profit-item">
                    <div class="profit-label">Estimasi Profit / Unit</div>
                    <div class="profit-value {{ $profit >= 0 ? 'profit-positive' : 'profit-negative' }}">
                        Rp {{ number_format($profit, 0, ',', '.') }}
                    </div>
                </div>
                <div class="profit-item">
                    <div class="profit-label">Profit Margin</div>
                    <div class="profit-value {{ $profitMargin >= 0 ? 'profit-positive' : 'profit-negative' }}">
                        {{ number_format($profitMargin, 1) }}%
                    </div>
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer-note">
            <div class="footer-text">
                Analyzed by <strong>ClarityLabs System</strong> • HPP Precision Engine v2.0
            </div>
            <div class="footer-text" style="margin-top: 8px; letter-spacing: 1px;">
                Developed by Muhammad Ziyad • Institut Teknologi Nasional Bandung
            </div>
        </div>
    </div>
</body>
</html>