<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Decision Engine Report #{{ $calc->id }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Helvetica, Arial, sans-serif;
            background: #ffffff;
            color: #1E293B;
            font-size: 12px;
            line-height: 1.5;
        }

        /* ============ HEADER ============ */
        .header-wrap {
            background: #0F172A;
            width: 100%;
            padding: 28px 30px;
            border-bottom: 5px solid #F97316;
        }
        .header-inner {
            width: 100%;
        }
        .header-left { display: inline-block; width: 50%; vertical-align: top; }
        .header-right { display: inline-block; width: 49%; vertical-align: top; text-align: right; }
        .brand-title { font-size: 30px; font-weight: 800; color: #ffffff; }
        .brand-title .accent { color: #F97316; }
        .brand-sub { font-size: 11px; color: #F59E0B; text-transform: uppercase; letter-spacing: 2px; font-weight: bold; margin-top: 6px; }
        .rep-label { font-size: 20px; color: #ffffff; font-weight: 800; }
        .rep-date { font-size: 11px; color: #94A3B8; margin-top: 6px; }

        /* ============ META BAR ============ */
        table.meta-bar {
            width: 100%;
            border-collapse: collapse;
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
        }
        table.meta-bar td {
            width: 33.33%;
            padding: 16px 24px;
            vertical-align: top;
            border-right: 1px solid #E2E8F0;
        }
        table.meta-bar td:last-child { border-right: none; }
        .ml { font-size: 10px; font-weight: 800; color: #F97316; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .mv { font-size: 14px; font-weight: 800; color: #0F172A; }

        /* ============ CONTENT ============ */
        .content { padding: 24px 30px; }

        /* ============ HERO ============ */
        .hero-box {
            background: #F97316;
            padding: 20px 24px;
            margin-bottom: 20px;
            width: 100%;
        }
        .hero-tag { font-size: 10px; font-weight: 800; color: #FFEDD5; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .hero-title { font-size: 20px; font-weight: 900; color: #ffffff; margin-bottom: 8px; }
        .hero-desc { font-size: 12px; color: rgba(255,255,255,0.9); line-height: 1.6; }

        /* ============ SECTION HEADER ============ */
        .sec-hdr { margin-bottom: 12px; margin-top: 20px; padding-bottom: 6px; border-bottom: 3px solid #F97316; }
        .sec-badge {
            background: #F97316; color: #fff;
            padding: 3px 10px; font-size: 12px; font-weight: 800;
            display: inline-block; margin-right: 6px;
        }
        .sec-title { font-size: 16px; font-weight: 800; color: #0F172A; display: inline; vertical-align: middle; }

        /* ============ PANEL ============ */
        .panel {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            padding: 20px;
            margin-bottom: 20px;
            width: 100%;
        }

        /* ============ GRID TABLE ============ */
        table.g2 { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.g2 td { width: 50%; vertical-align: top; padding: 0; }
        table.g2 td.pad-r { padding-right: 10px; }
        table.g2 td.pad-l { padding-left: 10px; }

        /* ============ COST TABLE ============ */
        table.cost-tbl { width: 100%; border-collapse: collapse; }
        table.cost-tbl td { padding: 5px 2px; font-size: 12px; }
        .bd-t { border-top: 1px solid #E2E8F0; }

        /* ============ BIG METRIC ============ */
        .big-num { font-size: 38px; font-weight: 900; line-height: 1; }
        .big-lbl { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; }

        /* ============ LIST ITEMS ============ */
        .li-risk {
            background: #FEF2F2; border: 1px solid #FECACA;
            border-left: 4px solid #DC2626; color: #991B1B;
            padding: 10px 14px; margin-bottom: 8px; font-size: 12px; font-weight: bold; width: 100%;
        }
        .li-act {
            background: #ECFDF5; border: 1px solid #A7F3D0;
            border-left: 4px solid #10B981; color: #065F46;
            padding: 10px 14px; margin-bottom: 8px; font-size: 12px; font-weight: bold; width: 100%;
        }
        .li-drv {
            background: #ffffff; border: 1px solid #E2E8F0;
            padding: 10px 14px; margin-bottom: 8px; font-size: 12px; width: 100%;
        }

        /* ============ STATUS COLORS ============ */
        .c-crit { color: #DC2626; }
        .c-frag { color: #D97706; }
        .c-hlth { color: #10B981; }

        /* ============ INSIGHT BOX ============ */
        .insight-box { margin-top: 12px; padding-top: 12px; border-top: 1px solid #E2E8F0; font-size: 11px; color: #334155; }
        .insight-box strong { color: #1E3A8A; }

        /* ============ SNAPSHOT (dark) ============ */
        table.snap { width: 100%; border-collapse: collapse; background: #0F172A; margin-bottom: 20px; }
        table.snap td {
            width: 25%; padding: 16px 20px; border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.05);
        }
        .snap-lbl { font-size: 10px; color: #FDBA74; text-transform: uppercase; font-weight: bold; margin-bottom: 4px; }
        .snap-val { font-size: 16px; font-weight: 800; color: #ffffff; }

        /* ============ FOOTER ============ */
        .footer {
            margin-top: 16px; padding: 18px 30px;
            text-align: center; font-size: 10px; color: #64748B;
            border-top: 1px solid #E2E8F0; background: #F8FAFC;
        }
        .footer strong { color: #F97316; font-weight: 800; }

        /* ============ PAGE BREAK ============ */
        .pb-avoid { page-break-inside: avoid; }
        .pb { page-break-after: always; }
    </style>
</head>
<body>
@php
    $margin = $calc->net_margin_percent;
    $sc = $calc->status_label === 'CRITICAL' ? 'c-crit' : ($calc->status_label === 'FRAGILE' ? 'c-frag' : 'c-hlth');
@endphp

    <!-- ===== HEADER ===== -->
    <div class="header-wrap">
        <div class="header-inner">
            <span class="header-left">
                <div class="brand-title"><span class="accent">Clarity</span>Labs</div>
                <div class="brand-sub">Business Viability Engine</div>
            </span>
            <span class="header-right">
                <div class="rep-label">Analysis Results</div>
                <div class="rep-date">Generated on {{ now()->format('d F Y, H:i') }}</div>
            </span>
        </div>
    </div>

    <!-- ===== META BAR ===== -->
    <table class="meta-bar" cellspacing="0" cellpadding="0">
        <tr>
            <td><div class="ml">Product Name</div><div class="mv">{{ $calc->product_name }}</div></td>
            <td><div class="ml">Report ID</div><div class="mv">#{{ $calc->id }}</div></td>
            <td><div class="ml">Analysis Date</div><div class="mv">{{ $calc->created_at->format('d M Y') }}</div></td>
        </tr>
    </table>

    <div class="content">

        <!-- ===== 1. HERO ===== -->
        <div class="pb-avoid">
            <div class="hero-box">
                <div class="hero-tag">1. Executive Summary</div>
                <div class="hero-title">
                    ➜ {{ $calc->status_label == 'CRITICAL' ? 'Critical - Optimization Needed' : ($calc->status_label == 'FRAGILE' ? 'Proceed with Caution' : 'Green Light to Scale') }}
                </div>
                <div class="hero-desc">{{ $calc->logic_reason }}</div>
            </div>
        </div>

        <!-- ===== 2. PROFIT REALITY ===== -->
        <div class="pb-avoid">
            <div class="sec-hdr">
                <span class="sec-badge">2</span>
                <span class="sec-title">Profit Reality</span>
            </div>
            <div class="panel">
                <table class="g2">
                    <tr>
                        <td class="pad-r" style="width:38%;">
                            <div style="font-size:11px; color:#64748B; font-weight:bold; margin-bottom:4px;">Net Margin</div>
                            <div class="big-num {{ $sc }}">{{ number_format($margin, 1, ',', '.') }}%</div>
                            <div class="big-lbl {{ $sc }}">{{ $calc->status_label }}</div>
                        </td>
                        <td class="pad-l" style="width:62%;">
                            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#94A3B8; margin-bottom:8px;">Cost Breakdown</div>
                            <table class="g2">
                                <tr>
                                    <td class="pad-r">
                                        <table class="cost-tbl">
                                            <tr><td style="color:#64748B;">Revenue</td><td align="right"><b>100%</b></td></tr>
                                            <tr><td style="color:#64748B;">HPP</td><td align="right"><b>{{ number_format($hppPct ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Admin Fee</td><td align="right"><b>{{ number_format($calc->admin_fee_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Ads</td><td align="right"><b>{{ number_format($calc->ads_per_unit ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Affiliate</td><td align="right"><b>{{ number_format($calc->affiliate_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                        </table>
                                    </td>
                                    <td class="pad-l">
                                        <table class="cost-tbl">
                                            <tr><td style="color:#64748B;">Promo</td><td align="right"><b>{{ number_format($calc->promo_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Overhead</td><td align="right"><b>{{ number_format($calc->overhead_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td style="color:#64748B;">Tax</td><td align="right"><b>{{ number_format($calc->tax_percent ?? 0, 1, ',', '.') }}%</b></td></tr>
                                            <tr><td colspan="2" class="bd-t" style="padding-top:6px;"></td></tr>
                                            <tr><td style="color:#0F172A; font-weight:bold;">Total Cost</td><td align="right" style="color:#0F172A; font-weight:bold;">{{ number_format($totalCostPct ?? 0, 1, ',', '.') }}%</td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- ===== 3 & 4: COST PRESSURE + RISK ===== -->
        <div class="pb-avoid">
            <table class="g2">
                <tr>
                    <td class="pad-r">
                        <div class="sec-hdr">
                            <span class="sec-badge">3</span>
                            <span class="sec-title">Cost Pressure</span>
                        </div>
                        <div class="panel">
                            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#94A3B8; margin-bottom:10px;">Biggest Cost Drivers</div>
                            @if(isset($topCosts))
                                @foreach($topCosts as $idx => $cost)
                                    <div class="li-drv">
                                        <span style="color:#F97316; font-weight:800;">{{ $idx + 1 }}.</span>
                                        <span style="text-transform:capitalize; margin-left:4px;">{{ $cost[0] }}</span>
                                        <span style="float:right; font-weight:800;">{{ number_format($cost[1], 1, ',', '.') }}%</span>
                                    </div>
                                @endforeach
                            @endif
                            <div class="insight-box">
                                <strong>Insight:</strong> {{ $insight ?? '' }}
                            </div>
                        </div>
                    </td>
                    <td class="pad-l">
                        <div class="sec-hdr">
                            <span class="sec-badge">4</span>
                            <span class="sec-title">Risk Analysis</span>
                        </div>
                        <div class="panel">
                            @if(isset($risks) && count($risks) > 0)
                                @foreach($risks as $risk)
                                    <div class="li-risk">• {{ $risk }}</div>
                                @endforeach
                            @else
                                <p style="color:#64748B;">No significant risks identified.</p>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- ===== 5 & 6: STRATEGY + PRODUCTION ===== -->
        <div class="pb-avoid">
            <table class="g2">
                <tr>
                    <td class="pad-r">
                        <div class="sec-hdr">
                            <span class="sec-badge">5</span>
                            <span class="sec-title">Strategy Direction</span>
                        </div>
                        <div class="panel">
                            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#EA580C; margin-bottom:4px;">Operating Mode</div>
                            <div style="font-size:22px; font-weight:900; color:#F97316; margin-bottom:8px;">{{ $strategy ?? '' }}</div>
                            <div style="font-size:12px; font-weight:bold; color:#475569;">Focus: {{ $focus ?? '' }}</div>
                        </div>
                    </td>
                    <td class="pad-l">
                        <div class="sec-hdr">
                            <span class="sec-badge">6</span>
                            <span class="sec-title">Production Decision</span>
                        </div>
                        <div class="panel">
                            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#EA580C; margin-bottom:4px;">Recommended Batch</div>
                            <div style="font-size:22px; font-weight:900; color:#F97316; margin-bottom:8px;">{{ number_format($calc->est_batch_quantity, 0, ',', '.') }} <span style="font-size:12px;">pcs</span></div>
                            <div style="font-size:12px; font-weight:bold; color:#475569;">Model: Batch Limited</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- ===== 7 & 8: ADS + ACTION PLAN ===== -->
        <div class="pb-avoid">
            <table class="g2">
                <tr>
                    <td class="pad-r" style="width:38%;">
                        <div class="sec-hdr">
                            <span class="sec-badge">7</span>
                            <span class="sec-title">Ads Insight</span>
                        </div>
                        <div class="panel">
                            <div style="font-size:13px; font-weight:bold; margin-bottom:8px;">Ads Cost: <span style="color:#F97316;">{{ number_format($calc->ads_per_unit ?? 0, 1, ',', '.') }}%</span></div>
                            <div style="font-size:10px; font-weight:800; text-transform:uppercase; margin-bottom:4px;">Status: {{ $adsStatus ?? '' }}</div>
                            <div style="font-size:12px; color:#475569;">{{ $adsMessage ?? '' }}</div>
                        </div>
                    </td>
                    <td class="pad-l" style="width:62%;">
                        <div class="sec-hdr">
                            <span class="sec-badge">8</span>
                            <span class="sec-title">Action Plan</span>
                        </div>
                        <div class="panel">
                            @if(isset($actionPlan))
                                @foreach($actionPlan as $action)
                                    <div class="li-act">✓ {{ $action }}</div>
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- ===== 9. FINAL SNAPSHOT ===== -->
        <div class="pb-avoid">
            <div class="sec-hdr" style="margin-top:8px;">
                <span class="sec-badge" style="background:#0F172A;">9</span>
                <span class="sec-title">Final Snapshot</span>
            </div>
            <table class="snap" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <div class="snap-lbl">Status</div>
                        <div class="snap-val">{{ $calc->status_label }}</div>
                    </td>
                    <td>
                        <div class="snap-lbl">Operating Mode</div>
                        <div class="snap-val">{{ $strategy ?? '' }}</div>
                    </td>
                    <td>
                        <div class="snap-lbl">Net Margin</div>
                        <div class="snap-val">{{ number_format($margin, 1, ',', '.') }}%</div>
                    </td>
                    <td>
                        <div class="snap-lbl">Risk Level</div>
                        <div class="snap-val">{{ $calc->status_label === 'CRITICAL' ? 'Extreme' : ($calc->status_label === 'FRAGILE' ? 'Medium - High' : 'Controlled') }}</div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    <!-- ===== FOOTER ===== -->
    <div class="footer">
        This report was generated by <strong>ClarityLabs</strong> • Business Viability Engine v2.0<br>
        {{ now()->format('d/m/Y H:i:s') }}
    </div>

</body>
</html>