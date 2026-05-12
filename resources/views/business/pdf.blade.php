<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Decision Engine Report #{{ $calc->id }}</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            background: #ffffff;
            margin: 0;
            padding: 0;
            color: #1E293B;
            font-size: 13px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        /* Header */
        table.header-table {
            width: 100%;
            background-color: #0F172A;
            color: #ffffff;
            padding: 40px 30px;
            border-bottom: 5px solid #F97316;
        }
        .header-title {
            font-size: 32px;
            font-weight: 800;
        }
        .header-title span {
            color: #F97316;
        }
        .header-subtitle {
            font-size: 13px;
            color: #F59E0B;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .report-info {
            text-align: right;
        }
        .report-info h2 {
            font-size: 22px;
            margin: 0;
            color: #ffffff;
        }
        .report-info p {
            font-size: 13px;
            color: #94A3B8;
            margin-top: 8px;
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
            font-size: 11px;
            font-weight: 800;
            color: #F97316;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
            display: block;
        }
        .info-value {
            font-size: 15px;
            font-weight: bold;
            color: #0F172A;
            display: block;
        }

        /* Content section */
        .content-section {
            padding: 30px;
        }
        
        .section-header {
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 3px solid #F97316;
            display: block;
        }
        .section-badge {
            background-color: #F97316;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-right: 8px;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #0F172A;
            display: inline-block;
            vertical-align: middle;
        }

        /* Panels */
        .panel {
            background-color: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        /* Hero */
        .hero-panel {
            background-color: #F97316;
            color: white;
            border: none;
        }
        .hero-title {
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 15px;
        }
        .hero-desc {
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            color: rgba(255,255,255,0.9);
        }

        /* Status colors */
        .color-critical { color: #DC2626; }
        .color-fragile { color: #D97706; }
        .color-healthy { color: #10B981; }

        /* Tables inside panels */
        table.grid-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.grid-table td {
            vertical-align: top;
            padding: 10px;
        }
        table.cost-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.cost-table td {
            padding: 8px 0;
            font-size: 13px;
        }
        .border-t {
            border-top: 1px solid #E2E8F0;
        }
        
        /* Lists */
        .list-item {
            padding: 12px 16px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
        }
        .list-risk {
            background-color: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
            border-left: 4px solid #DC2626;
        }
        .list-action {
            background-color: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
            border-left: 4px solid #10B981;
        }
        .list-driver {
            background-color: #ffffff;
            border: 1px solid #E2E8F0;
            color: #1E293B;
        }

        .snapshot-panel {
            background-color: #0F172A;
            color: white;
        }
        table.snapshot-grid {
            width: 100%;
            border-collapse: collapse;
        }
        table.snapshot-grid td {
            padding: 15px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.05);
            width: 50%;
        }
        .snap-label {
            font-size: 11px;
            color: #FDBA74;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .snap-value {
            font-size: 18px;
            font-weight: bold;
            color: white;
        }
        
        .footer {
            margin-top: 20px;
            padding: 24px 30px;
            text-align: center;
            font-size: 11px;
            color: #64748B;
            border-top: 1px solid #E2E8F0;
            background-color: #F8FAFC;
        }
        .footer strong {
            color: #F97316;
            font-weight: 800;
        }
    </style>
</head>
<body>
    @php
        $margin = $calc->net_margin_percent;
        $statusColor = $calc->status_label === 'CRITICAL' ? 'color-critical' : ($calc->status_label === 'FRAGILE' ? 'color-fragile' : 'color-healthy');
    @endphp

    <div class="container">
        <!-- Header -->
        <table class="header-table" cellspacing="0" cellpadding="0">
            <tr>
                <td width="50%">
                    <div class="header-title"><span>Clarity</span>Labs</div>
                    <div class="header-subtitle">Business Viability Engine</div>
                </td>
                <td width="50%" class="report-info">
                    <h2>Analysis Results</h2>
                    <p>Generated on {{ now()->format('d F Y, H:i') }}</p>
                </td>
            </tr>
        </table>

        <!-- Info Cards -->
        <table class="info-table" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <span class="info-label">Product Name</span>
                    <span class="info-value">{{ $calc->product_name }}</span>
                </td>
                <td>
                    <span class="info-label">Report ID</span>
                    <span class="info-value">#{{ $calc->id }}</span>
                </td>
                <td>
                    <span class="info-label">Analysis Date</span>
                    <span class="info-value">{{ $calc->created_at->format('d M Y') }}</span>
                </td>
            </tr>
        </table>

        <div class="content-section">
            
            <!-- 1. Hero Section -->
            <div class="panel hero-panel">
                <div style="font-size:12px; font-weight:bold; text-transform:uppercase; margin-bottom:10px; color:#FFEDD5;">1. Hero Section</div>
                <div class="hero-title">➜ {{ $calc->status_label == 'CRITICAL' ? 'Critical - Optimization Needed' : ($calc->status_label == 'FRAGILE' ? 'Proceed with Caution' : 'Green Light to Scale') }}</div>
                <div class="hero-desc">{{ $calc->logic_reason }}</div>
            </div>

            <!-- 2. Profit Reality -->
            <div class="section-header">
                <span class="section-badge">2</span>
                <span class="section-title">Profit Reality</span>
            </div>
            <div class="panel">
                <table class="grid-table">
                    <tr>
                        <td width="40%">
                            <div style="font-size:13px; color:#64748B; font-weight:bold; margin-bottom:5px;">Net Margin</div>
                            <div style="font-size:42px; font-weight:900;" class="{{ $statusColor }}">{{ number_format($margin, 1, ',', '.') }}%</div>
                            <div style="font-size:14px; font-weight:bold; margin-top:5px; text-transform:uppercase;" class="{{ $statusColor }}">{{ $calc->status_label }}</div>
                        </td>
                        <td width="60%">
                            <div style="font-size:11px; font-weight:bold; text-transform:uppercase; color:#94A3B8; margin-bottom:10px;">Cost Breakdown</div>
                            <table class="grid-table">
                                <tr>
                                    <td width="50%" style="padding:0 10px 0 0;">
                                        <table class="cost-table">
                                            <tr><td style="color:#64748B;">Revenue</td><td align="right"><b>100%</b></td></tr>
                                            <tr><td style="color:#64748B;">HPP</td><td align="right"><b>{{ number_format($hppPct ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Admin Fee</td><td align="right"><b>{{ number_format($calc->admin_fee_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Ads</td><td align="right"><b>{{ number_format($calc->ads_per_unit ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Affiliate</td><td align="right"><b>{{ number_format($calc->affiliate_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                        </table>
                                    </td>
                                    <td width="50%" style="padding:0 0 0 10px;">
                                        <table class="cost-table">
                                            <tr><td style="color:#64748B;">Promo</td><td align="right"><b>{{ number_format($calc->promo_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Overhead</td><td align="right"><b>{{ number_format($calc->overhead_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Tax</td><td align="right"><b>{{ number_format($calc->tax_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td colspan="2" class="border-t"></td></tr>
                                            <tr><td style="color:#0F172A; font-weight:bold;">Total Cost</td><td align="right" style="color:#0F172A; font-weight:bold;">{{ number_format($totalCostPct ?? 0, 1, ',', '.') }}%</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 3. Cost Pressure & 4. Risk -->
            <table class="grid-table" style="margin-bottom: 0;">
                <tr>
                    <td width="50%" style="padding: 0 10px 0 0;">
                        <div class="section-header">
                            <span class="section-badge">3</span>
                            <span class="section-title">Cost Pressure</span>
                        </div>
                        <div class="panel" style="padding:20px;">
                            <div style="font-size:11px; font-weight:bold; text-transform:uppercase; color:#94A3B8; margin-bottom:10px;">Biggest Cost Drivers</div>
                            @if(isset($topCosts))
                                @foreach($topCosts as $idx => $cost)
                                    <div class="list-item list-driver" style="display:table; width:100%; box-sizing:border-box;">
                                        <div style="display:table-cell; width:20px; color:#F97316;">{{ $idx + 1 }}.</div>
                                        <div style="display:table-cell; text-transform:capitalize;">{{ $cost[0] }}</div>
                                        <div style="display:table-cell; text-align:right;">{{ number_format($cost[1], 1, ',', '.') }}%</div>
                                    </div>
                                @endforeach
                            @endif
                            <div style="margin-top:15px; padding-top:15px; border-top:1px solid #E2E8F0; font-size:12px; color:#334155;">
                                <strong style="color:#1E3A8A;">Insight:</strong> {{ $insight ?? '' }}
                            </div>
                        </div>
                    </td>
                    <td width="50%" style="padding: 0 0 0 10px;">
                        <div class="section-header">
                            <span class="section-badge">4</span>
                            <span class="section-title">Risk Analysis</span>
                        </div>
                        <div class="panel" style="padding:20px;">
                            @if(isset($risks) && count($risks) > 0)
                                @foreach($risks as $risk)
                                    <div class="list-item list-risk">• {{ $risk }}</div>
                                @endforeach
                            @else
                                <p style="color:#64748B;">No significant risks identified.</p>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <!-- 5. Strategy & 6. Production -->
            <table class="grid-table" style="margin-bottom: 0;">
                <tr>
                    <td width="50%" style="padding: 0 10px 0 0;">
                        <div class="section-header">
                            <span class="section-badge">5</span>
                            <span class="section-title">Strategy Direction</span>
                        </div>
                        <div class="panel" style="padding:20px;">
                            <div style="font-size:11px; font-weight:bold; text-transform:uppercase; color:#EA580C; margin-bottom:5px;">Operating Mode</div>
                            <div style="font-size:24px; font-weight:900; color:#F97316; margin-bottom:10px;">{{ $strategy ?? '' }}</div>
                            <div style="font-size:13px; font-weight:bold; color:#475569;">Focus: {{ $focus ?? '' }}</div>
                        </div>
                    </td>
                    <td width="50%" style="padding: 0 0 0 10px;">
                        <div class="section-header">
                            <span class="section-badge">6</span>
                            <span class="section-title">Production Decision</span>
                        </div>
                        <div class="panel" style="padding:20px;">
                            <div style="font-size:11px; font-weight:bold; text-transform:uppercase; color:#EA580C; margin-bottom:5px;">Recommended Batch</div>
                            <div style="font-size:24px; font-weight:900; color:#F97316; margin-bottom:10px;">{{ number_format($calc->est_batch_quantity, 0, ',', '.') }} <span style="font-size:14px;">pcs</span></div>
                            <div style="font-size:13px; font-weight:bold; color:#475569;">Model: Batch Limited</div>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- 7. Ads & 8. Action Plan -->
            <table class="grid-table" style="margin-bottom: 0;">
                <tr>
                    <td width="40%" style="padding: 0 10px 0 0;">
                        <div class="section-header">
                            <span class="section-badge">7</span>
                            <span class="section-title">Ads Insight</span>
                        </div>
                        <div class="panel" style="padding:20px;">
                            <div style="font-size:14px; font-weight:bold; margin-bottom:10px;">Ads Cost: <span style="color:#F97316;">{{ number_format($calc->ads_per_unit ?? 0, 1, ',', '.') }}%</span></div>
                            <div style="font-size:11px; font-weight:bold; text-transform:uppercase; margin-bottom:5px;">Status: {{ $adsStatus ?? '' }}</div>
                            <div style="font-size:13px; color:#475569;">{{ $adsMessage ?? '' }}</div>
                        </div>
                    </td>
                    <td width="60%" style="padding: 0 0 0 10px;">
                        <div class="section-header">
                            <span class="section-badge">8</span>
                            <span class="section-title">Action Plan</span>
                        </div>
                        <div class="panel" style="padding:20px;">
                            @if(isset($actionPlan))
                                @foreach($actionPlan as $action)
                                    <div class="list-item list-action">✓ {{ $action }}</div>
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <!-- 9. Final Snapshot -->
            <div class="section-header" style="margin-top: 10px;">
                <span class="section-badge" style="background:#0F172A;">9</span>
                <span class="section-title">Final Snapshot</span>
            </div>
            <div class="panel snapshot-panel" style="padding:0; overflow:hidden;">
                <table class="snapshot-grid">
                    <tr>
                        <td>
                            <div class="snap-label">Status</div>
                            <div class="snap-value">{{ $calc->status_label }}</div>
                        </td>
                        <td>
                            <div class="snap-label">Mode</div>
                            <div class="snap-value">{{ $strategy ?? '' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="snap-label">Net Margin</div>
                            <div class="snap-value">{{ number_format($margin, 1, ',', '.') }}%</div>
                        </td>
                        <td>
                            <div class="snap-label">Risk Level</div>
                            <div class="snap-value">{{ $calc->status_label === 'CRITICAL' ? 'Extreme' : ($calc->status_label === 'FRAGILE' ? 'Medium - High' : 'Controlled') }}</div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="footer">
            This report was generated by <strong>ClarityLabs</strong> • Business Viability Engine v2.0<br>
            {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>