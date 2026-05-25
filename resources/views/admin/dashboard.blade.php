@extends('layouts.admin')

@section('title', __('Dashboard'))

@section('content')
<div class="dashboard-wrapper">

    {{-- ===== HEADER ===== --}}
    <div class="page-header mb-4">
        <div>
            <h1 class="page-title">{{ __('Dashboard') }}</h1>
            <p class="page-subtitle text-muted">{{ __('Welcome back') }}, <strong>{{ auth()->user()->name ?? 'Admin' }}</strong> 👋</p>
        </div>
        <div class="page-header-actions">
            <span class="badge bg-light text-dark border px-3 py-2">
                <i class="fas fa-calendar-alt me-1 text-primary"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    {{-- ===== KPI CARDS ===== --}}
    <div class="row g-3 mb-4">

        {{-- Orders --}}
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card kpi-primary">
                <div class="kpi-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="kpi-body">
                    <div class="kpi-label">{{ __('Total Orders') }}</div>
                    <div class="kpi-value" data-count="{{ $ordersCount ?? 0 }}">{{ $ordersCount ?? 0 }}</div>
                    <div class="kpi-trend up">
                        <i class="fas fa-arrow-up me-1"></i>{{ $ordersGrowth ?? '0' }}% {{ __('vs last month') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Restaurants --}}
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card kpi-success">
                <div class="kpi-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="kpi-body">
                    <div class="kpi-label">{{ __('Restaurants') }}</div>
                    <div class="kpi-value" data-count="{{ $restaurantsCount ?? 0 }}">{{ $restaurantsCount ?? 0 }}</div>
                    <div class="kpi-trend up">
                        <i class="fas fa-store me-1"></i>{{ __('Active partners') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Users --}}
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card kpi-warning">
                <div class="kpi-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="kpi-body">
                    <div class="kpi-label">{{ __('Users') }}</div>
                    <div class="kpi-value" data-count="{{ $usersCount ?? 0 }}">{{ $usersCount ?? 0 }}</div>
                    <div class="kpi-trend up">
                        <i class="fas fa-user-plus me-1"></i>{{ __('Registered users') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card kpi-info">
                <div class="kpi-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="kpi-body">
                    <div class="kpi-label">{{ __('Revenue') }}</div>
                    <div class="kpi-value" data-count="{{ $totalRevenue ?? 0 }}">{{ number_format($totalRevenue ?? 0, 2) }}</div>
                    <div class="kpi-trend up">
                        <i class="fas fa-chart-line me-1"></i>{{ __('Total earnings') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== CHARTS ROW ===== --}}
    <div class="row g-3 mb-4">

        {{-- Orders Chart --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card dashboard-card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-area me-2 text-primary"></i>{{ __('Orders Overview') }}
                    </h6>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary active chart-filter" data-period="week">{{ __('Week') }}</button>
                        <button type="button" class="btn btn-outline-secondary chart-filter" data-period="month">{{ __('Month') }}</button>
                        <button type="button" class="btn btn-outline-secondary chart-filter" data-period="year">{{ __('Year') }}</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="ordersChart" height="280"></canvas>
                </div>
            </div>
        </div>

        {{-- Orders Status Pie --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card dashboard-card h-100">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2 text-success"></i>{{ __('Order Status') }}
                    </h6>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <canvas id="statusChart" height="220"></canvas>
                    <div id="statusLegend" class="mt-3 w-100"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== BOTTOM ROW ===== --}}
    <div class="row g-3">

        {{-- Recent Orders --}}
        <div class="col-xl-8">
            <div class="card dashboard-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-list-alt me-2 text-primary"></i>{{ __('Recent Orders') }}
                    </h6>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                        {{ __('View All') }} <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Restaurant') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td class="ps-3"><span class="fw-semibold text-primary">#{{ $order->id }}</span></td>
                                    <td>{{ $order->user->name ?? '-' }}</td>
                                    <td>{{ $order->restaurant->name ?? '-' }}</td>
                                    <td class="fw-semibold">{{ number_format($order->total ?? 0, 2) }}</td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            @if($order->status == 'completed') bg-success
                                            @elseif($order->status == 'pending') bg-warning text-dark
                                            @elseif($order->status == 'cancelled') bg-danger
                                            @else bg-info @endif">
                                            {{ $order->status ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $order->created_at?->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        {{ __('No recent orders') }}
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
            <div class="card dashboard-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-trophy me-2 text-warning"></i>{{ __('Top Restaurants') }}
                    </h6>
                    <a href="{{ route('admin.restaurants.index') }}" class="btn btn-sm btn-outline-secondary">
                        {{ __('All') }}
                    </a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($topRestaurants ?? [] as $index => $restaurant)
                        <li class="list-group-item d-flex align-items-center gap-3 py-3">
                            <div class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</div>
                            @if($restaurant->logo)
                                <img src="{{ asset('storage/' . $restaurant->logo) }}" 
                                     class="rounded-circle" width="38" height="38" 
                                     style="object-fit:cover;" alt="{{ $restaurant->name }}">
                            @else
                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:38px;height:38px;background:var(--brand-light);color:var(--brand-primary);font-weight:700;">
                                    {{ strtoupper(substr($restaurant->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="flex-grow-1 min-width-0">
                                <div class="fw-semibold text-truncate">{{ $restaurant->name }}</div>
                                <small class="text-muted">{{ $restaurant->orders_count ?? 0 }} {{ __('orders') }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary small">{{ number_format($restaurant->revenue ?? 0, 0) }}</div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4 text-muted">
                            <i class="fas fa-store fa-2x mb-2 d-block"></i>
                            {{ __('No data') }}
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
/* ===== KPI Cards ===== */
.kpi-card {
    border-radius: 16px;
    padding: 1.4rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    border: none;
    transition: transform 0.2s, box-shadow 0.2s;
    background: #fff;
    border-left: 4px solid transparent;
}
.kpi-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.kpi-primary  { border-left-color: var(--brand-primary, #e8523b); }
.kpi-success  { border-left-color: #28a745; }
.kpi-warning  { border-left-color: #ffc107; }
.kpi-info     { border-left-color: #17a2b8; }

.kpi-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; flex-shrink: 0;
}
.kpi-primary .kpi-icon { background: rgba(232,82,59,0.12); color: var(--brand-primary, #e8523b); }
.kpi-success .kpi-icon { background: rgba(40,167,69,0.12); color: #28a745; }
.kpi-warning .kpi-icon { background: rgba(255,193,7,0.15); color: #d39e00; }
.kpi-info    .kpi-icon { background: rgba(23,162,184,0.12); color: #17a2b8; }

.kpi-label { font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em; color: #8a8a8a; font-weight: 600; margin-bottom: 2px; }
.kpi-value { font-size: 1.9rem; font-weight: 800; color: #1a1a2e; line-height: 1.1; }
.kpi-trend  { font-size: 0.75rem; color: #6c757d; margin-top: 3px; }
.kpi-trend.up { color: #28a745; }
.kpi-trend.down { color: #dc3545; }

/* ===== Dashboard Cards ===== */
.dashboard-card {
    border: 1px solid rgba(0,0,0,0.07);
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.dashboard-card .card-header {
    background: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.07);
    border-radius: 14px 14px 0 0 !important;
    padding: 1rem 1.25rem;
}
.card-title { font-size: 0.9rem; font-weight: 700; color: #2d2d2d; }

/* ===== Rank Badges ===== */
.rank-badge {
    width: 26px; height: 26px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; font-weight: 800; flex-shrink: 0;
    background: #e9ecef; color: #6c757d;
}
.rank-1 { background: #FFD700; color: #7a6200; }
.rank-2 { background: #C0C0C0; color: #4a4a4a; }
.rank-3 { background: #CD7F32; color: #fff; }

/* ===== Page Header ===== */
.page-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; }
.page-title { font-size: 1.5rem; font-weight: 800; color: #1a1a2e; margin: 0; }
.page-subtitle { margin: 0; font-size: 0.88rem; }

/* Dark Mode */
body.dark-mode .kpi-card { background: #1e2235; border-left-color: inherit; }
body.dark-mode .kpi-value { color: #e8e8f0; }
body.dark-mode .dashboard-card { background: #1e2235; border-color: rgba(255,255,255,0.07); }
body.dark-mode .dashboard-card .card-header { background: #1e2235; border-color: rgba(255,255,255,0.07); }
body.dark-mode .card-title { color: #e0e0f0; }
body.dark-mode .table { color: #cbd0e0; }
body.dark-mode .table-light th { background: #252a40; color: #aab0c8; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== Counter Animation =====
    document.querySelectorAll('.kpi-value[data-count]').forEach(el => {
        const target = parseFloat(el.getAttribute('data-count')) || 0;
        const duration = 1200;
        const start = performance.now();
        const isDecimal = target % 1 !== 0;
        function update(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = target * eased;
            el.textContent = isDecimal ? current.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) : Math.floor(current).toLocaleString();
            if (progress < 1) requestAnimationFrame(update);
        }
        requestAnimationFrame(update);
    });

    // ===== Orders Line Chart =====
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx) {
        const brandColor = getComputedStyle(document.documentElement).getPropertyValue('--brand-primary').trim() || '#e8523b';
        const ordersChart = new Chart(ordersCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']) !!},
                datasets: [{
                    label: '{{ __("Orders") }}',
                    data: {!! json_encode($chartData ?? [12,19,8,25,30,18,22]) !!},
                    borderColor: brandColor || '#e8523b',
                    backgroundColor: 'rgba(232,82,59,0.08)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: brandColor || '#e8523b',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                    y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { font: { size: 11 }, precision: 0 } }
                }
            }
        });

        // Filter buttons
        document.querySelectorAll('.chart-filter').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.chart-filter').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                // TODO: fetch data via AJAX based on data-period
            });
        });
    }

    // ===== Status Donut Chart =====
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = {!! json_encode($statusData ?? ['completed' => 45, 'pending' => 20, 'cancelled' => 10, 'delivering' => 25]) !!};
        const labels = Object.keys(statusData).map(k => k.charAt(0).toUpperCase() + k.slice(1));
        const values = Object.values(statusData);
        const colors = ['#28a745','#ffc107','#dc3545','#17a2b8'];
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{ data: values, backgroundColor: colors, borderWidth: 2, borderColor: '#fff', hoverOffset: 6 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } }
                }
            }
        });

        // Custom Legend
        const legend = document.getElementById('statusLegend');
        if (legend) {
            legend.innerHTML = labels.map((l, i) => `
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="d-flex align-items-center gap-2">
                        <span style="width:10px;height:10px;border-radius:50%;background:${colors[i]};display:inline-block;"></span>
                        <span class="small">${l}</span>
                    </div>
                    <span class="fw-semibold small">${values[i]}</span>
                </div>`).join('');
        }
    }
});
</script>
@endpush
