@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
<div class="dash-wrapper">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="dash-header mb-4">
        <div>
            <h1 class="dash-title">{{ __('Dashboard') }}</h1>
            <p class="dash-sub">{{ __('Welcome back') }}, <strong>{{ auth()->user()->name ?? 'Admin' }}</strong> 👋</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="dash-date-badge">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    {{-- ===== KPI CARDS ===== --}}
    <div class="row g-3 mb-4">

        {{-- Orders --}}
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card kpi-orange">
                <div class="kpi-icon-wrap">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="kpi-content">
                    <span class="kpi-label">{{ __('Total Orders') }}</span>
                    <span class="kpi-val" data-count="{{ $ordersCount ?? 0 }}">{{ $ordersCount ?? 0 }}</span>
                    <span class="kpi-sub">
                        <i class="fas fa-arrow-up me-1"></i>{{ $ordersGrowth ?? '0' }}% {{ __('vs last month') }}
                    </span>
                </div>
                <div class="kpi-sparkline">
                    <svg viewBox="0 0 80 30" preserveAspectRatio="none">
                        <polyline points="0,25 13,18 26,22 39,10 52,14 65,5 80,8" fill="none" stroke="currentColor" stroke-width="2" opacity="0.35"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Restaurants --}}
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card kpi-green">
                <div class="kpi-icon-wrap">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="kpi-content">
                    <span class="kpi-label">{{ __('Restaurants') }}</span>
                    <span class="kpi-val" data-count="{{ $restaurantsCount ?? 0 }}">{{ $restaurantsCount ?? 0 }}</span>
                    <span class="kpi-sub"><i class="fas fa-store me-1"></i>{{ __('Active partners') }}</span>
                </div>
                <div class="kpi-sparkline">
                    <svg viewBox="0 0 80 30" preserveAspectRatio="none">
                        <polyline points="0,20 13,15 26,18 39,8 52,12 65,6 80,9" fill="none" stroke="currentColor" stroke-width="2" opacity="0.35"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Users --}}
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card kpi-blue">
                <div class="kpi-icon-wrap">
                    <i class="fas fa-users"></i>
                </div>
                <div class="kpi-content">
                    <span class="kpi-label">{{ __('Users') }}</span>
                    <span class="kpi-val" data-count="{{ $usersCount ?? 0 }}">{{ $usersCount ?? 0 }}</span>
                    <span class="kpi-sub"><i class="fas fa-user-plus me-1"></i>{{ __('Registered users') }}</span>
                </div>
                <div class="kpi-sparkline">
                    <svg viewBox="0 0 80 30" preserveAspectRatio="none">
                        <polyline points="0,22 13,20 26,15 39,12 52,10 65,7 80,4" fill="none" stroke="currentColor" stroke-width="2" opacity="0.35"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card kpi-purple">
                <div class="kpi-icon-wrap">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="kpi-content">
                    <span class="kpi-label">{{ __('Revenue') }}</span>
                    <span class="kpi-val" data-count="{{ $totalRevenue ?? 0 }}" data-decimal="1">{{ number_format($totalRevenue ?? 0, 2) }}</span>
                    <span class="kpi-sub"><i class="fas fa-chart-line me-1"></i>{{ __('Total earnings') }}</span>
                </div>
                <div class="kpi-sparkline">
                    <svg viewBox="0 0 80 30" preserveAspectRatio="none">
                        <polyline points="0,28 13,22 26,24 39,15 52,11 65,8 80,3" fill="none" stroke="currentColor" stroke-width="2" opacity="0.35"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== CHARTS ROW ===== --}}
    <div class="row g-3 mb-4">

        {{-- Orders Area Chart --}}
        <div class="col-xl-8 col-lg-7">
            <div class="dash-card h-100">
                <div class="dash-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <div class="card-head-icon" style="background:rgba(var(--brand-rgb),0.1);color:var(--brand-primary);">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <span class="dash-card-title">{{ __('Orders Overview') }}</span>
                    </div>
                    <div class="period-tabs">
                        <button class="period-btn active" data-period="week">{{ __('Week') }}</button>
                        <button class="period-btn" data-period="month">{{ __('Month') }}</button>
                        <button class="period-btn" data-period="year">{{ __('Year') }}</button>
                    </div>
                </div>
                <div class="dash-card-body">
                    <div class="chart-container">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Status Donut --}}
        <div class="col-xl-4 col-lg-5">
            <div class="dash-card h-100">
                <div class="dash-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <div class="card-head-icon" style="background:rgba(40,167,69,0.1);color:#28a745;">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <span class="dash-card-title">{{ __('Order Status') }}</span>
                    </div>
                </div>
                <div class="dash-card-body d-flex flex-column align-items-center justify-content-center">
                    <div class="donut-wrap">
                        <canvas id="statusChart"></canvas>
                        <div class="donut-center">
                            <span class="donut-total">{{ array_sum((array)($statusData ?? [])) ?: ($ordersCount ?? 0) }}</span>
                            <span class="donut-label">{{ __('Total') }}</span>
                        </div>
                    </div>
                    <div id="statusLegend" class="status-legend mt-3 w-100"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== BOTTOM ROW ===== --}}
    <div class="row g-3">

        {{-- Recent Orders --}}
        <div class="col-xl-8">
            <div class="dash-card">
                <div class="dash-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <div class="card-head-icon" style="background:rgba(var(--brand-rgb),0.1);color:var(--brand-primary);">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <span class="dash-card-title">{{ __('Recent Orders') }}</span>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="dash-view-all">
                        {{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="dash-card-body p-0">
                    <div class="table-responsive">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Restaurant') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="pe-4">{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td class="ps-4">
                                        <span class="order-id">#{{ $order->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="mini-avatar">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                                            <span>{{ $order->user->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $order->restaurant->name ?? '-' }}</td>
                                    <td><span class="order-amount">{{ number_format($order->total ?? 0, 2) }}</span></td>
                                    <td>
                                        <span class="status-pill
                                            @if($order->status == 'completed') status-completed
                                            @elseif($order->status == 'pending') status-pending
                                            @elseif($order->status == 'cancelled') status-cancelled
                                            @else status-delivering @endif">
                                            {{ __($order->status ?? '-') }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-muted small">{{ $order->created_at?->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state-sm">
                                            <i class="fas fa-inbox"></i>
                                            <span>{{ __('No recent orders') }}</span>
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

        {{-- Top Restaurants --}}
        <div class="col-xl-4">
            <div class="dash-card">
                <div class="dash-card-head">
                    <div class="d-flex align-items-center gap-2">
                        <div class="card-head-icon" style="background:rgba(255,193,7,0.12);color:#d39e00;">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <span class="dash-card-title">{{ __('Top Restaurants') }}</span>
                    </div>
                    <a href="{{ route('admin.restaurants.index') }}" class="dash-view-all">{{ __('All') }}</a>
                </div>
                <div class="dash-card-body p-0">
                    @forelse($topRestaurants ?? [] as $index => $restaurant)
                    <div class="top-resto-item {{ $index === 0 ? 'top-resto-first' : '' }}">
                        <span class="rank-dot rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                        @if($restaurant->logo)
                            <img src="{{ asset('storage/' . $restaurant->logo) }}"
                                 class="resto-avatar" width="40" height="40"
                                 alt="{{ $restaurant->name }}" loading="lazy">
                        @else
                            <div class="resto-avatar-ph">{{ strtoupper(substr($restaurant->name, 0, 1)) }}</div>
                        @endif
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="resto-name">{{ $restaurant->name }}</div>
                            <div class="resto-orders">{{ $restaurant->orders_count ?? 0 }} {{ __('orders') }}</div>
                        </div>
                        <div class="resto-revenue">{{ number_format($restaurant->revenue ?? 0, 0) }}</div>
                    </div>
                    @empty
                    <div class="empty-state-sm">
                        <i class="fas fa-store"></i>
                        <span>{{ __('No data') }}</span>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('styles')
<style>
/* ============================================================
   DASHBOARD STYLES — Zoccini Admin
   ============================================================ */

:root {
    --brand-rgb: 232, 82, 59;
}

/* ---------- Wrapper ---------- */
.dash-wrapper { padding: 0; }

/* ---------- Header ---------- */
.dash-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .75rem;
}
.dash-title { font-size: 1.55rem; font-weight: 800; color: var(--dash-text, #1a1a2e); margin: 0; }
.dash-sub   { font-size: .875rem; color: #6c757d; margin: .1rem 0 0; }
.dash-date-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    background: #fff; border: 1px solid #e9ecef;
    border-radius: 50px; padding: .45rem 1rem;
    font-size: .8rem; font-weight: 600; color: #555;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
}

/* ---------- KPI Cards ---------- */
.kpi-card {
    position: relative; overflow: hidden;
    border-radius: 18px; padding: 1.35rem 1.4rem;
    display: flex; align-items: center; gap: 1rem;
    border: none; color: #fff;
    transition: transform .22s, box-shadow .22s;
    box-shadow: 0 4px 20px rgba(0,0,0,.12);
    min-height: 110px;
}
.kpi-card:hover { transform: translateY(-4px); box-shadow: 0 10px 32px rgba(0,0,0,.15); }

.kpi-orange { background: linear-gradient(135deg, #e8523b 0%, #f07242 100%); }
.kpi-green  { background: linear-gradient(135deg, #1fa461 0%, #29bf73 100%); }
.kpi-blue   { background: linear-gradient(135deg, #1a6fc4 0%, #3a8ee8 100%); }
.kpi-purple { background: linear-gradient(135deg, #7c3aed 0%, #9b59f4 100%); }

.kpi-icon-wrap {
    width: 52px; height: 52px; border-radius: 14px;
    background: rgba(255,255,255,.18);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem; flex-shrink: 0;
    backdrop-filter: blur(4px);
}
.kpi-content { display: flex; flex-direction: column; flex: 1; min-width: 0; }
.kpi-label {
    font-size: .7rem; text-transform: uppercase; letter-spacing: .07em;
    opacity: .82; font-weight: 700; margin-bottom: 2px;
}
.kpi-val {
    font-size: 1.95rem; font-weight: 800; line-height: 1.1;
    font-variant-numeric: tabular-nums;
}
.kpi-sub { font-size: .72rem; opacity: .78; margin-top: 3px; }

.kpi-sparkline {
    position: absolute; bottom: 0; right: 0; width: 90px; height: 40px;
    color: #fff; pointer-events: none;
}
.kpi-sparkline svg { width: 100%; height: 100%; }

/* ---------- Dash Card (generic card) ---------- */
.dash-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,.07);
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
    display: flex; flex-direction: column;
    overflow: hidden;
    transition: box-shadow .2s;
}
.dash-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.08); }

.dash-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid rgba(0,0,0,.06);
}
.dash-card-body { padding: 1.25rem; flex: 1; }

.card-head-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem; flex-shrink: 0;
}
.dash-card-title { font-size: .9rem; font-weight: 700; color: #1a1a2e; }

.dash-view-all {
    font-size: .78rem; font-weight: 600; color: var(--brand-primary, #e8523b);
    text-decoration: none; display: flex; align-items: center; gap: .25rem;
    padding: .3rem .7rem; border-radius: 6px;
    background: rgba(var(--brand-rgb), .07);
    transition: background .18s;
}
.dash-view-all:hover { background: rgba(var(--brand-rgb), .15); }

/* ---------- Period Tabs ---------- */
.period-tabs {
    display: flex; gap: .25rem;
    background: #f4f5f7; padding: .2rem; border-radius: 8px;
}
.period-btn {
    font-size: .75rem; font-weight: 600; padding: .3rem .7rem;
    border: none; background: transparent; color: #6c757d;
    border-radius: 6px; cursor: pointer; transition: all .18s;
}
.period-btn.active {
    background: #fff; color: var(--brand-primary, #e8523b);
    box-shadow: 0 1px 4px rgba(0,0,0,.1);
}

/* ---------- Chart Container ---------- */
.chart-container { position: relative; height: 270px; }
.chart-container canvas { max-height: 270px; }

/* ---------- Donut ---------- */
.donut-wrap {
    position: relative; width: 190px; height: 190px;
}
.donut-wrap canvas { width: 100% !important; height: 100% !important; }
.donut-center {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    text-align: center; pointer-events: none;
}
.donut-total { display: block; font-size: 1.6rem; font-weight: 800; color: #1a1a2e; line-height: 1; }
.donut-label { display: block; font-size: .7rem; color: #999; text-transform: uppercase; letter-spacing: .06em; margin-top: 2px; }

.legend-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: .35rem 0; border-bottom: 1px solid rgba(0,0,0,.05);
}
.legend-row:last-child { border-bottom: none; }
.legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.legend-name { font-size: .82rem; color: #555; }
.legend-val  { font-size: .82rem; font-weight: 700; color: #1a1a2e; }

/* ---------- Table ---------- */
.dash-table {
    width: 100%; border-collapse: collapse; font-size: .875rem;
}
.dash-table thead tr { background: #f8f9fb; }
.dash-table th {
    padding: .75rem .5rem; font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .05em; color: #9aa0ac;
    border-bottom: 1px solid #eee;
}
.dash-table td {
    padding: .8rem .5rem; color: #3d4052;
    border-bottom: 1px solid rgba(0,0,0,.04);
    vertical-align: middle;
}
.dash-table tbody tr:last-child td { border-bottom: none; }
.dash-table tbody tr { transition: background .15s; }
.dash-table tbody tr:hover { background: rgba(var(--brand-rgb),.03); }

.order-id     { font-weight: 700; color: var(--brand-primary, #e8523b); }
.order-amount { font-weight: 700; color: #1a1a2e; font-variant-numeric: tabular-nums; }

.mini-avatar {
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(var(--brand-rgb),.1); color: var(--brand-primary, #e8523b);
    font-size: .7rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}

/* ---------- Status Pills ---------- */
.status-pill {
    display: inline-flex; align-items: center;
    padding: .25rem .65rem; border-radius: 50px;
    font-size: .72rem; font-weight: 700; letter-spacing: .02em;
}
.status-completed  { background: rgba(40,167,69,.1);   color: #1a7a35; }
.status-pending    { background: rgba(255,193,7,.15);   color: #856404; }
.status-cancelled  { background: rgba(220,53,69,.1);   color: #a91827; }
.status-delivering { background: rgba(23,162,184,.1);  color: #0c7588; }

/* ---------- Top Restaurants ---------- */
.top-resto-item {
    display: flex; align-items: center; gap: .85rem;
    padding: .85rem 1.25rem;
    border-bottom: 1px solid rgba(0,0,0,.05);
    transition: background .15s;
}
.top-resto-item:last-child { border-bottom: none; }
.top-resto-item:hover { background: #fafbfc; }
.top-resto-first { background: rgba(255,215,0,.04); }

.rank-dot {
    width: 24px; height: 24px; border-radius: 50%; font-size: .68rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    background: #e9ecef; color: #6c757d;
}
.rank-1 { background: #FFD700; color: #7a6200; }
.rank-2 { background: #C0C0C0; color: #4a4a4a; }
.rank-3 { background: #CD7F32; color: #fff; }

.resto-avatar    { border-radius: 10px; object-fit: cover; width: 40px; height: 40px; }
.resto-avatar-ph {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(var(--brand-rgb),.1); color: var(--brand-primary, #e8523b);
    font-size: .85rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.resto-name   { font-size: .875rem; font-weight: 700; color: #1a1a2e; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.resto-orders { font-size: .75rem; color: #9aa0ac; }
.resto-revenue { font-size: .85rem; font-weight: 800; color: var(--brand-primary, #e8523b); white-space: nowrap; }

/* ---------- Empty State (small) ---------- */
.empty-state-sm {
    display: flex; flex-direction: column; align-items: center;
    gap: .5rem; padding: 2.5rem 1rem; color: #bbb; font-size: .85rem;
}
.empty-state-sm i { font-size: 2rem; }

/* ============================================================
   DARK MODE
   ============================================================ */
body.dark-mode .dash-title      { color: #e8e8f0; }
body.dark-mode .dash-date-badge { background: #1e2235; border-color: rgba(255,255,255,.08); color: #aab; }
body.dark-mode .dash-card       { background: #1e2235; border-color: rgba(255,255,255,.06); }
body.dark-mode .dash-card-head  { border-bottom-color: rgba(255,255,255,.06); }
body.dark-mode .dash-card-title { color: #e0e0f0; }
body.dark-mode .period-tabs     { background: #252a40; }
body.dark-mode .period-btn.active { background: #1e2235; }
body.dark-mode .dash-table thead tr { background: #252a40; }
body.dark-mode .dash-table th   { color: #6a7090; }
body.dark-mode .dash-table td   { color: #cbd0e0; border-color: rgba(255,255,255,.05); }
body.dark-mode .dash-table tbody tr:hover { background: rgba(255,255,255,.03); }
body.dark-mode .donut-total     { color: #e8e8f0; }
body.dark-mode .legend-val      { color: #e8e8f0; }
body.dark-mode .legend-name     { color: #9aa0ac; }
body.dark-mode .legend-row      { border-color: rgba(255,255,255,.06); }
body.dark-mode .top-resto-item  { border-color: rgba(255,255,255,.06); }
body.dark-mode .top-resto-item:hover { background: rgba(255,255,255,.03); }
body.dark-mode .resto-name      { color: #e0e0f0; }
body.dark-mode .order-amount    { color: #e0e0f0; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===================================================
       1. COUNTER ANIMATION
    =================================================== */
    document.querySelectorAll('.kpi-val[data-count]').forEach(el => {
        const target    = parseFloat(el.getAttribute('data-count')) || 0;
        const isDecimal = el.dataset.decimal === '1';
        const duration  = 1400;
        const start     = performance.now();

        function update(now) {
            const t    = Math.min((now - start) / duration, 1);
            const ease = 1 - Math.pow(1 - t, 3);
            const cur  = target * ease;
            el.textContent = isDecimal
                ? cur.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                : Math.floor(cur).toLocaleString();
            if (t < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    });

    /* ===================================================
       2. ORDERS AREA CHART
    =================================================== */
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx) {
        const brand    = getComputedStyle(document.documentElement).getPropertyValue('--brand-primary').trim() || '#e8523b';
        const isDark   = document.body.classList.contains('dark-mode');
        const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';
        const tickColor = isDark ? '#6a7090' : '#b0b8c8';

        new Chart(ordersCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']) !!},
                datasets: [{
                    label: '{{ __("Orders") }}',
                    data: {!! json_encode($chartData ?? [12,19,8,25,30,18,22]) !!},
                    borderColor: brand,
                    backgroundColor: function(ctx) {
                        const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 260);
                        g.addColorStop(0, 'rgba(232,82,59,0.18)');
                        g.addColorStop(1, 'rgba(232,82,59,0)');
                        return g;
                    },
                    borderWidth: 2.5,
                    tension: 0.42,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: brand,
                    pointBorderWidth: 2.5,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: isDark ? '#252a40' : '#fff',
                        titleColor: isDark ? '#e0e0f0' : '#1a1a2e',
                        bodyColor: isDark ? '#aab0c8' : '#555',
                        borderColor: isDark ? 'rgba(255,255,255,.1)' : 'rgba(0,0,0,.1)',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: ctx => `  ${ctx.parsed.y} {{ __('orders') }}`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: tickColor, font: { size: 11, weight: '600' } }
                    },
                    y: {
                        grid: { color: gridColor, drawBorder: false },
                        ticks: { color: tickColor, font: { size: 11 }, precision: 0 },
                        beginAtZero: true
                    }
                }
            }
        });

        document.querySelectorAll('.period-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                // TODO: AJAX fetch by this.dataset.period
            });
        });
    }

    /* ===================================================
       3. STATUS DONUT CHART
    =================================================== */
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = {!! json_encode($statusData ?? ['Completed' => 45, 'Pending' => 20, 'Cancelled' => 10, 'Delivering' => 25]) !!};
        const labels = Object.keys(statusData);
        const values = Object.values(statusData);
        const colors = ['#1fa461','#f0a500','#e8523b','#1a6fc4'];
        const isDark = document.body.classList.contains('dark-mode');

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 3,
                    borderColor: isDark ? '#1e2235' : '#fff',
                    hoverOffset: 5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` }
                    }
                }
            }
        });

        const legend = document.getElementById('statusLegend');
        if (legend) {
            legend.innerHTML = labels.map((l, i) => `
                <div class="legend-row">
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-dot" style="background:${colors[i]};"></span>
                        <span class="legend-name">${l}</span>
                    </div>
                    <span class="legend-val">${values[i]}</span>
                </div>
            `).join('');
        }
    }

});
</script>
@endpush
