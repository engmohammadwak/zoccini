@extends('layouts.admin')

@section('styles')
<style>
/* =============================================
   DASHBOARD — Modern Redesign v2
============================================= */

/* Page Header */
.dash-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 12px;
}
.dash-page-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.dash-page-subtitle {
    font-size: 0.8rem;
    color: #94a3b8;
    margin-top: 3px;
}
.dash-date-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 8px 16px;
    font-size: 0.78rem;
    color: #64748b;
    font-weight: 500;
}

/* Subscription banner */
.dash-sub-banner {
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border: 1px solid #fde68a;
    border-radius: 12px;
    padding: 12px 18px;
    margin-bottom: 24px;
    font-size: 0.83rem;
    color: #92400e;
    font-weight: 500;
}
.dash-sub-banner i { color: #f59e0b; font-size: 1rem; flex-shrink: 0; }

/* Section titles */
.dash-section-title {
    font-size: 0.75rem;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.dash-section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e2e8f0;
}
.dash-section-title i { color: #4f7cff; font-size: 0.8rem; }

/* ---- KPI Cards ---- */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 14px;
    margin-bottom: 28px;
}
.kpi-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: box-shadow 0.2s, transform 0.2s;
    position: relative;
    overflow: hidden;
}
.kpi-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}
.kpi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--kpi-color, #4f7cff);
    border-radius: 14px 14px 0 0;
}
.kpi-icon-wrap {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    margin-bottom: 14px;
    background: var(--kpi-bg, rgba(79,124,255,0.1));
    color: var(--kpi-color, #4f7cff);
}
.kpi-label {
    font-size: 0.72rem;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 6px;
    line-height: 1.4;
}
.kpi-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
    font-variant-numeric: tabular-nums;
    letter-spacing: -0.5px;
}
.kpi-rate-stars {
    display: flex;
    align-items: center;
    gap: 3px;
    margin-top: 8px;
}
.kpi-rate-stars i { color: #fbbf24; font-size: 0.7rem; }

/* KPI color themes — 4 semantic groups */
.kpi-primary  { --kpi-color: #4f7cff; --kpi-bg: rgba(79,124,255,0.08); }
.kpi-success  { --kpi-color: #10b981; --kpi-bg: rgba(16,185,129,0.08); }
.kpi-warning  { --kpi-color: #f59e0b; --kpi-bg: rgba(245,158,11,0.08); }
.kpi-danger   { --kpi-color: #ef4444; --kpi-bg: rgba(239,68,68,0.08); }
.kpi-info     { --kpi-color: #06b6d4; --kpi-bg: rgba(6,182,212,0.08); }
.kpi-purple   { --kpi-color: #8b5cf6; --kpi-bg: rgba(139,92,246,0.08); }

/* ---- Chart cards ---- */
.chart-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 20px 16px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    margin-bottom: 20px;
    height: 100%;
}
.chart-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    padding-bottom: 14px;
    border-bottom: 1px solid #f8fafc;
}
.chart-card-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}
.chart-card-title .chart-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: rgba(79,124,255,0.1);
    color: #4f7cff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
}

/* ---- Table cards ---- */
.table-card {
    background: #fff;
    border-radius: 14px;
    padding: 0;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    margin-bottom: 20px;
    overflow: hidden;
}
.table-card-header {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    background: #fafbfc;
}
.table-card-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #334155;
    margin: 0;
}
.table-card-title i { color: #4f7cff; }
.table-card .table {
    margin-bottom: 0;
    font-size: 0.8rem;
}
.table-card .table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 16px;
    border-bottom: 1px solid #e2e8f0;
    border-top: none;
    white-space: nowrap;
}
.table-card .table tbody td {
    padding: 11px 16px;
    color: #475569;
    border-color: #f8fafc;
    vertical-align: middle;
}
.table-card .table tbody tr:hover { background: #fafbfc; }
.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-empty-state {
    text-align: center;
    padding: 32px 20px;
    color: #cbd5e1;
}
.table-empty-state i { font-size: 2rem; display: block; margin-bottom: 8px; }
.table-empty-state span { font-size: 0.82rem; color: #94a3b8; }
</style>
@endsection

@section('content')
<div class="container-fluid px-3 py-3">

    {{-- Page Header --}}
    <div class="dash-page-header">
        <div>
            <h1 class="dash-page-title">{{ trans('panel.dashboard') ?? 'Dashboard' }}</h1>
            <div class="dash-page-subtitle">{{ trans('panel.welcome_back') ?? 'Welcome back,' }} <strong>{{ Auth::user()->name }}</strong></div>
        </div>
        <div class="dash-date-badge">
            <i class="fas fa-calendar-alt"></i>
            {{ now()->translatedFormat('l, d M Y') }}
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Subscription Banner (restaurant users only) --}}
    @if(Auth::user()->user_type == 3)
    <div class="dash-sub-banner">
        <i class="fas fa-clock"></i>
        <span>{{ trans('cruds.end_subscription') }}: <strong>{{ optional(\App\Models\SubscriptionUser::where('user_id', Auth::id())->where('status', 1)->first())->end_day ?? '—' }}</strong></span>
    </div>
    @endif

    @can('home')

    {{-- ===== KPI CARDS ===== --}}
    <div class="dash-section-title"><i class="fas fa-tachometer-alt"></i>{{ trans('panel.overview') ?? 'Overview' }}</div>

    <div class="kpi-grid">

        @if(Auth::user()->user_type != 3)
        <div class="kpi-card kpi-primary">
            <div class="kpi-icon-wrap"><i class="fas fa-shopping-bag"></i></div>
            <div class="kpi-label">{{ $settings1['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings1['total_number']) }}</div>
        </div>
        <div class="kpi-card kpi-success">
            <div class="kpi-icon-wrap"><i class="fas fa-users"></i></div>
            <div class="kpi-label">{{ $settings2['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings2['total_number']) }}</div>
        </div>
        @endif

        <div class="kpi-card kpi-info">
            <div class="kpi-icon-wrap"><i class="fas fa-store"></i></div>
            <div class="kpi-label">{{ $settings3['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings3['total_number']) }}</div>
        </div>

        <div class="kpi-card kpi-purple">
            <div class="kpi-icon-wrap"><i class="fas fa-motorcycle"></i></div>
            <div class="kpi-label">{{ $settings4['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings4['total_number']) }}</div>
        </div>

        <div class="kpi-card kpi-warning">
            <div class="kpi-icon-wrap"><i class="fas fa-star"></i></div>
            <div class="kpi-label">{{ $settings10['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings10['total_number']) }}</div>
        </div>

        <div class="kpi-card kpi-danger">
            <div class="kpi-icon-wrap"><i class="fas fa-ticket-alt"></i></div>
            <div class="kpi-label">{{ $settings11['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings11['total_number']) }}</div>
        </div>

        <div class="kpi-card kpi-success">
            <div class="kpi-icon-wrap"><i class="fas fa-money-bill-wave"></i></div>
            <div class="kpi-label">{{ $settings12['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings12['total_number']) }}</div>
        </div>

        <div class="kpi-card kpi-primary">
            <div class="kpi-icon-wrap"><i class="fas fa-chart-bar"></i></div>
            <div class="kpi-label">{{ $settings15['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings15['total_number']) }}</div>
        </div>

        <div class="kpi-card kpi-info">
            <div class="kpi-icon-wrap"><i class="fas fa-map-marker-alt"></i></div>
            <div class="kpi-label">{{ $settings16['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings16['total_number']) }}</div>
        </div>

        <div class="kpi-card kpi-purple">
            <div class="kpi-icon-wrap"><i class="fas fa-bell"></i></div>
            <div class="kpi-label">{{ $settings17['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings17['total_number']) }}</div>
        </div>

        <div class="kpi-card kpi-warning">
            <div class="kpi-icon-wrap"><i class="fas fa-box"></i></div>
            <div class="kpi-label">{{ $settings18['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings18['total_number']) }}</div>
        </div>

        {{-- Rates (restaurant only) --}}
        @if(Auth::user()->user_type == 3)
        <div class="kpi-card kpi-warning">
            <div class="kpi-icon-wrap"><i class="fas fa-star"></i></div>
            <div class="kpi-label">{{ trans('cruds.rates') }}</div>
            @php($avgRate = \App\Models\Rate::where('restaurant_id', Auth::id())->avg('rating'))
            <div class="kpi-value">{{ number_format($avgRate, 1) }}</div>
            <div class="kpi-rate-stars">
                @for($s = 1; $s <= 5; $s++)
                    <i class="fas fa-star" style="color: {{ $s <= round($avgRate) ? '#fbbf24' : '#e2e8f0' }}"></i>
                @endfor
            </div>
        </div>
        @endif

        {{-- settings19 (admin only) --}}
        @if(Auth::user()->user_type == 1)
        <div class="kpi-card kpi-success">
            <div class="kpi-icon-wrap"><i class="fas fa-user-check"></i></div>
            <div class="kpi-label">{{ $settings19['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings19['total_number']) }}</div>
        </div>
        @endif

        {{-- settings24 (restaurant only) --}}
        @if(Auth::user()->user_type == 3)
        <div class="kpi-card kpi-info">
            <div class="kpi-icon-wrap"><i class="fas fa-percent"></i></div>
            <div class="kpi-label">{{ $settings24['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings24['total_number']) }}</div>
        </div>
        @endif

    </div>{{-- end kpi-grid --}}

    {{-- ===== CHARTS ===== --}}
    <div class="dash-section-title"><i class="fas fa-chart-area"></i>{{ trans('panel.statistics') ?? 'Statistics' }}</div>

    <div class="row">

        <div class="{{ $chart5->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <span class="chart-icon"><i class="fas fa-chart-line"></i></span>
                        {!! $chart5->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart5->renderHtml() !!}
            </div>
        </div>

        @if(Auth::user()->user_type != 3)
        <div class="{{ $chart6->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <span class="chart-icon"><i class="fas fa-chart-bar"></i></span>
                        {!! $chart6->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart6->renderHtml() !!}
            </div>
        </div>
        <div class="{{ $chart7->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <span class="chart-icon"><i class="fas fa-chart-pie"></i></span>
                        {!! $chart7->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart7->renderHtml() !!}
            </div>
        </div>
        @endif

        <div class="{{ $chart17->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <span class="chart-icon"><i class="fas fa-chart-line"></i></span>
                        {!! $chart17->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart17->renderHtml() !!}
            </div>
        </div>

        <div class="{{ $chart18->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <span class="chart-icon"><i class="fas fa-chart-bar"></i></span>
                        {!! $chart18->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart18->renderHtml() !!}
            </div>
        </div>

        <div class="{{ $chart19->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <span class="chart-icon"><i class="fas fa-chart-pie"></i></span>
                        {!! $chart19->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart19->renderHtml() !!}
            </div>
        </div>

        <div class="{{ $chart20->options['column_class'] }} mb-3">
            <div class="chart-card">
                <div class="chart-card-header">
                    <h6 class="chart-card-title">
                        <span class="chart-icon"><i class="fas fa-chart-area"></i></span>
                        {!! $chart20->options['chart_title'] !!}
                    </h6>
                </div>
                {!! $chart20->renderHtml() !!}
            </div>
        </div>

    </div>

    {{-- ===== LATEST ENTRIES TABLES ===== --}}
    @if(Auth::user()->user_type != 3)
    <div class="dash-section-title"><i class="fas fa-table"></i>{{ trans('panel.latest_entries') ?? 'Latest Entries' }}</div>
    <div class="row">

        <div class="{{ $settings8['column_class'] }}">
            <div class="table-card">
                <div class="table-card-header">
                    <i class="fas fa-list-alt table-card-title"></i>
                    <h6 class="table-card-title mb-0">{{ $settings8['chart_title'] }}</h6>
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
                                                @foreach($entry->{$key} as $subEentry)
                                                    <span class="badge badge-light">{{ $subEentry->{$value} }}</span>
                                                @endforeach
                                            @else
                                                {{ data_get($entry, $key . '.' . $value) }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($settings8['fields']) }}">
                                        <div class="table-empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <span>{{ __('No entries found') }}</span>
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
            <div class="table-card">
                <div class="table-card-header">
                    <i class="fas fa-list-alt table-card-title"></i>
                    <h6 class="table-card-title mb-0">{{ $settings9['chart_title'] }}</h6>
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
                                                @foreach($entry->{$key} as $subEentry)
                                                    <span class="badge badge-light">{{ $subEentry->{$value} }}</span>
                                                @endforeach
                                            @else
                                                {{ data_get($entry, $key . '.' . $value) }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($settings9['fields']) }}">
                                        <div class="table-empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <span>{{ __('No entries found') }}</span>
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
{{-- Chart.js v4 (replaces legacy 2.5) --}}
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
@endsection
