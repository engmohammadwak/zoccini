@extends('layouts.admin')

@section('styles')
<style>
/* =============================================
   DASHBOARD v3 — Full Redesign
   Supports: dark mode (data-z-theme="dark"), RTL
============================================= */

/* ── Variables bridge ── */
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
.dash-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
    margin-bottom: 28px;
}
.dash-title {
    font-size: 1.3rem; font-weight: 800;
    color: var(--d-text); margin: 0; line-height: 1.2;
}
.dash-subtitle {
    font-size: 0.8rem; color: var(--d-muted); margin-top: 4px;
}
.dash-date-pill {
    display: inline-flex; align-items: center; gap: 7px;
    background: var(--d-surface); border: 1px solid var(--d-border);
    border-radius: 10px; padding: 7px 14px;
    font-size: 0.77rem; font-weight: 600; color: var(--d-muted);
    box-shadow: var(--d-shadow);
}
.dash-date-pill i { color: var(--d-primary); }

/* ── Subscription banner ── */
.dash-sub-banner {
    display: flex; align-items: center; gap: 10px;
    background: #fffbeb; border: 1px solid #fde68a;
    border-radius: 12px; padding: 11px 16px;
    margin-bottom: 24px; font-size: 0.82rem; color: #92400e; font-weight: 500;
}
[data-z-theme="dark"] .dash-sub-banner {
    background: rgba(245,158,11,.08); border-color: rgba(245,158,11,.2); color: #fbbf24;
}
.dash-sub-banner i { color: #f59e0b; font-size: 1rem; flex-shrink: 0; }

/* ── Section Label ── */
.dash-section-label {
    display: flex; align-items: center; gap: 8px;
    font-size: 0.7rem; font-weight: 800; letter-spacing: 1.1px;
    text-transform: uppercase; color: var(--d-faint);
    margin-bottom: 14px;
}
.dash-section-label::after {
    content: ''; flex: 1; height: 1px; background: var(--d-border);
}
.dash-section-label .label-icon {
    width: 22px; height: 22px; border-radius: 6px;
    background: rgba(79,124,255,.1); color: #4f7cff;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.62rem;
}

/* ── KPI Grid ── */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
    gap: 14px; margin-bottom: 32px;
}
.kpi-card {
    background: var(--d-surface);
    border: 1px solid var(--d-border);
    border-radius: var(--d-radius);
    padding: 18px 18px 16px;
    box-shadow: var(--d-shadow);
    position: relative; overflow: hidden;
    transition: transform .18s ease, box-shadow .18s ease;
    cursor: default;
}
.kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--d-shadow-md);
}
/* top accent stripe */
.kpi-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 3px;
    background: var(--kpi-accent, #4f7cff);
    border-radius: var(--d-radius) var(--d-radius) 0 0;
}
/* bg blob */
.kpi-card::after {
    content: '';
    position: absolute; bottom: -20px; right: -10px;
    width: 70px; height: 70px; border-radius: 50%;
    background: var(--kpi-accent, #4f7cff);
    opacity: .04; pointer-events: none;
}
.kpi-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: var(--kpi-bg, rgba(79,124,255,.1));
    color: var(--kpi-accent, #4f7cff);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.88rem; margin-bottom: 13px;
}
.kpi-label {
    font-size: 0.68rem; font-weight: 700; letter-spacing: .5px;
    text-transform: uppercase; color: var(--d-faint);
    margin-bottom: 5px; line-height: 1.4;
}
.kpi-value {
    font-size: 1.8rem; font-weight: 800; color: var(--d-text);
    line-height: 1; font-variant-numeric: tabular-nums;
    letter-spacing: -1px;
}
.kpi-trend {
    margin-top: 8px; font-size: 0.7rem; color: var(--d-faint);
    display: flex; align-items: center; gap: 4px;
}
.kpi-stars { display: flex; gap: 2px; margin-top: 7px; }
.kpi-stars i { font-size: 0.65rem; }

/* KPI themes */
.kpi-blue   { --kpi-accent:#4f7cff; --kpi-bg:rgba(79,124,255,.09); }
.kpi-green  { --kpi-accent:#10b981; --kpi-bg:rgba(16,185,129,.09); }
.kpi-amber  { --kpi-accent:#f59e0b; --kpi-bg:rgba(245,158,11,.09); }
.kpi-red    { --kpi-accent:#ef4444; --kpi-bg:rgba(239,68,68,.09);  }
.kpi-cyan   { --kpi-accent:#06b6d4; --kpi-bg:rgba(6,182,212,.09);  }
.kpi-purple { --kpi-accent:#8b5cf6; --kpi-bg:rgba(139,92,246,.09); }
.kpi-rose   { --kpi-accent:#f43f5e; --kpi-bg:rgba(244,63,94,.09);  }
.kpi-teal   { --kpi-accent:#14b8a6; --kpi-bg:rgba(20,184,166,.09); }

/* dark mode overrides */
[data-z-theme="dark"] .kpi-card {
    background: var(--z-surface, #1c1b19);
    border-color: var(--z-border, #393836);
}
[data-z-theme="dark"] .kpi-value { color: var(--z-text, #cdccca); }
[data-z-theme="dark"] .kpi-label { color: var(--z-text-faint, #5a5957); }

/* ── Quick stats row (orders timeline) ── */
.qstat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 10px; margin-bottom: 32px;
}
.qstat-card {
    background: var(--d-surface);
    border: 1px solid var(--d-border);
    border-radius: 11px;
    padding: 14px 14px 12px;
    box-shadow: var(--d-shadow);
    text-align: center;
    transition: box-shadow .18s;
}
.qstat-card:hover { box-shadow: var(--d-shadow-md); }
.qstat-label {
    font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .5px; color: var(--d-faint); margin-bottom: 6px;
}
.qstat-value {
    font-size: 1.45rem; font-weight: 800; color: var(--d-text);
    font-variant-numeric: tabular-nums; letter-spacing: -.5px;
}
.qstat-sub { font-size: 0.65rem; color: var(--d-faint); margin-top: 3px; }
[data-z-theme="dark"] .qstat-card { background: var(--z-surface,#1c1b19); border-color: var(--z-border,#393836); }
[data-z-theme="dark"] .qstat-value { color: var(--z-text,#cdccca); }

/* ── Chart card ── */
.chart-card {
    background: var(--d-surface);
    border: 1px solid var(--d-border);
    border-radius: var(--d-radius);
    padding: 20px 18px 14px;
    box-shadow: var(--d-shadow);
    margin-bottom: 20px;
    height: 100%;
}
.chart-card-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 16px; padding-bottom: 12px;
    border-bottom: 1px solid var(--d-border);
}
.chart-card-title {
    font-size: 0.82rem; font-weight: 700; color: var(--d-text);
    display: flex; align-items: center; gap: 8px; margin: 0;
}
.chart-card-icon {
    width: 26px; height: 26px; border-radius: 7px;
    background: rgba(79,124,255,.1); color: #4f7cff;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem;
}
[data-z-theme="dark"] .chart-card { background: var(--z-surface,#1c1b19); border-color: var(--z-border,#393836); }
[data-z-theme="dark"] .chart-card-head { border-color: var(--z-border,#393836); }
[data-z-theme="dark"] .chart-card-title { color: var(--z-text,#cdccca); }

/* ── Table card ── */
.t-card {
    background: var(--d-surface);
    border: 1px solid var(--d-border);
    border-radius: var(--d-radius);
    overflow: hidden; box-shadow: var(--d-shadow);
    margin-bottom: 20px;
}
.t-card-head {
    display: flex; align-items: center; gap: 8px;
    padding: 14px 18px;
    border-bottom: 1px solid var(--d-border);
    background: var(--d-surface2);
}
.t-card-head h6 {
    font-size: 0.82rem; font-weight: 700; color: var(--d-text); margin: 0;
}
.t-card-head i { color: #4f7cff; }
.t-card .table { margin: 0; font-size: 0.79rem; }
.t-card .table thead th {
    background: var(--d-surface2); color: var(--d-faint);
    font-size: 0.68rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .5px;
    padding: 9px 16px;
    border-bottom: 1px solid var(--d-border); border-top: none;
}
.t-card .table tbody td {
    padding: 10px 16px; color: var(--d-muted);
    border-color: var(--d-border); vertical-align: middle;
}
.t-card .table tbody tr:hover { background: var(--d-surface2); }
.t-card .table tbody tr:last-child td { border-bottom: none; }
.t-empty {
    text-align: center; padding: 28px 16px;
    color: var(--d-faint); font-size: 0.8rem;
}
.t-empty i { font-size: 1.6rem; display: block; margin-bottom: 6px; opacity: .4; }
[data-z-theme="dark"] .t-card { background: var(--z-surface,#1c1b19); border-color: var(--z-border,#393836); }
[data-z-theme="dark"] .t-card-head { background: var(--z-surface-offset,#1d1c1a); border-color: var(--z-border,#393836); }
[data-z-theme="dark"] .t-card-head h6 { color: var(--z-text,#cdccca); }
[data-z-theme="dark"] .t-card .table thead th { background: var(--z-surface-offset,#1d1c1a); color: var(--z-text-faint,#5a5957); border-color: var(--z-border,#393836); }
[data-z-theme="dark"] .t-card .table tbody td { color: var(--z-text-muted,#797876); border-color: var(--z-border,#393836); }
[data-z-theme="dark"] .t-card .table tbody tr:hover { background: var(--z-surface-offset,#1d1c1a); }

/* ── Responsive ── */
@media (max-width: 575px) {
    .kpi-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .qstat-grid { grid-template-columns: repeat(2, 1fr); }
    .dash-header { flex-direction: column; align-items: flex-start; }
    .kpi-value { font-size: 1.45rem; }
}
</style>
@endsection

@section('content')
<div class="dash-wrap">

    {{-- ══════════════════════════════
         PAGE HEADER
    ══════════════════════════════ --}}
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

    {{-- Subscription Banner (restaurant only) --}}
    @if(Auth::user()->user_type == 3)
    <div class="dash-sub-banner">
        <i class="fas fa-clock"></i>
        <span>{{ trans('cruds.end_subscription') }}:
            <strong>{{ optional(\App\Models\SubscriptionUser::where('user_id', Auth::id())->where('status', 1)->first())->end_day ?? '—' }}</strong>
        </span>
    </div>
    @endif

    @can('home')

    {{-- ══════════════════════════════
         KPI CARDS — Main Overview
    ══════════════════════════════ --}}
    <div class="dash-section-label">
        <span class="label-icon"><i class="fas fa-th-large"></i></span>
        {{ trans('panel.overview') ?? 'نظرة عامة' }}
    </div>

    <div class="kpi-grid">

        {{-- Users (admin only) --}}
        @if(Auth::user()->user_type != 3)
        <div class="kpi-card kpi-blue">
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
            <div class="kpi-label">{{ $settings1['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings1['total_number'] }}">{{ number_format($settings1['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-user-circle"></i> {{ trans('panel.total') ?? 'الإجمالي' }}</div>
        </div>

        {{-- Restaurants --}}
        <div class="kpi-card kpi-green">
            <div class="kpi-icon"><i class="fas fa-store"></i></div>
            <div class="kpi-label">{{ $settings2['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings2['total_number'] }}">{{ number_format($settings2['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-utensils"></i> {{ trans('panel.total') ?? 'الإجمالي' }}</div>
        </div>
        @endif

        {{-- Orders total --}}
        <div class="kpi-card kpi-cyan">
            <div class="kpi-icon"><i class="fas fa-shopping-bag"></i></div>
            <div class="kpi-label">{{ $settings3['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings3['total_number'] }}">{{ number_format($settings3['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-layer-group"></i> {{ trans('panel.all_time') ?? 'كل الوقت' }}</div>
        </div>

        {{-- Items --}}
        <div class="kpi-card kpi-purple">
            <div class="kpi-icon"><i class="fas fa-box-open"></i></div>
            <div class="kpi-label">{{ $settings4['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings4['total_number'] }}">{{ number_format($settings4['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-list"></i> {{ trans('panel.total') ?? 'الإجمالي' }}</div>
        </div>

        {{-- Today's orders --}}
        <div class="kpi-card kpi-teal">
            <div class="kpi-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="kpi-label">{{ $settings18['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings18['total_number'] }}">{{ number_format($settings18['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-clock"></i> {{ now()->format('d/m') }}</div>
        </div>

        {{-- Completed orders --}}
        <div class="kpi-card kpi-green">
            <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
            <div class="kpi-label">{{ $settings17['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings17['total_number'] }}">{{ number_format($settings17['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-check"></i> status_id = 2</div>
        </div>

        {{-- Pending/reserved --}}
        <div class="kpi-card kpi-amber">
            <div class="kpi-icon"><i class="fas fa-hourglass-half"></i></div>
            <div class="kpi-label">{{ $settings16['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings16['total_number'] }}">{{ number_format($settings16['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-pause-circle"></i> status_id = 3</div>
        </div>

        {{-- Active Ads (admin only) --}}
        @if(Auth::user()->user_type == 1)
        <div class="kpi-card kpi-rose">
            <div class="kpi-icon"><i class="fas fa-bullhorn"></i></div>
            <div class="kpi-label">{{ $settings19['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings19['total_number'] }}">{{ number_format($settings19['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-ad"></i> {{ trans('panel.active') ?? 'نشط' }}</div>
        </div>
        @endif

        {{-- Restaurant visits --}}
        @if(Auth::user()->user_type == 3)
        <div class="kpi-card kpi-cyan">
            <div class="kpi-icon"><i class="fas fa-eye"></i></div>
            <div class="kpi-label">{{ $settings24['chart_title'] }}</div>
            <div class="kpi-value" data-count="{{ $settings24['total_number'] }}">{{ number_format($settings24['total_number']) }}</div>
            <div class="kpi-trend"><i class="fas fa-chart-line"></i> {{ trans('panel.total') ?? 'الإجمالي' }}</div>
        </div>

        {{-- Rating --}}
        @php($avgRate = \App\Models\Rate::where('restaurant_id', Auth::id())->avg('rating') ?? 0)
        <div class="kpi-card kpi-amber">
            <div class="kpi-icon"><i class="fas fa-star"></i></div>
            <div class="kpi-label">{{ trans('cruds.rates') ?? 'التقييم' }}</div>
            <div class="kpi-value">{{ number_format($avgRate, 1) }}</div>
            <div class="kpi-stars">
                @for($s = 1; $s <= 5; $s++)
                    <i class="fas fa-star" style="color:{{ $s <= round($avgRate) ? '#fbbf24' : 'var(--d-border)' }}"></i>
                @endfor
            </div>
        </div>
        @endif

    </div>

    {{-- ══════════════════════════════
         ORDERS TIMELINE STATS
    ══════════════════════════════ --}}
    <div class="dash-section-label">
        <span class="label-icon"><i class="fas fa-history"></i></span>
        {{ trans('panel.orders_timeline') ?? 'الطلبات حسب الفترة' }}
    </div>

    <div class="qstat-grid">
        <div class="qstat-card">
            <div class="qstat-label">{{ $settings10['chart_title'] }}</div>
            <div class="qstat-value">{{ number_format($settings10['total_number']) }}</div>
            <div class="qstat-sub">7 {{ trans('panel.days') ?? 'أيام' }}</div>
        </div>
        <div class="qstat-card">
            <div class="qstat-label">{{ $settings11['chart_title'] }}</div>
            <div class="qstat-value">{{ number_format($settings11['total_number']) }}</div>
            <div class="qstat-sub">14 {{ trans('panel.days') ?? 'يوم' }}</div>
        </div>
        <div class="qstat-card">
            <div class="qstat-label">{{ $settings12['chart_title'] }}</div>
            <div class="qstat-value">{{ number_format($settings12['total_number']) }}</div>
            <div class="qstat-sub">30 {{ trans('panel.days') ?? 'يوم' }}</div>
        </div>
        <div class="qstat-card">
            <div class="qstat-label">{{ $settings13['chart_title'] }}</div>
            <div class="qstat-value">{{ number_format($settings13['total_number']) }}</div>
            <div class="qstat-sub">{{ trans('panel.this_week') ?? 'هذا الأسبوع' }}</div>
        </div>
        <div class="qstat-card">
            <div class="qstat-label">{{ $settings14['chart_title'] }}</div>
            <div class="qstat-value">{{ number_format($settings14['total_number']) }}</div>
            <div class="qstat-sub">{{ trans('panel.this_month') ?? 'هذا الشهر' }}</div>
        </div>
        <div class="qstat-card">
            <div class="qstat-label">{{ $settings15['chart_title'] }}</div>
            <div class="qstat-value">{{ number_format($settings15['total_number']) }}</div>
            <div class="qstat-sub">{{ now()->year }}</div>
        </div>
    </div>

    {{-- ══════════════════════════════
         CHARTS
    ══════════════════════════════ --}}
    <div class="dash-section-label">
        <span class="label-icon"><i class="fas fa-chart-area"></i></span>
        {{ trans('panel.statistics') ?? 'الإحصائيات' }}
    </div>

    <div class="row">

        <div class="{{ $chart5->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-head">
                    <h6 class="chart-card-title">
                        <span class="chart-card-icon"><i class="fas fa-chart-bar"></i></span>
                        {!! $chart5->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart5->renderHtml() !!}
            </div>
        </div>

        @if(Auth::user()->user_type != 3 && $chart6 && $chart7)
        <div class="{{ $chart6->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-head">
                    <h6 class="chart-card-title">
                        <span class="chart-card-icon"><i class="fas fa-chart-pie"></i></span>
                        {!! $chart6->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart6->renderHtml() !!}
            </div>
        </div>
        <div class="{{ $chart7->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-head">
                    <h6 class="chart-card-title">
                        <span class="chart-card-icon"><i class="fas fa-chart-pie"></i></span>
                        {!! $chart7->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart7->renderHtml() !!}
            </div>
        </div>
        @endif

        <div class="{{ $chart17->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-head">
                    <h6 class="chart-card-title">
                        <span class="chart-card-icon"><i class="fas fa-dollar-sign"></i></span>
                        {!! $chart17->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart17->renderHtml() !!}
            </div>
        </div>

        <div class="{{ $chart18->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-head">
                    <h6 class="chart-card-title">
                        <span class="chart-card-icon"><i class="fas fa-chart-line"></i></span>
                        {!! $chart18->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart18->renderHtml() !!}
            </div>
        </div>

        <div class="{{ $chart19->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-head">
                    <h6 class="chart-card-title">
                        <span class="chart-card-icon"><i class="fas fa-chart-line"></i></span>
                        {!! $chart19->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart19->renderHtml() !!}
            </div>
        </div>

        <div class="{{ $chart20->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-head">
                    <h6 class="chart-card-title">
                        <span class="chart-card-icon"><i class="fas fa-chart-area"></i></span>
                        {!! $chart20->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart20->renderHtml() !!}
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════
         LATEST ENTRIES TABLES
    ══════════════════════════════ --}}
    @if(Auth::user()->user_type != 3)
    <div class="dash-section-label">
        <span class="label-icon"><i class="fas fa-table"></i></span>
        {{ trans('panel.latest_entries') ?? 'آخر الإدخالات' }}
    </div>

    <div class="row">

        <div class="{{ $settings8['column_class'] }}">
            <div class="t-card">
                <div class="t-card-head">
                    <i class="fas fa-users"></i>
                    <h6>{{ $settings8['chart_title'] }}</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                @foreach($settings8['fields'] as $key => $value)
                                    <th>{{ trans(sprintf('cruds.%s.fields.%s', strtolower(last(explode('\\', $settings8['model']))), $key)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settings8['data'] as $entry)
                                <tr>
                                    @foreach($settings8['fields'] as $key => $value)
                                        <td>
                                            @if($value === '')
                                                {{ $entry->{$key} }}
                                            @elseif(is_iterable($entry->{$key}))
                                                @foreach($entry->{$key} as $sub)
                                                    <span class="badge badge-light">{{ $sub->{$value} }}</span>
                                                @endforeach
                                            @else
                                                {{ data_get($entry, $key.'.'.$value) }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($settings8['fields']) }}">
                                        <div class="t-empty">
                                            <i class="fas fa-inbox"></i>
                                            {{ __('No entries found') }}
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="{{ $settings9['column_class'] }}">
            <div class="t-card">
                <div class="t-card-head">
                    <i class="fas fa-store"></i>
                    <h6>{{ $settings9['chart_title'] }}</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                @foreach($settings9['fields'] as $key => $value)
                                    <th>{{ trans(sprintf('cruds.%s.fields.%s', strtolower(last(explode('\\', $settings9['model']))), $key)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settings9['data'] as $entry)
                                <tr>
                                    @foreach($settings9['fields'] as $key => $value)
                                        <td>
                                            @if($value === '')
                                                {{ $entry->{$key} }}
                                            @elseif(is_iterable($entry->{$key}))
                                                @foreach($entry->{$key} as $sub)
                                                    <span class="badge badge-light">{{ $sub->{$value} }}</span>
                                                @endforeach
                                            @else
                                                {{ data_get($entry, $key.'.'.$value) }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($settings9['fields']) }}">
                                        <div class="t-empty">
                                            <i class="fas fa-inbox"></i>
                                            {{ __('No entries found') }}
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @endif

    @endcan

</div>
@endsection

@section('scripts')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
{!! $chart5->renderJs() !!}
@if(Auth::user()->user_type != 3)
    {!! $chart6->renderJs() !!}
    {!! $chart7->renderJs() !!}
@endif
{!! $chart17->renderJs() !!}
{!! $chart18->renderJs() !!}
{!! $chart19->renderJs() !!}
{!! $chart20->renderJs() !!}

{{-- Animate KPI numbers on page load --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.kpi-value[data-count]').forEach(function(el) {
        var target = parseInt(el.getAttribute('data-count'), 10);
        if (isNaN(target) || target === 0) return;
        var start = 0;
        var duration = 900;
        var startTime = null;
        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var ease = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(ease * target).toLocaleString();
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString();
        }
        requestAnimationFrame(step);
    });
});
</script>
@endsection
