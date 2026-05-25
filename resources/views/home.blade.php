@extends('layouts.admin')

@section('styles')
<style>
/* =============================================
   DASHBOARD — Modern Redesign
============================================= */

/* Page Header */
.dash-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}
.dash-page-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    font-family: 'Cairo', sans-serif;
}
.dash-page-subtitle {
    font-size: 0.78rem;
    color: #94a3b8;
    margin-top: 2px;
}
.dash-date-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 7px 14px;
    font-size: 0.78rem;
    color: #64748b;
    font-weight: 500;
}

/* Subscription banner */
.dash-sub-banner {
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #fff7ed 0%, #fef3c7 100%);
    border: 1px solid #fcd34d;
    border-radius: 12px;
    padding: 12px 18px;
    margin-bottom: 20px;
    font-size: 0.83rem;
    color: #92400e;
    font-weight: 500;
}
.dash-sub-banner i { color: #f59e0b; font-size: 1rem; }

/* KPI Cards */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.kpi-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px 20px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    transition: box-shadow 0.2s, transform 0.2s;
    position: relative;
    overflow: hidden;
}
.kpi-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.09);
    transform: translateY(-2px);
}
.kpi-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 14px 14px 0 0;
    background: var(--kpi-color, #4f7cff);
}
.kpi-icon-wrap {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    margin-bottom: 14px;
    background: var(--kpi-bg, rgba(79,124,255,0.1));
    color: var(--kpi-color, #4f7cff);
}
.kpi-label {
    font-size: 0.75rem;
    color: #94a3b8;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
    line-height: 1.3;
}
.kpi-value {
    font-size: 1.6rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1;
    font-variant-numeric: tabular-nums;
}

/* KPI color themes */
.kpi-blue   { --kpi-color: #4f7cff; --kpi-bg: rgba(79,124,255,0.1); }
.kpi-green  { --kpi-color: #22c55e; --kpi-bg: rgba(34,197,94,0.1); }
.kpi-orange { --kpi-color: #f97316; --kpi-bg: rgba(249,115,22,0.1); }
.kpi-purple { --kpi-color: #a855f7; --kpi-bg: rgba(168,85,247,0.1); }
.kpi-teal   { --kpi-color: #14b8a6; --kpi-bg: rgba(20,184,166,0.1); }
.kpi-red    { --kpi-color: #ef4444; --kpi-bg: rgba(239,68,68,0.1); }
.kpi-yellow { --kpi-color: #eab308; --kpi-bg: rgba(234,179,8,0.1); }
.kpi-indigo { --kpi-color: #6366f1; --kpi-bg: rgba(99,102,241,0.1); }
.kpi-pink   { --kpi-color: #ec4899; --kpi-bg: rgba(236,72,153,0.1); }
.kpi-cyan   { --kpi-color: #06b6d4; --kpi-bg: rgba(6,182,212,0.1); }

/* Section titles */
.dash-section-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 14px;
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

/* Chart cards */
.chart-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    height: 100%;
}
.chart-card-title {
    font-size: 0.88rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.chart-card-title i {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: rgba(79,124,255,0.1);
    color: #4f7cff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    flex-shrink: 0;
}

/* Table cards */
.table-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    overflow: hidden;
}
.table-card-title {
    font-size: 0.88rem;
    font-weight: 600;
    color: #334155;
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 8px;
}
.table-card-title i {
    color: #4f7cff;
    font-size: 0.85rem;
}
.table-card .table {
    margin-bottom: 0;
    font-size: 0.8rem;
}
.table-card .table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 10px 14px;
    border-bottom: 1px solid #e2e8f0;
    border-top: none;
    white-space: nowrap;
}
.table-card .table tbody td {
    padding: 10px 14px;
    color: #475569;
    border-color: #f1f5f9;
    vertical-align: middle;
}
.table-card .table tbody tr:hover { background: #f8fafc; }
.table-card .table tbody tr:last-child td { border-bottom: none; }

/* Rates card */
.kpi-rate-stars {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 6px;
}
.kpi-rate-stars i { color: #fbbf24; font-size: 0.75rem; }
</style>
@endsection

@section('content')
<div class="container-fluid px-3 py-3">

    {{-- Page Header --}}
    <div class="dash-page-header">
        <div>
            <h1 class="dash-page-title">{{ trans('panel.dashboard') ?? 'Dashboard' }}</h1>
            <div class="dash-page-subtitle">{{ trans('panel.welcome_back') ?? 'Welcome back,' }} {{ Auth::user()->name }}</div>
        </div>
        <div class="dash-date-badge">
            <i class="fas fa-calendar-alt"></i>
            {{ now()->format('D, d M Y') }}
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
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
    @php
        $kpiColors = [
            'blue','green','orange','purple','teal','red','yellow','indigo','pink','cyan',
            'blue','green','orange','purple','teal','red','yellow','indigo'
        ];
        $kpiIcons = [
            'fa-shopping-bag','fa-users','fa-store','fa-truck','fa-star','fa-ticket-alt',
            'fa-money-bill-wave','fa-chart-bar','fa-map-marker-alt','fa-bell',
            'fa-box','fa-user-check','fa-percent','fa-wallet','fa-receipt','fa-comments',
            'fa-th-large','fa-award'
        ];
    @endphp

    <div class="dash-section-title"><i class="fas fa-tachometer-alt" style="color:#4f7cff;"></i>{{ trans('panel.overview') ?? 'Overview' }}</div>

    <div class="kpi-grid">

        @if(Auth::user()->user_type != 3)
        {{-- settings1 --}}
        <div class="kpi-card kpi-{{ $kpiColors[0] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[0] }}"></i></div>
            <div class="kpi-label">{{ $settings1['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings1['total_number']) }}</div>
        </div>
        {{-- settings2 --}}
        <div class="kpi-card kpi-{{ $kpiColors[1] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[1] }}"></i></div>
            <div class="kpi-label">{{ $settings2['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings2['total_number']) }}</div>
        </div>
        @endif

        {{-- settings3 --}}
        <div class="kpi-card kpi-{{ $kpiColors[2] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[2] }}"></i></div>
            <div class="kpi-label">{{ $settings3['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings3['total_number']) }}</div>
        </div>

        {{-- settings4 --}}
        <div class="kpi-card kpi-{{ $kpiColors[3] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[3] }}"></i></div>
            <div class="kpi-label">{{ $settings4['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings4['total_number']) }}</div>
        </div>

        {{-- settings10 --}}
        <div class="kpi-card kpi-{{ $kpiColors[4] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[4] }}"></i></div>
            <div class="kpi-label">{{ $settings10['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings10['total_number']) }}</div>
        </div>

        {{-- settings11 --}}
        <div class="kpi-card kpi-{{ $kpiColors[5] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[5] }}"></i></div>
            <div class="kpi-label">{{ $settings11['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings11['total_number']) }}</div>
        </div>

        {{-- settings12 --}}
        <div class="kpi-card kpi-{{ $kpiColors[6] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[6] }}"></i></div>
            <div class="kpi-label">{{ $settings12['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings12['total_number']) }}</div>
        </div>

        {{-- settings15 --}}
        <div class="kpi-card kpi-{{ $kpiColors[7] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[7] }}"></i></div>
            <div class="kpi-label">{{ $settings15['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings15['total_number']) }}</div>
        </div>

        {{-- settings16 --}}
        <div class="kpi-card kpi-{{ $kpiColors[8] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[8] }}"></i></div>
            <div class="kpi-label">{{ $settings16['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings16['total_number']) }}</div>
        </div>

        {{-- settings17 --}}
        <div class="kpi-card kpi-{{ $kpiColors[9] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[9] }}"></i></div>
            <div class="kpi-label">{{ $settings17['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings17['total_number']) }}</div>
        </div>

        {{-- settings18 --}}
        <div class="kpi-card kpi-{{ $kpiColors[10] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[10] }}"></i></div>
            <div class="kpi-label">{{ $settings18['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings18['total_number']) }}</div>
        </div>

        {{-- Rates (restaurant only) --}}
        @if(Auth::user()->user_type == 3)
        <div class="kpi-card kpi-yellow">
            <div class="kpi-icon-wrap"><i class="fas fa-star"></i></div>
            <div class="kpi-label">{{ trans('cruds.rates') }}</div>
            <div class="kpi-value">{{ number_format(\App\Models\Rate::where('restaurant_id', Auth::id())->avg('rating'), 1) }}</div>
            <div class="kpi-rate-stars">
                @for($s=1; $s<=5; $s++)
                    <i class="fas fa-star" style="color: {{ $s <= round(\App\Models\Rate::where('restaurant_id', Auth::id())->avg('rating')) ? '#fbbf24' : '#e2e8f0' }}"></i>
                @endfor
            </div>
        </div>
        @endif

        {{-- settings19 (admin only) --}}
        @if(Auth::user()->user_type == 1)
        <div class="kpi-card kpi-{{ $kpiColors[11] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[11] }}"></i></div>
            <div class="kpi-label">{{ $settings19['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings19['total_number']) }}</div>
        </div>
        @endif

        {{-- settings24 (restaurant only) --}}
        @if(Auth::user()->user_type == 3)
        <div class="kpi-card kpi-{{ $kpiColors[12] }}">
            <div class="kpi-icon-wrap"><i class="fas {{ $kpiIcons[12] }}"></i></div>
            <div class="kpi-label">{{ $settings24['chart_title'] }}</div>
            <div class="kpi-value">{{ number_format($settings24['total_number']) }}</div>
        </div>
        @endif

    </div>{{-- end kpi-grid --}}

    {{-- ===== CHARTS ===== --}}
    <div class="dash-section-title"><i class="fas fa-chart-area" style="color:#4f7cff;"></i>{{ trans('panel.statistics') ?? 'Statistics' }}</div>

    <div class="row">
        {{-- chart5 --}}
        <div class="{{ $chart5->options['column_class'] }} mb-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="fas fa-chart-line"></i>{!! $chart5->options['chart_title'] !!}</div>
                {!! $chart5->renderHtml() !!}
            </div>
        </div>

        @if(Auth::user()->user_type != 3)
        {{-- chart6 --}}
        <div class="{{ $chart6->options['column_class'] }} mb-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="fas fa-chart-bar"></i>{!! $chart6->options['chart_title'] !!}</div>
                {!! $chart6->renderHtml() !!}
            </div>
        </div>
        {{-- chart7 --}}
        <div class="{{ $chart7->options['column_class'] }} mb-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="fas fa-chart-pie"></i>{!! $chart7->options['chart_title'] !!}</div>
                {!! $chart7->renderHtml() !!}
            </div>
        </div>
        @endif

        {{-- chart17 --}}
        <div class="{{ $chart17->options['column_class'] }} mb-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="fas fa-chart-line"></i>{!! $chart17->options['chart_title'] !!}</div>
                {!! $chart17->renderHtml() !!}
            </div>
        </div>
        {{-- chart18 --}}
        <div class="{{ $chart18->options['column_class'] }} mb-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="fas fa-chart-bar"></i>{!! $chart18->options['chart_title'] !!}</div>
                {!! $chart18->renderHtml() !!}
            </div>
        </div>
        {{-- chart19 --}}
        <div class="{{ $chart19->options['column_class'] }} mb-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="fas fa-chart-pie"></i>{!! $chart19->options['chart_title'] !!}</div>
                {!! $chart19->renderHtml() !!}
            </div>
        </div>
        {{-- chart20 --}}
        <div class="{{ $chart20->options['column_class'] }} mb-4">
            <div class="chart-card">
                <div class="chart-card-title"><i class="fas fa-chart-area"></i>{!! $chart20->options['chart_title'] !!}</div>
                {!! $chart20->renderHtml() !!}
            </div>
        </div>
    </div>

    {{-- ===== LATEST ENTRIES TABLES ===== --}}
    @if(Auth::user()->user_type != 3)
    <div class="dash-section-title"><i class="fas fa-table" style="color:#4f7cff;"></i>{{ trans('panel.latest_entries') ?? 'Latest Entries' }}</div>
    <div class="row">
        {{-- settings8 table --}}
        <div class="{{ $settings8['column_class'] }}">
            <div class="table-card">
                <div class="table-card-title">
                    <i class="fas fa-list-alt"></i>
                    {{ $settings8['chart_title'] }}
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
                                <tr><td colspan="{{ count($settings8['fields']) }}" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox" style="font-size:1.5rem;opacity:0.3;display:block;margin-bottom:6px;"></i>
                                    {{ __('No entries found') }}
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- settings9 table --}}
        <div class="{{ $settings9['column_class'] }}">
            <div class="table-card">
                <div class="table-card-title">
                    <i class="fas fa-list-alt"></i>
                    {{ $settings9['chart_title'] }}
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
                                <tr><td colspan="{{ count($settings9['fields']) }}" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox" style="font-size:1.5rem;opacity:0.3;display:block;margin-bottom:6px;"></i>
                                    {{ __('No entries found') }}
                                </td></tr>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
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
