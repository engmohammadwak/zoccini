@extends('layouts.admin')
@section('content')

<style>
/* ── Orders Page ── */
.orders-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}
.orders-page-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #1a1f2e;
    display: flex;
    align-items: center;
    gap: 10px;
}
.orders-page-title .title-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #4f7cff 0%, #7c4fff 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(79,124,255,0.3);
}
.orders-stats-row {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.orders-stat-chip {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1px solid #e8ecf4;
    border-radius: 10px;
    padding: 8px 16px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #3a4060;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.orders-stat-chip .chip-dot {
    width: 8px; height: 8px; border-radius: 50%;
}
.orders-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e8ecf4;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
}
.orders-card-header {
    background: linear-gradient(135deg, #f7f9ff 0%, #f0f4ff 100%);
    border-bottom: 1px solid #e8ecf4;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
}
.orders-card-header-title {
    font-size: 0.92rem;
    font-weight: 700;
    color: #1a1f2e;
    display: flex;
    align-items: center;
    gap: 8px;
}
.orders-card-header-title i {
    color: #4f7cff;
}
.orders-card-body {
    padding: 20px;
}

/* Table */
.orders-table-wrap {
    overflow-x: auto;
    border-radius: 10px;
    border: 1px solid #eef0f8;
}
.orders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.84rem;
}
.orders-table thead tr:first-child th {
    background: #f5f7ff;
    color: #4a5080;
    font-weight: 700;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
    border-bottom: 2px solid #e2e7f4;
    white-space: nowrap;
}
.orders-table thead tr:nth-child(2) td {
    background: #fafbff;
    padding: 8px 10px;
    border-bottom: 1px solid #e8ecf4;
}
.orders-table thead tr:nth-child(2) select {
    width: 100%;
    border: 1px solid #dde2f0;
    border-radius: 7px;
    padding: 5px 8px;
    font-size: 0.78rem;
    color: #4a5080;
    background: #fff;
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s;
}
.orders-table thead tr:nth-child(2) select:focus {
    border-color: #4f7cff;
    box-shadow: 0 0 0 3px rgba(79,124,255,0.1);
}
.orders-table tbody tr {
    border-bottom: 1px solid #f0f2fa;
    transition: background 0.15s;
}
.orders-table tbody tr:last-child { border-bottom: none; }
.orders-table tbody tr:hover { background: #f7f9ff; }
.orders-table tbody td {
    padding: 13px 14px;
    color: #2d3250;
    vertical-align: middle;
}

/* Order ID badge */
.order-id-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #eef1ff;
    color: #4f7cff;
    font-weight: 700;
    font-size: 0.8rem;
    border-radius: 7px;
    padding: 3px 10px;
    min-width: 42px;
}

/* Price */
.order-price {
    font-weight: 700;
    color: #1a7a40;
    font-size: 0.88rem;
}

/* Date */
.order-date {
    color: #7a80a0;
    font-size: 0.8rem;
    white-space: nowrap;
}

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}
.status-badge::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: currentColor;
    opacity: 0.7;
}
/* Map status colors by common names */
.status-new      { background: #e8f4ff; color: #1a6fc4; }
.status-pending  { background: #fff8e6; color: #c47f00; }
.status-progress { background: #e6f0ff; color: #3a6fd8; }
.status-ready    { background: #e6faf0; color: #1a7a40; }
.status-delivery { background: #f0e6ff; color: #7c3aed; }
.status-done     { background: #d4f5e2; color: #0d6b35; }
.status-cancel   { background: #ffe6e6; color: #c42b2b; }
.status-default  { background: #f0f2fa; color: #4a5080; }

/* Action btn */
.btn-view-order {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    background: linear-gradient(135deg, #4f7cff, #7c4fff);
    color: #fff !important;
    border-radius: 7px;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s, transform 0.15s;
    border: none;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(79,124,255,0.25);
}
.btn-view-order:hover {
    opacity: 0.88;
    transform: translateY(-1px);
    color: #fff !important;
    text-decoration: none;
}

/* DataTables overrides */
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #dde2f0 !important;
    border-radius: 8px !important;
    padding: 6px 12px !important;
    font-size: 0.83rem !important;
    outline: none !important;
}
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #4f7cff !important;
    box-shadow: 0 0 0 3px rgba(79,124,255,0.12) !important;
}
.dataTables_wrapper .dataTables_length select {
    border: 1px solid #dde2f0 !important;
    border-radius: 8px !important;
    padding: 4px 8px !important;
    font-size: 0.83rem !important;
}
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    font-size: 0.82rem !important;
    margin-top: 14px !important;
    color: #7a80a0 !important;
}
.dataTables_wrapper .paginate_button {
    border-radius: 7px !important;
    font-size: 0.8rem !important;
}
.dataTables_wrapper .paginate_button.current,
.dataTables_wrapper .paginate_button.current:hover {
    background: linear-gradient(135deg, #4f7cff, #7c4fff) !important;
    color: #fff !important;
    border: none !important;
}
</style>

<div class="content-wrapper" style="background:#f4f6fb; min-height:100vh; padding:24px;">

    {{-- Page Header --}}
    <div class="orders-page-header">
        <div class="orders-page-title">
            <div class="title-icon"><i class="fas fa-receipt"></i></div>
            {{ trans('cruds.order.title') }}
        </div>
        <nav aria-label="breadcrumb" style="font-size:0.8rem;">
            <ol class="breadcrumb mb-0" style="background:transparent;padding:0;">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}" style="color:#4f7cff;">{{ trans('global.dashboard') }}</a></li>
                <li class="breadcrumb-item active" style="color:#7a80a0;">{{ trans('cruds.order.title') }}</li>
            </ol>
        </nav>
    </div>

    {{-- Stats chips --}}
    <div class="orders-stats-row">
        <div class="orders-stat-chip">
            <div class="chip-dot" style="background:#4f7cff;"></div>
            {{ trans('global.total') ?? 'Total' }}: <strong>{{ $orders->count() }}</strong>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="orders-card">
        <div class="orders-card-header">
            <div class="orders-card-header-title">
                <i class="fas fa-list-alt"></i>
                {{ trans('cruds.order.title_singular') }} {{ trans('global.list') }}
            </div>
            <span style="font-size:0.78rem;color:#9aa0c0;">
                <i class="fas fa-sync-alt" style="margin-left:4px;"></i>
                {{ now()->translatedFormat('d/m/Y H:i') }}
            </span>
        </div>

        <div class="orders-card-body">
            <div class="orders-table-wrap">
                <table class="orders-table table datatable datatable-Order">
                    <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.order.fields.id') }}</th>
                        @if (Auth::user()['user_type'] != 3)
                            <th>{{ trans('cruds.order.fields.restaurants') }}</th>
                        @endif
                        <th>{{ trans('cruds.order.fields.user') }}</th>
                        <th>{{ trans('cruds.order.fields.final_price') }}</th>
                        <th>{{ trans('cruds.order.fields.created_at') }}</th>
                        <th>{{ trans('cruds.order.fields.status') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        @if (Auth::user()['user_type'] != 3)
                            <td>
                                <select class="search">
                                    <option value>{{ trans('global.all') }}</option>
                                    @foreach($restaurants as $item)
                                        <option value="{{ App::getLocale() == 'ar' ? $item->name_ar : $item->name_en }}">
                                            {{ App::getLocale() == 'ar' ? $item->name_ar : $item->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        @endif
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($users as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($order_statuses as $item)
                                    <option value="{{ App::getLocale() == 'ar' ? $item->name_ar : $item->name_en }}">
                                        {{ App::getLocale() == 'ar' ? $item->name_ar : $item->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        @php
                            $statusName = App::getLocale() == 'ar'
                                ? optional($order->status)->name_ar
                                : optional($order->status)->name_en;
                            $statusId   = optional($order->status)->id ?? 0;
                            // Map status IDs to CSS classes (adjust IDs to match your DB)
                            $statusClass = match(true) {
                                $statusId == 1  => 'status-new',
                                $statusId == 2  => 'status-pending',
                                $statusId == 3  => 'status-progress',
                                $statusId == 4  => 'status-ready',
                                $statusId == 5  => 'status-delivery',
                                $statusId == 6  => 'status-done',
                                $statusId == 7  => 'status-cancel',
                                default         => 'status-default',
                            };
                        @endphp
                        <tr data-entry-id="{{ $order->id }}">
                            <td></td>
                            <td>
                                <span class="order-id-badge">#{{ $order->id }}</span>
                            </td>
                            @if (Auth::user()['user_type'] != 3)
                                <td>
                                    <span style="display:flex;align-items:center;gap:6px;">
                                        <i class="fas fa-utensils" style="color:#4f7cff;font-size:0.75rem;"></i>
                                        {{ App::getLocale() == 'ar' ? optional($order->restaurants)->name_ar : optional($order->restaurants)->name_en ?? '—' }}
                                    </span>
                                </td>
                            @endif
                            <td>
                                <span style="display:flex;align-items:center;gap:6px;">
                                    <span style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#4f7cff,#7c4fff);display:inline-flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:700;flex-shrink:0;">
                                        {{ strtoupper(substr(optional($order->user)->name ?? 'U', 0, 1)) }}
                                    </span>
                                    {{ optional($order->user)->name ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="order-price">
                                    {{ number_format($order->final_price, 2) }}
                                </span>
                            </td>
                            <td>
                                <span class="order-date">
                                    <i class="far fa-clock" style="margin-left:3px;"></i>
                                    {{ $order->created_at->translatedFormat('d/m/Y h:i A') ?? '' }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $statusName ?? '—' }}
                                </span>
                            </td>
                            <td>
                                @can('order_show')
                                    <a class="btn-view-order" href="{{ route('admin.orders.show', $order->id) }}">
                                        <i class="fas fa-eye"></i>
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-Order:not(.ajaxTable)').DataTable({ buttons: dtButtons });
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? "^" + this.value + "$" : this.value;
                table.column($(this).parent().index()).search(value, strict).draw();
            });
        });
    </script>
@endsection
