@extends('layouts.admin')

@section('styles')
<style>
:root {
    --d-bg:        var(--z-bg,        #f1f5f9);
    --d-surface:   var(--z-surface,   #ffffff);
    --d-surface2:  var(--z-surface-2, #f8fafc);
    --d-border:    var(--z-border,    #e2e8f0);
    --d-text:      var(--z-text,      #1e293b);
    --d-muted:     var(--z-text-muted,#64748b);
    --d-faint:     var(--z-text-faint,#94a3b8);
    --d-primary:   var(--z-primary,   #27ba4d);
    --d-radius:    14px;
    --d-shadow:    0 1px 4px rgba(0,0,0,.05);
    --d-shadow-md: 0 6px 20px rgba(0,0,0,.08);
}

/* ── Page wrapper ── */
.dash-wrap { padding: 0 4px; }

/* ── Page Header ── */
.dash-header { display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:28px; }
.dash-title  { font-size:1.3rem; font-weight:800; color:var(--d-text); margin:0; line-height:1.2; }
.dash-subtitle { font-size:.8rem; color:var(--d-muted); margin-top:4px; }
.dash-date-pill { display:inline-flex; align-items:center; gap:7px; background:var(--d-surface); border:1px solid var(--d-border); border-radius:10px; padding:7px 14px; font-size:.77rem; font-weight:600; color:var(--d-muted); box-shadow:var(--d-shadow); }
.dash-date-pill i { color:var(--d-primary); }

/* ── Sub banner ── */
.dash-sub-banner { display:flex; align-items:center; gap:10px; background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:11px 16px; margin-bottom:24px; font-size:.82rem; color:#92400e; font-weight:500; }
[data-z-theme="dark"] .dash-sub-banner { background:rgba(245,158,11,.08); border-color:rgba(245,158,11,.2); color:#fbbf24; }
.dash-sub-banner i { color:#f59e0b; font-size:1rem; flex-shrink:0; }

/* ── Section Label ── */
.dash-section-label { display:flex; align-items:center; gap:8px; font-size:.7rem; font-weight:800; letter-spacing:1.1px; text-transform:uppercase; color:var(--d-faint); margin-bottom:14px; margin-top:28px; }
.dash-section-label::after { content:''; flex:1; height:1px; background:var(--d-border); }
.dash-section-label .label-icon { width:22px; height:22px; border-radius:6px; background:rgba(79,124,255,.1); color:#4f7cff; display:flex; align-items:center; justify-content:center; font-size:.62rem; }

/* ── KPI Grid ── */
.kpi-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(165px,1fr)); gap:12px; margin-bottom:6px; }
.kpi-card { background:var(--d-surface); border:1px solid var(--d-border); border-radius:var(--d-radius); padding:16px 16px 14px; box-shadow:var(--d-shadow); position:relative; overflow:hidden; transition:transform .18s,box-shadow .18s; cursor:default; }
.kpi-card:hover { transform:translateY(-3px); box-shadow:var(--d-shadow-md); }
.kpi-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--kpi-accent,#4f7cff); border-radius:var(--d-radius) var(--d-radius) 0 0; }
.kpi-card::after  { content:''; position:absolute; bottom:-20px; right:-10px; width:70px; height:70px; border-radius:50%; background:var(--kpi-accent,#4f7cff); opacity:.04; pointer-events:none; }
.kpi-icon  { width:36px; height:36px; border-radius:10px; background:var(--kpi-bg,rgba(79,124,255,.1)); color:var(--kpi-accent,#4f7cff); display:flex; align-items:center; justify-content:center; font-size:.85rem; margin-bottom:11px; }
.kpi-label { font-size:.67rem; font-weight:700; letter-spacing:.5px; text-transform:uppercase; color:var(--d-faint); margin-bottom:4px; line-height:1.4; }
.kpi-value { font-size:1.7rem; font-weight:800; color:var(--d-text); line-height:1; font-variant-numeric:tabular-nums; letter-spacing:-1px; }
.kpi-sub   { margin-top:6px; font-size:.68rem; color:var(--d-faint); display:flex; align-items:center; gap:4px; }
.kpi-sub.up   { color:#10b981; }
.kpi-sub.down { color:#ef4444; }
.kpi-stars { display:flex; gap:2px; margin-top:6px; }
.kpi-stars i { font-size:.65rem; }

/* KPI themes */
.kpi-blue   { --kpi-accent:#4f7cff; --kpi-bg:rgba(79,124,255,.09); }
.kpi-green  { --kpi-accent:#10b981; --kpi-bg:rgba(16,185,129,.09); }
.kpi-amber  { --kpi-accent:#f59e0b; --kpi-bg:rgba(245,158,11,.09); }
.kpi-red    { --kpi-accent:#ef4444; --kpi-bg:rgba(239,68,68,.09);  }
.kpi-cyan   { --kpi-accent:#06b6d4; --kpi-bg:rgba(6,182,212,.09);  }
.kpi-purple { --kpi-accent:#8b5cf6; --kpi-bg:rgba(139,92,246,.09); }
.kpi-rose   { --kpi-accent:#f43f5e; --kpi-bg:rgba(244,63,94,.09);  }
.kpi-teal   { --kpi-accent:#14b8a6; --kpi-bg:rgba(20,184,166,.09); }
.kpi-indigo { --kpi-accent:#6366f1; --kpi-bg:rgba(99,102,241,.09); }
.kpi-orange { --kpi-accent:#f97316; --kpi-bg:rgba(249,115,22,.09); }
.kpi-lime   { --kpi-accent:#84cc16; --kpi-bg:rgba(132,204,22,.09); }
.kpi-pink   { --kpi-accent:#ec4899; --kpi-bg:rgba(236,72,153,.09); }

[data-z-theme="dark"] .kpi-card { background:var(--z-surface,#1c1b19); border-color:var(--z-border,#393836); }
[data-z-theme="dark"] .kpi-value { color:var(--z-text,#cdccca); }
[data-z-theme="dark"] .kpi-label { color:var(--z-text-faint,#5a5957); }

/* ── Chart card ── */
.chart-card { background:var(--d-surface); border:1px solid var(--d-border); border-radius:var(--d-radius); padding:18px 16px 14px; box-shadow:var(--d-shadow); margin-bottom:16px; }
.chart-card-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid var(--d-border); }
.chart-card-title { font-size:.82rem; font-weight:700; color:var(--d-text); display:flex; align-items:center; gap:8px; margin:0; }
.chart-card-icon  { width:26px; height:26px; border-radius:7px; background:rgba(79,124,255,.1); color:#4f7cff; display:flex; align-items:center; justify-content:center; font-size:.65rem; }
[data-z-theme="dark"] .chart-card { background:var(--z-surface,#1c1b19); border-color:var(--z-border,#393836); }
[data-z-theme="dark"] .chart-card-head { border-color:var(--z-border,#393836); }
[data-z-theme="dark"] .chart-card-title { color:var(--z-text,#cdccca); }

/* ── Table card ── */
.t-card { background:var(--d-surface); border:1px solid var(--d-border); border-radius:var(--d-radius); overflow:hidden; box-shadow:var(--d-shadow); margin-bottom:16px; }
.t-card-head { display:flex; align-items:center; gap:8px; padding:12px 16px; border-bottom:1px solid var(--d-border); background:var(--d-surface2); }
.t-card-head h6 { font-size:.82rem; font-weight:700; color:var(--d-text); margin:0; }
.t-card-head i { color:#4f7cff; }
.t-card .table { margin:0; font-size:.78rem; }
.t-card .table thead th { background:var(--d-surface2); color:var(--d-faint); font-size:.67rem; font-weight:800; text-transform:uppercase; letter-spacing:.5px; padding:8px 14px; border-bottom:1px solid var(--d-border); border-top:none; }
.t-card .table tbody td { padding:9px 14px; color:var(--d-muted); border-color:var(--d-border); vertical-align:middle; }
.t-card .table tbody tr:hover { background:var(--d-surface2); }
.t-card .table tbody tr:last-child td { border-bottom:none; }
.t-empty { text-align:center; padding:24px 16px; color:var(--d-faint); font-size:.8rem; }
.t-empty i { font-size:1.6rem; display:block; margin-bottom:6px; opacity:.4; }
[data-z-theme="dark"] .t-card { background:var(--z-surface,#1c1b19); border-color:var(--z-border,#393836); }
[data-z-theme="dark"] .t-card-head { background:var(--z-surface-offset,#1d1c1a); border-color:var(--z-border,#393836); }
[data-z-theme="dark"] .t-card-head h6 { color:var(--z-text,#cdccca); }
[data-z-theme="dark"] .t-card .table thead th { background:var(--z-surface-offset,#1d1c1a); color:var(--z-text-faint,#5a5957); border-color:var(--z-border,#393836); }
[data-z-theme="dark"] .t-card .table tbody td { color:var(--z-text-muted,#797876); border-color:var(--z-border,#393836); }
[data-z-theme="dark"] .t-card .table tbody tr:hover { background:var(--z-surface-offset,#1d1c1a); }

/* ── Rating bar ── */
.rating-bar-row { display:flex; align-items:center; gap:10px; margin-bottom:8px; font-size:.78rem; color:var(--d-muted); }
.rating-bar-label { width:28px; text-align:right; flex-shrink:0; }
.rating-bar-track { flex:1; height:7px; background:var(--d-border); border-radius:99px; overflow:hidden; }
.rating-bar-fill  { height:100%; border-radius:99px; background:#fbbf24; }
.rating-bar-count { width:28px; text-align:left; flex-shrink:0; font-weight:700; color:var(--d-text); }

/* ── Status pill ── */
.s-pill { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:99px; font-size:.7rem; font-weight:700; }
.s-pill.green  { background:rgba(16,185,129,.1);  color:#059669; }
.s-pill.amber  { background:rgba(245,158,11,.1);  color:#d97706; }
.s-pill.red    { background:rgba(239,68,68,.1);   color:#dc2626; }
.s-pill.blue   { background:rgba(79,124,255,.1);  color:#4f7cff; }
.s-pill.purple { background:rgba(139,92,246,.1);  color:#7c3aed; }

/* ── Profit row ── */
.profit-row { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:4px; }
.profit-box { flex:1; min-width:140px; background:var(--d-surface); border:1px solid var(--d-border); border-radius:12px; padding:14px 16px; box-shadow:var(--d-shadow); }
.profit-box .pb-label { font-size:.67rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--d-faint); margin-bottom:6px; }
.profit-box .pb-value { font-size:1.4rem; font-weight:800; font-variant-numeric:tabular-nums; letter-spacing:-.5px; }
.profit-box.green  .pb-value { color:#10b981; }
.profit-box.red    .pb-value { color:#ef4444; }
.profit-box.blue   .pb-value { color:#4f7cff; }
[data-z-theme="dark"] .profit-box { background:var(--z-surface,#1c1b19); border-color:var(--z-border,#393836); }
[data-z-theme="dark"] .profit-box .pb-label { color:var(--z-text-faint,#5a5957); }

/* ── Responsive ── */
@media (max-width:575px) {
    .kpi-grid { grid-template-columns:repeat(2,1fr); gap:9px; }
    .dash-header { flex-direction:column; align-items:flex-start; }
    .kpi-value { font-size:1.4rem; }
    .profit-row { flex-direction:column; }
}
</style>
@endsection

@section('content')
<div class="dash-wrap">

{{-- ══ HEADER ══ --}}
<div class="dash-header">
    <div>
        <h1 class="dash-title">
            <i class="fas fa-tachometer-alt" style="color:var(--d-primary);margin-left:6px;margin-right:6px;font-size:1rem;"></i>
            {{ trans('panel.dashboard') ?? 'لوحة التحكم' }}
        </h1>
        <div class="dash-subtitle">
            {{ trans('panel.welcome_back') ?? 'مرحباً بك،' }}
            <strong style="color:var(--d-text);">{{ Auth::user()->name }}</strong>
        </div>
    </div>
    <div class="dash-date-pill">
        <i class="fas fa-calendar-alt"></i>
        {{ now()->translatedFormat('l، d M Y') }}
    </div>
</div>

@if(session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

@if($isRestaurant && $subEndDay)
<div class="dash-sub-banner">
    <i class="fas fa-clock"></i>
    <span>{{ trans('cruds.end_subscription') }}: <strong>{{ $subEndDay }}</strong></span>
</div>
@endif

@can('home')

{{-- ══════════════════════════════════════════════════════
     1. ORDERS OVERVIEW
══════════════════════════════════════════════════════ --}}
<div class="dash-section-label" style="margin-top:0">
    <span class="label-icon"><i class="fas fa-shopping-bag"></i></span>
    {{ trans('panel.orders') ?? 'الطلبات' }}
</div>
<div class="kpi-grid">
    <div class="kpi-card kpi-cyan">
        <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
        <div class="kpi-label">{{ trans('panel.total_orders') ?? 'إجمالي الطلبات' }}</div>
        <div class="kpi-value">{{ number_format($totalOrders) }}</div>
        <div class="kpi-sub"><i class="fas fa-infinity"></i> {{ trans('panel.all_time') ?? 'كل الوقت' }}</div>
    </div>
    <div class="kpi-card kpi-teal">
        <div class="kpi-icon"><i class="fas fa-calendar-day"></i></div>
        <div class="kpi-label">{{ trans('panel.today') ?? 'اليوم' }}</div>
        <div class="kpi-value">{{ number_format($ordersToday) }}</div>
        <div class="kpi-sub"><i class="fas fa-clock"></i> {{ now()->format('d/m') }}</div>
    </div>
    <div class="kpi-card kpi-blue">
        <div class="kpi-icon"><i class="fas fa-calendar-week"></i></div>
        <div class="kpi-label">{{ trans('panel.this_week') ?? 'هذا الأسبوع' }}</div>
        <div class="kpi-value">{{ number_format($ordersWeek) }}</div>
        <div class="kpi-sub"><i class="fas fa-sync-alt"></i></div>
    </div>
    <div class="kpi-card kpi-indigo">
        <div class="kpi-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="kpi-label">{{ trans('panel.this_month') ?? 'هذا الشهر' }}</div>
        <div class="kpi-value">{{ number_format($ordersMonth) }}</div>
        <div class="kpi-sub"><i class="fas fa-redo"></i></div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
        <div class="kpi-label">{{ trans('panel.completed') ?? 'مكتملة' }}</div>
        <div class="kpi-value">{{ number_format($ordersCompleted) }}</div>
        <div class="kpi-sub up"><i class="fas fa-check"></i></div>
    </div>
    <div class="kpi-card kpi-amber">
        <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
        <div class="kpi-label">{{ trans('panel.pending') ?? 'قيد الانتظار' }}</div>
        <div class="kpi-value">{{ number_format($ordersPending) }}</div>
        <div class="kpi-sub"><i class="fas fa-pause-circle"></i></div>
    </div>
    <div class="kpi-card kpi-purple">
        <div class="kpi-icon"><i class="fas fa-bookmark"></i></div>
        <div class="kpi-label">{{ trans('panel.reserved') ?? 'محجوزة' }}</div>
        <div class="kpi-value">{{ number_format($ordersReserved) }}</div>
        <div class="kpi-sub"><i class="fas fa-clock"></i></div>
    </div>
    <div class="kpi-card kpi-red">
        <div class="kpi-icon"><i class="fas fa-times-circle"></i></div>
        <div class="kpi-label">{{ trans('panel.cancelled') ?? 'ملغاة' }}</div>
        <div class="kpi-value">{{ number_format($ordersCancelled) }}</div>
        <div class="kpi-sub down"><i class="fas fa-ban"></i></div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     2. REVENUE
══════════════════════════════════════════════════════ --}}
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-dollar-sign"></i></span>
    {{ trans('panel.revenue') ?? 'الإيرادات' }}
</div>
<div class="kpi-grid">
    <div class="kpi-card kpi-green">
        <div class="kpi-icon"><i class="fas fa-coins"></i></div>
        <div class="kpi-label">{{ trans('panel.total_revenue') ?? 'إجمالي الإيرادات' }}</div>
        <div class="kpi-value" style="font-size:1.3rem;">{{ number_format($revenueTotal, 2) }}</div>
        <div class="kpi-sub"><i class="fas fa-infinity"></i></div>
    </div>
    <div class="kpi-card kpi-teal">
        <div class="kpi-icon"><i class="fas fa-sun"></i></div>
        <div class="kpi-label">{{ trans('panel.today') ?? 'اليوم' }}</div>
        <div class="kpi-value" style="font-size:1.3rem;">{{ number_format($revenueToday, 2) }}</div>
        <div class="kpi-sub">{{ now()->format('d/m') }}</div>
    </div>
    <div class="kpi-card kpi-cyan">
        <div class="kpi-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="kpi-label">{{ trans('panel.this_month') ?? 'هذا الشهر' }}</div>
        <div class="kpi-value" style="font-size:1.3rem;">{{ number_format($revenueMonth, 2) }}</div>
        <div class="kpi-sub">{{ now()->format('m/Y') }}</div>
    </div>
    <div class="kpi-card kpi-blue">
        <div class="kpi-icon"><i class="fas fa-chart-line"></i></div>
        <div class="kpi-label">{{ trans('panel.avg_order') ?? 'متوسط الطلب' }}</div>
        <div class="kpi-value" style="font-size:1.3rem;">{{ number_format($avgOrderValue, 2) }}</div>
        <div class="kpi-sub"><i class="fas fa-divide"></i></div>
    </div>
</div>

{{-- ══ CHARTS ROW ══ --}}
<div class="row">
    <div class="col-md-7">
        <div class="chart-card">
            <div class="chart-card-head">
                <h6 class="chart-card-title">
                    <span class="chart-card-icon"><i class="fas fa-chart-bar"></i></span>
                    {{ trans('panel.orders_last_14_days') ?? 'الطلبات - آخر 14 يوم' }}
                </h6>
            </div>
            <canvas id="ordersLineChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="chart-card">
            <div class="chart-card-head">
                <h6 class="chart-card-title">
                    <span class="chart-card-icon"><i class="fas fa-chart-pie"></i></span>
                    {{ trans('panel.orders_status') ?? 'الطلبات حسب الحالة' }}
                </h6>
            </div>
            <canvas id="ordersStatusChart" height="160"></canvas>
        </div>
    </div>
</div>

{{-- ══ ORDERS TIMELINE QUICK STATS ══ --}}
<div class="row" style="margin-bottom:6px;">
    @foreach([
        ['label' => '7 '.( trans('panel.days') ?? 'أيام'), 'val' => $ordersLast7],
        ['label' => '14 '.( trans('panel.days') ?? 'يوم'), 'val' => $ordersLast14],
        ['label' => '30 '.( trans('panel.days') ?? 'يوم'), 'val' => $ordersLast30],
        ['label' => ( trans('panel.this_year') ?? 'هذا العام'), 'val' => $ordersYear],
    ] as $qs)
    <div class="col-6 col-md-3">
        <div class="t-card" style="border-radius:12px;">
            <div style="padding:14px 16px;text-align:center;">
                <div style="font-size:.67rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;color:var(--d-faint);margin-bottom:6px;">{{ $qs['label'] }}</div>
                <div style="font-size:1.5rem;font-weight:800;color:var(--d-text);font-variant-numeric:tabular-nums;">{{ number_format($qs['val']) }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ══ LATEST ORDERS TABLE ══ --}}
<div class="t-card">
    <div class="t-card-head">
        <i class="fas fa-receipt"></i>
        <h6>{{ trans('panel.latest_orders') ?? 'آخر الطلبات' }}</h6>
    </div>
    @if($latestOrders->count())
    <div class="table-responsive">
        <table class="table">
            <thead><tr>
                <th>#</th>
                <th>{{ trans('panel.user') ?? 'المستخدم' }}</th>
                @if($isAdmin)<th>{{ trans('panel.restaurant') ?? 'المطعم' }}</th>@endif
                <th>{{ trans('panel.price') ?? 'السعر' }}</th>
                <th>{{ trans('panel.status') ?? 'الحالة' }}</th>
                <th>{{ trans('panel.date') ?? 'التاريخ' }}</th>
            </tr></thead>
            <tbody>
            @foreach($latestOrders as $o)
            <tr>
                <td>{{ $o->id }}</td>
                <td>{{ optional($o->user)->name ?? '—' }}</td>
                @if($isAdmin)<td>{{ optional($o->restaurants)->name_ar ?? optional($o->restaurants)->name_en ?? '—' }}</td>@endif
                <td style="font-weight:700;color:var(--d-text);">{{ number_format($o->final_price, 2) }}</td>
                <td>
                    @php $sid = $o->status_id; @endphp
                    <span class="s-pill {{ $sid==2?'green':($sid==1?'amber':($sid==4?'red':'purple')) }}">
                        {{ optional($o->status)->name_ar ?? $sid }}
                    </span>
                </td>
                <td>{{ $o->created_at ? $o->created_at->format('d/m/Y H:i') : '—' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="t-empty"><i class="fas fa-box-open"></i> {{ trans('panel.no_data') ?? 'لا يوجد بيانات' }}</div>
    @endif
</div>

{{-- ══════════════════════════════════════════════════════
     3. USERS & RESTAURANTS  (admin only)
══════════════════════════════════════════════════════ --}}
@if($isAdmin)
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-users"></i></span>
    {{ trans('panel.users_restaurants') ?? 'المستخدمون والمطاعم' }}
</div>
<div class="kpi-grid">
    <div class="kpi-card kpi-blue">
        <div class="kpi-icon"><i class="fas fa-users"></i></div>
        <div class="kpi-label">{{ trans('panel.total_users') ?? 'إجمالي المستخدمين' }}</div>
        <div class="kpi-value">{{ number_format($totalUsers) }}</div>
    </div>
    <div class="kpi-card kpi-teal">
        <div class="kpi-icon"><i class="fas fa-user-plus"></i></div>
        <div class="kpi-label">{{ trans('panel.new_today') ?? 'جديد اليوم' }}</div>
        <div class="kpi-value">{{ number_format($newUsersToday) }}</div>
    </div>
    <div class="kpi-card kpi-indigo">
        <div class="kpi-icon"><i class="fas fa-user-clock"></i></div>
        <div class="kpi-label">{{ trans('panel.new_this_week') ?? 'جديد هذا الأسبوع' }}</div>
        <div class="kpi-value">{{ number_format($newUsersWeek) }}</div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-icon"><i class="fas fa-store"></i></div>
        <div class="kpi-label">{{ trans('panel.total_restaurants') ?? 'إجمالي المطاعم' }}</div>
        <div class="kpi-value">{{ number_format($totalRestaurants) }}</div>
    </div>
    <div class="kpi-card kpi-lime">
        <div class="kpi-icon"><i class="fas fa-check-double"></i></div>
        <div class="kpi-label">{{ trans('panel.active_restaurants') ?? 'مطاعم نشطة' }}</div>
        <div class="kpi-value">{{ number_format($activeRestaurants) }}</div>
    </div>
    <div class="kpi-card kpi-cyan">
        <div class="kpi-icon"><i class="fas fa-utensils"></i></div>
        <div class="kpi-label">{{ trans('panel.new_rest_week') ?? 'مطاعم جديدة هذا الأسبوع' }}</div>
        <div class="kpi-value">{{ number_format($newRestWeek) }}</div>
    </div>
</div>

{{-- Top Restaurants by Orders --}}
@if($topRestaurantsByOrders->count())
<div class="t-card">
    <div class="t-card-head">
        <i class="fas fa-trophy" style="color:#f59e0b"></i>
        <h6>{{ trans('panel.top_restaurants_orders') ?? 'أعلى المطاعم طلباً' }}</h6>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>{{ trans('panel.restaurant') ?? 'المطعم' }}</th><th>{{ trans('panel.orders') ?? 'الطلبات' }}</th></tr></thead>
            <tbody>
            @foreach($topRestaurantsByOrders as $i => $r)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ optional($r->restaurants)->name_ar ?? optional($r->restaurants)->name_en ?? '—' }}</td>
                <td><strong style="color:var(--d-text);">{{ number_format($r->cnt) }}</strong></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endif

{{-- ══════════════════════════════════════════════════════
     4. RESTAURANT-SPECIFIC STATS
══════════════════════════════════════════════════════ --}}
@if($isRestaurant)
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-store"></i></span>
    {{ trans('panel.my_restaurant') ?? 'مطعمي' }}
</div>
<div class="kpi-grid">
    <div class="kpi-card kpi-cyan">
        <div class="kpi-icon"><i class="fas fa-eye"></i></div>
        <div class="kpi-label">{{ trans('panel.visits') ?? 'الزيارات' }}</div>
        <div class="kpi-value">{{ number_format($restVisits) }}</div>
    </div>
    <div class="kpi-card kpi-rose">
        <div class="kpi-icon"><i class="fas fa-heart"></i></div>
        <div class="kpi-label">{{ trans('panel.favorites') ?? 'المفضلة' }}</div>
        <div class="kpi-value">{{ number_format($restFavorites) }}</div>
    </div>
    <div class="kpi-card kpi-amber">
        <div class="kpi-icon"><i class="fas fa-shopping-cart"></i></div>
        <div class="kpi-label">{{ trans('panel.active_carts') ?? 'سلات نشطة' }}</div>
        <div class="kpi-value">{{ number_format($restCartItems) }}</div>
    </div>
    <div class="kpi-card kpi-purple">
        <div class="kpi-icon"><i class="fas fa-box-open"></i></div>
        <div class="kpi-label">{{ trans('panel.items') ?? 'الأصناف' }}</div>
        <div class="kpi-value">{{ number_format($totalItems) }}</div>
        <div class="kpi-sub"><span style="color:#10b981;">{{ $activeItems }}</span> {{ trans('panel.active') ?? 'نشط' }}</div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     5. RATINGS
══════════════════════════════════════════════════════ --}}
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-star"></i></span>
    {{ trans('panel.ratings') ?? 'التقييمات' }}
</div>
<div class="row">
    <div class="col-md-4">
        <div class="kpi-grid" style="grid-template-columns:1fr 1fr;">
            <div class="kpi-card kpi-amber" style="grid-column:span 2;">
                <div class="kpi-icon"><i class="fas fa-star"></i></div>
                <div class="kpi-label">{{ trans('panel.avg_rating') ?? 'متوسط التقييم' }}</div>
                <div class="kpi-value">{{ number_format($avgRating, 1) }}</div>
                <div class="kpi-stars">
                    @for($s=1;$s<=5;$s++)
                        <i class="fas fa-star" style="color:{{ $s<=round($avgRating)?'#fbbf24':'var(--d-border)' }}"></i>
                    @endfor
                </div>
            </div>
            <div class="kpi-card kpi-blue">
                <div class="kpi-label">{{ trans('panel.total') ?? 'الإجمالي' }}</div>
                <div class="kpi-value">{{ number_format($totalRatings) }}</div>
            </div>
            <div class="kpi-card kpi-rose">
                <div class="kpi-label">{{ trans('panel.below_3') ?? 'أقل من 3' }}</div>
                <div class="kpi-value">{{ number_format($ratingBelow3) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="chart-card">
            <div class="chart-card-head">
                <h6 class="chart-card-title">
                    <span class="chart-card-icon"><i class="fas fa-star-half-alt"></i></span>
                    {{ trans('panel.rating_distribution') ?? 'توزيع التقييمات' }}
                </h6>
            </div>
            @php $maxR = max($rating5,$rating4,$rating3,$ratingBelow3,1); @endphp
            @foreach([
                ['stars'=>5,'count'=>$rating5,'color'=>'#10b981'],
                ['stars'=>4,'count'=>$rating4,'color'=>'#34d399'],
                ['stars'=>3,'count'=>$rating3,'color'=>'#fbbf24'],
                ['stars'=>'<3','count'=>$ratingBelow3,'color'=>'#ef4444'],
            ] as $rb)
            <div class="rating-bar-row">
                <div class="rating-bar-label">{{ $rb['stars'] }} <i class="fas fa-star" style="color:#fbbf24;font-size:.6rem;"></i></div>
                <div class="rating-bar-track"><div class="rating-bar-fill" style="width:{{ $maxR>0?round($rb['count']/$maxR*100):0 }}%;background:{{ $rb['color'] }};"></div></div>
                <div class="rating-bar-count">{{ $rb['count'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-4">
        @if($isAdmin && $topRatedRestaurants->count())
        <div class="t-card">
            <div class="t-card-head"><i class="fas fa-award" style="color:#f59e0b"></i><h6>{{ trans('panel.top_rated') ?? 'الأعلى تقييماً' }}</h6></div>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>{{ trans('panel.restaurant') ?? 'المطعم' }}</th><th>{{ trans('panel.avg') ?? 'المتوسط' }}</th><th>{{ trans('panel.count') ?? 'عدد' }}</th></tr></thead>
                    <tbody>
                    @foreach($topRatedRestaurants as $rr)
                    <tr>
                        <td>{{ optional($rr->restaurant)->name_ar ?? '—' }}</td>
                        <td><strong style="color:#fbbf24;"><i class="fas fa-star"></i> {{ number_format($rr->avg_rate,1) }}</strong></td>
                        <td>{{ $rr->cnt }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @elseif($isRestaurant)
        <div class="chart-card" style="text-align:center;padding:28px 16px;">
            <div style="font-size:2.5rem;font-weight:800;color:#fbbf24;margin-bottom:4px;">{{ number_format($avgRating,1) }}</div>
            <div style="font-size:.8rem;color:var(--d-muted);margin-bottom:10px;">{{ trans('panel.your_avg_rating') ?? 'تقييمك العام' }}</div>
            <div style="display:flex;justify-content:center;gap:4px;">
                @for($s=1;$s<=5;$s++)
                    <i class="fas fa-star" style="color:{{ $s<=round($avgRating)?'#fbbf24':'var(--d-border)' }};font-size:1.2rem;"></i>
                @endfor
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     6. ITEMS, COUPONS, FAVORITES, ADS  (admin or rest)
══════════════════════════════════════════════════════ --}}
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-th"></i></span>
    {{ trans('panel.catalog_marketing') ?? 'الكتالوج والتسويق' }}
</div>
<div class="kpi-grid">
    @if(!$isRestaurant)
    <div class="kpi-card kpi-purple">
        <div class="kpi-icon"><i class="fas fa-box-open"></i></div>
        <div class="kpi-label">{{ trans('panel.total_items') ?? 'إجمالي الأصناف' }}</div>
        <div class="kpi-value">{{ number_format($totalItems) }}</div>
        <div class="kpi-sub"><span style="color:#10b981;">{{ $activeItems }}</span>&nbsp;{{ trans('panel.active') ?? 'نشط' }}</div>
    </div>
    @endif
    <div class="kpi-card kpi-orange">
        <div class="kpi-icon"><i class="fas fa-ticket-alt"></i></div>
        <div class="kpi-label">{{ trans('panel.coupons') ?? 'الكوبونات' }}</div>
        <div class="kpi-value">{{ number_format($totalCoupons) }}</div>
        <div class="kpi-sub"><span style="color:#10b981;">{{ $activeCoupons }}</span>&nbsp;{{ trans('panel.active') ?? 'نشط' }}</div>
    </div>
    <div class="kpi-card kpi-rose">
        <div class="kpi-icon"><i class="fas fa-heart"></i></div>
        <div class="kpi-label">{{ trans('panel.favorites') ?? 'المفضلة' }}</div>
        <div class="kpi-value">{{ number_format($totalFavorites) }}</div>
    </div>
    @if($isAdmin)
    <div class="kpi-card kpi-pink">
        <div class="kpi-icon"><i class="fas fa-bullhorn"></i></div>
        <div class="kpi-label">{{ trans('panel.ads') ?? 'الإعلانات' }}</div>
        <div class="kpi-value">{{ number_format($totalAds) }}</div>
        <div class="kpi-sub"><span style="color:#10b981;">{{ $activeAds }}</span>&nbsp;{{ trans('panel.active') ?? 'نشط' }}</div>
    </div>
    @endif
</div>

{{-- ══════════════════════════════════════════════════════
     7. INCOME / EXPENSE / NET PROFIT  (admin)
══════════════════════════════════════════════════════ --}}
@if($isAdmin)
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-balance-scale"></i></span>
    {{ trans('panel.finance') ?? 'المالية' }}
</div>
<div class="profit-row">
    <div class="profit-box green">
        <div class="pb-label">{{ trans('panel.total_income') ?? 'إجمالي الإيرادات' }}</div>
        <div class="pb-value">{{ number_format($totalIncome, 2) }}</div>
        <div style="font-size:.72rem;color:var(--d-faint);margin-top:4px;">{{ trans('panel.this_month') ?? 'هذا الشهر' }}: {{ number_format($incomeMonth, 2) }}</div>
    </div>
    <div class="profit-box red">
        <div class="pb-label">{{ trans('panel.total_expense') ?? 'إجمالي المصروفات' }}</div>
        <div class="pb-value">{{ number_format($totalExpense, 2) }}</div>
        <div style="font-size:.72rem;color:var(--d-faint);margin-top:4px;">{{ trans('panel.this_month') ?? 'هذا الشهر' }}: {{ number_format($expenseMonth, 2) }}</div>
    </div>
    <div class="profit-box {{ $netProfit>=0?'green':'red' }}">
        <div class="pb-label">{{ trans('panel.net_profit') ?? 'صافي الربح' }}</div>
        <div class="pb-value">{{ number_format($netProfit, 2) }}</div>
        <div style="font-size:.72rem;color:var(--d-faint);margin-top:4px;">{{ trans('panel.this_month') ?? 'هذا الشهر' }}: {{ number_format($netProfitMonth, 2) }}</div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     8. SUBSCRIPTIONS (admin)
══════════════════════════════════════════════════════ --}}
@if($isAdmin)
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-id-card"></i></span>
    {{ trans('panel.subscriptions') ?? 'الاشتراكات' }}
</div>
<div class="kpi-grid">
    <div class="kpi-card kpi-green">
        <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
        <div class="kpi-label">{{ trans('panel.active_subs') ?? 'اشتراكات نشطة' }}</div>
        <div class="kpi-value">{{ number_format($activeSubs) }}</div>
    </div>
    <div class="kpi-card kpi-red">
        <div class="kpi-icon"><i class="fas fa-times-circle"></i></div>
        <div class="kpi-label">{{ trans('panel.expired_subs') ?? 'اشتراكات منتهية' }}</div>
        <div class="kpi-value">{{ number_format($expiredSubs) }}</div>
    </div>
    <div class="kpi-card kpi-teal">
        <div class="kpi-icon"><i class="fas fa-calendar-plus"></i></div>
        <div class="kpi-label">{{ trans('panel.subs_this_month') ?? 'هذا الشهر' }}</div>
        <div class="kpi-value">{{ number_format($subsThisMonth) }}</div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════
     9. SUPPORT TICKETS (admin)
══════════════════════════════════════════════════════ --}}
@if($isAdmin)
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-headset"></i></span>
    {{ trans('panel.support') ?? 'الدعم الفني' }}
</div>
<div class="kpi-grid">
    <div class="kpi-card kpi-blue">
        <div class="kpi-icon"><i class="fas fa-ticket-alt"></i></div>
        <div class="kpi-label">{{ trans('panel.total_tickets') ?? 'إجمالي التذاكر' }}</div>
        <div class="kpi-value">{{ number_format($totalTickets) }}</div>
    </div>
    <div class="kpi-card kpi-amber">
        <div class="kpi-icon"><i class="fas fa-envelope-open"></i></div>
        <div class="kpi-label">{{ trans('panel.open_tickets') ?? 'مفتوحة' }}</div>
        <div class="kpi-value">{{ number_format($openTickets) }}</div>
    </div>
    <div class="kpi-card kpi-green">
        <div class="kpi-icon"><i class="fas fa-envelope"></i></div>
        <div class="kpi-label">{{ trans('panel.closed_tickets') ?? 'مغلقة' }}</div>
        <div class="kpi-value">{{ number_format($closedTickets) }}</div>
    </div>
</div>
@if($latestTickets->count())
<div class="t-card">
    <div class="t-card-head"><i class="fas fa-ticket-alt"></i><h6>{{ trans('panel.latest_tickets') ?? 'آخر التذاكر' }}</h6></div>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>#</th><th>{{ trans('panel.user') ?? 'المستخدم' }}</th><th>{{ trans('panel.title') ?? 'العنوان' }}</th><th>{{ trans('panel.status') ?? 'الحالة' }}</th><th>{{ trans('panel.date') ?? 'التاريخ' }}</th></tr></thead>
            <tbody>
            @foreach($latestTickets as $tk)
            <tr>
                <td>{{ $tk->id }}</td>
                <td>{{ optional($tk->user)->name ?? '—' }}</td>
                <td>{{ $tk->title }}</td>
                <td><span class="s-pill {{ $tk->ticket_status_id==1?'amber':'green' }}">{{ optional($tk->status)->name_ar ?? ($tk->ticket_status_id==1?'مفتوح':'مغلق') }}</span></td>
                <td>{{ $tk->created_at ? $tk->created_at->format('d/m/Y') : '—' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endif

{{-- ══════════════════════════════════════════════════════
     10. MISC: CONTACTS, REPORTS, QA, POINTS (admin)
══════════════════════════════════════════════════════ --}}
@if($isAdmin)
<div class="dash-section-label">
    <span class="label-icon"><i class="fas fa-info-circle"></i></span>
    {{ trans('panel.other_stats') ?? 'إحصائيات أخرى' }}
</div>
<div class="kpi-grid">
    <div class="kpi-card kpi-teal">
        <div class="kpi-icon"><i class="fas fa-envelope"></i></div>
        <div class="kpi-label">{{ trans('panel.contacts') ?? 'رسائل التواصل' }}</div>
        <div class="kpi-value">{{ number_format($totalContacts) }}</div>
    </div>
    <div class="kpi-card kpi-indigo">
        <div class="kpi-icon"><i class="fas fa-handshake"></i></div>
        <div class="kpi-label">{{ trans('panel.partners_requests') ?? 'طلبات الشراكة' }}</div>
        <div class="kpi-value">{{ number_format($totalPartners) }}</div>
    </div>
    <div class="kpi-card kpi-red">
        <div class="kpi-icon"><i class="fas fa-flag"></i></div>
        <div class="kpi-label">{{ trans('panel.reports') ?? 'البلاغات' }}</div>
        <div class="kpi-value">{{ number_format($totalReports) }}</div>
        <div class="kpi-sub down">{{ $pendingReports }} {{ trans('panel.pending') ?? 'غير مراجعة' }}</div>
    </div>
    <div class="kpi-card kpi-amber">
        <div class="kpi-icon"><i class="fas fa-comments"></i></div>
        <div class="kpi-label">{{ trans('panel.qa_topics') ?? 'تذاكر Q&A' }}</div>
        <div class="kpi-value">{{ number_format($totalQa) }}</div>
        <div class="kpi-sub">{{ $openQa }} {{ trans('panel.open') ?? 'مفتوح' }}</div>
    </div>
    <div class="kpi-card kpi-lime">
        <div class="kpi-icon"><i class="fas fa-gem"></i></div>
        <div class="kpi-label">{{ trans('panel.total_points') ?? 'إجمالي النقاط' }}</div>
        <div class="kpi-value">{{ number_format($totalPoints) }}</div>
    </div>
</div>
@endif

@endcan
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
(function(){
    const isDark = document.documentElement.getAttribute('data-z-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255,255,255,.06)' : 'rgba(0,0,0,.05)';
    const textColor = isDark ? '#797876' : '#94a3b8';
    const tooltip = {
        backgroundColor: isDark?'#1c1b19':'#fff',
        titleColor: isDark?'#cdccca':'#1e293b',
        bodyColor:  isDark?'#797876':'#64748b',
        borderColor: isDark?'#393836':'#e2e8f0',
        borderWidth: 1,
        padding: 10,
        cornerRadius: 8
    };

    // Orders line chart
    const labels = {!! json_encode($ordersChartLabels) !!};
    const ordersData = {!! json_encode($ordersChartData) !!};
    const revData    = {!! json_encode($revenueChartData) !!};

    new Chart(document.getElementById('ordersLineChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '{{ trans("panel.orders") ?? "الطلبات" }}',
                data: ordersData,
                backgroundColor: 'rgba(6,182,212,.7)',
                borderRadius: 5,
                borderSkipped: false,
                yAxisID: 'y'
            }]
        },
        options: {
            responsive:true,
            plugins: { legend:{display:false}, tooltip },
            scales: {
                x:{ grid:{color:gridColor}, ticks:{color:textColor} },
                y:{ grid:{color:gridColor}, ticks:{color:textColor}, beginAtZero:true }
            }
        }
    });

    // Orders status donut chart
    new Chart(document.getElementById('ordersStatusChart'), {
        type: 'doughnut',
        data: {
            labels: [
                '{{ trans("panel.completed") ?? "مكتملة" }}',
                '{{ trans("panel.pending") ?? "قيد الانتظار" }}',
                '{{ trans("panel.reserved") ?? "محجوزة" }}',
                '{{ trans("panel.cancelled") ?? "ملغاة" }}'
            ],
            datasets: [{
                data: [{{ $ordersCompleted }},{{ $ordersPending }},{{ $ordersReserved }},{{ $ordersCancelled }}],
                backgroundColor: ['#10b981','#f59e0b','#8b5cf6','#ef4444'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive:true,
            cutout:'70%',
            plugins: {
                legend: { position:'bottom', labels:{ color:textColor, padding:14, font:{size:11} } },
                tooltip
            }
        }
    });
})();
</script>
@endsection
