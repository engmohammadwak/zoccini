@extends('layouts.admin')
@section('content')

<style>
/* ── Restaurants Page ── */
.rest-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}
.rest-page-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #1a1f2e;
    display: flex;
    align-items: center;
    gap: 10px;
}
.rest-page-title .title-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1rem;
    box-shadow: 0 4px 12px rgba(255,107,53,0.35);
}
.rest-add-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px;
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    color: #fff !important;
    border-radius: 9px;
    font-size: 0.85rem; font-weight: 600;
    text-decoration: none;
    box-shadow: 0 3px 10px rgba(255,107,53,0.3);
    transition: opacity 0.2s, transform 0.15s;
    border: none;
}
.rest-add-btn:hover {
    opacity: 0.88; transform: translateY(-1px);
    color: #fff !important; text-decoration: none;
}

.rest-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e8ecf4;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
}
.rest-card-header {
    background: linear-gradient(135deg, #fff8f5 0%, #fff3ee 100%);
    border-bottom: 1px solid #ffe5d9;
    padding: 16px 20px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
}
.rest-card-header-title {
    font-size: 0.92rem; font-weight: 700; color: #1a1f2e;
    display: flex; align-items: center; gap: 8px;
}
.rest-card-header-title i { color: #ff6b35; }
.rest-card-body { padding: 20px; }

/* Table */
.rest-table-wrap {
    overflow-x: auto;
    border-radius: 10px;
    border: 1px solid #eef0f8;
}
.rest-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.84rem;
}
.rest-table thead tr:first-child th {
    background: #fff8f5;
    color: #5a4030;
    font-weight: 700;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
    border-bottom: 2px solid #ffe5d9;
    white-space: nowrap;
}
.rest-table thead tr:nth-child(2) td {
    background: #fffaf8;
    padding: 8px 10px;
    border-bottom: 1px solid #ffe5d9;
}
.rest-table thead tr:nth-child(2) input {
    width: 100%;
    border: 1px solid #ffd0bb;
    border-radius: 7px;
    padding: 5px 8px;
    font-size: 0.78rem;
    color: #5a4030;
    background: #fff;
    outline: none;
    transition: border-color 0.2s;
}
.rest-table thead tr:nth-child(2) input:focus {
    border-color: #ff6b35;
    box-shadow: 0 0 0 3px rgba(255,107,53,0.1);
}
.rest-table tbody tr {
    border-bottom: 1px solid #f5f0ee;
    transition: background 0.15s;
}
.rest-table tbody tr:last-child { border-bottom: none; }
.rest-table tbody tr:hover { background: #fff8f5; }
.rest-table tbody td {
    padding: 13px 14px;
    color: #2d3250;
    vertical-align: middle;
}

/* Restaurant name cell */
.rest-name-cell {
    display: flex; align-items: center; gap: 10px;
}
.rest-avatar {
    width: 34px; height: 34px;
    border-radius: 9px;
    background: linear-gradient(135deg, #ff6b35, #f7931e);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 0.78rem; font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 2px 6px rgba(255,107,53,0.3);
}
.rest-name-text {
    font-weight: 600;
    color: #1a1f2e;
    font-size: 0.85rem;
}
.rest-name-sub {
    font-size: 0.74rem;
    color: #9aa0c0;
}

/* ID badge */
.rest-id-badge {
    display: inline-flex;
    align-items: center; justify-content: center;
    background: #fff0e8;
    color: #e05a1a;
    font-weight: 700; font-size: 0.8rem;
    border-radius: 7px;
    padding: 3px 10px;
    min-width: 38px;
}

/* Phone */
.rest-phone {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.82rem; color: #4a5080;
}

/* Action buttons */
.rest-actions { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.btn-rest-view {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 10px;
    background: linear-gradient(135deg, #4f7cff, #7c4fff);
    color: #fff !important; border-radius: 7px;
    font-size: 0.75rem; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    box-shadow: 0 2px 6px rgba(79,124,255,0.25);
    transition: opacity 0.2s, transform 0.15s;
}
.btn-rest-edit {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 10px;
    background: linear-gradient(135deg, #17c3b2, #06b89a);
    color: #fff !important; border-radius: 7px;
    font-size: 0.75rem; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    box-shadow: 0 2px 6px rgba(23,195,178,0.25);
    transition: opacity 0.2s, transform 0.15s;
}
.btn-rest-orders {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 10px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff !important; border-radius: 7px;
    font-size: 0.75rem; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    box-shadow: 0 2px 6px rgba(34,197,94,0.25);
    transition: opacity 0.2s, transform 0.15s;
}
.btn-rest-active {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 10px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff !important; border-radius: 7px;
    font-size: 0.75rem; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    box-shadow: 0 2px 6px rgba(245,158,11,0.25);
    transition: opacity 0.2s, transform 0.15s;
}
.btn-rest-delete {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 10px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff !important; border-radius: 7px;
    font-size: 0.75rem; font-weight: 600;
    text-decoration: none; border: none; cursor: pointer;
    box-shadow: 0 2px 6px rgba(239,68,68,0.25);
    transition: opacity 0.2s, transform 0.15s;
}
.btn-rest-view:hover, .btn-rest-edit:hover, .btn-rest-orders:hover,
.btn-rest-active:hover, .btn-rest-delete:hover {
    opacity: 0.85; transform: translateY(-1px);
    color: #fff !important; text-decoration: none;
}

/* DataTables */
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #ffd0bb !important;
    border-radius: 8px !important;
    padding: 6px 12px !important;
    font-size: 0.83rem !important;
}
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #ff6b35 !important;
    box-shadow: 0 0 0 3px rgba(255,107,53,0.12) !important;
    outline: none !important;
}
.dataTables_wrapper .dataTables_length select {
    border: 1px solid #ffd0bb !important;
    border-radius: 8px !important;
    padding: 4px 8px !important;
    font-size: 0.83rem !important;
}
.dataTables_wrapper .paginate_button.current,
.dataTables_wrapper .paginate_button.current:hover {
    background: linear-gradient(135deg, #ff6b35, #f7931e) !important;
    color: #fff !important; border: none !important;
    border-radius: 7px !important;
}
</style>

<div class="content-wrapper" style="background:#f4f6fb; min-height:100vh; padding:24px;">

    {{-- Page Header --}}
    <div class="rest-page-header">
        <div class="rest-page-title">
            <div class="title-icon"><i class="fas fa-store"></i></div>
            {{ trans('cruds.restaurant.title') }}
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
            <nav aria-label="breadcrumb" style="font-size:0.8rem;">
                <ol class="breadcrumb mb-0" style="background:transparent;padding:0;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}" style="color:#ff6b35;">{{ trans('global.dashboard') }}</a></li>
                    <li class="breadcrumb-item active" style="color:#7a80a0;">{{ trans('cruds.restaurant.title') }}</li>
                </ol>
            </nav>
            @can('restaurant_create')
                <a class="rest-add-btn" href="{{ route('admin.restaurants.create') }}">
                    <i class="fas fa-plus"></i>
                    {{ trans('global.add') }} {{ trans('cruds.restaurant.title_singular') }}
                </a>
            @endcan
        </div>
    </div>

    {{-- Main Card --}}
    <div class="rest-card">
        <div class="rest-card-header">
            <div class="rest-card-header-title">
                <i class="fas fa-utensils"></i>
                {{ trans('cruds.restaurant.title_singular') }} {{ trans('global.list') }}
                <span style="background:#fff0e8;color:#e05a1a;font-size:0.72rem;font-weight:700;padding:2px 10px;border-radius:20px;margin-inline-start:4px;">
                    {{ $restaurants->count() }}
                </span>
            </div>
            <span style="font-size:0.78rem;color:#c08060;">
                <i class="fas fa-sync-alt" style="margin-left:4px;"></i>
                {{ now()->translatedFormat('d/m/Y H:i') }}
            </span>
        </div>

        <div class="rest-card-body">
            <div class="rest-table-wrap">
                <table class="rest-table table datatable datatable-Restaurant">
                    <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.restaurant.fields.id') }}</th>
                        <th>{{ trans('cruds.restaurant.fields.name_ar') }}</th>
                        <th>{{ trans('cruds.restaurant.fields.name_en') }}</th>
                        <th>{{ trans('cruds.user.fields.phone') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($restaurants as $restaurant)
                        <tr data-entry-id="{{ $restaurant->id }}">
                            <td></td>
                            <td>
                                <span class="rest-id-badge">#{{ $restaurant->id }}</span>
                            </td>
                            <td>
                                <div class="rest-name-cell">
                                    <div class="rest-avatar">
                                        {{ strtoupper(mb_substr($restaurant->name_ar ?? 'R', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="rest-name-text">{{ $restaurant->name_ar ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="rest-name-sub" style="font-size:0.83rem;color:#4a5080;font-weight:500;">
                                    {{ $restaurant->name_en ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="rest-phone">
                                    <i class="fas fa-phone" style="color:#ff6b35;font-size:0.72rem;"></i>
                                    {{ $restaurant->restaurant->phone ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <div class="rest-actions">
                                    @can('restaurant_show')
                                        <a class="btn-rest-view" href="{{ route('admin.restaurants.show', $restaurant->id) }}">
                                            <i class="fas fa-eye"></i> {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @if(request()->get('type'))
                                        <a class="btn-rest-active" href="{{ route('admin.restaurants.active', $restaurant->id) }}">
                                            <i class="fas fa-check-circle"></i> {{ trans('global.active') }}
                                        </a>
                                    @else
                                        @can('restaurant_edit')
                                            <a class="btn-rest-edit" href="{{ route('admin.restaurants.edit', $restaurant->id) }}">
                                                <i class="fas fa-edit"></i> {{ trans('global.edit') }}
                                            </a>
                                        @endcan
                                        <a class="btn-rest-orders" href="{{ route('admin.restaurants.restaurant_order', $restaurant->id) }}">
                                            <i class="fas fa-shopping-bag"></i> {{ trans('global.order_user') }}
                                        </a>
                                    @endif

                                    @can('restaurant_delete')
                                        <form action="{{ route('admin.restaurants.destroy', $restaurant->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                              style="display:inline-block;margin:0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-rest-delete">
                                                <i class="fas fa-trash-alt"></i> {{ trans('global.delete') }}
                                            </button>
                                        </form>
                                    @endcan
                                </div>
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

            @can('restaurant_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.restaurants.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id');
                    });
                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}');
                        return;
                    }
                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        }).done(function () { location.reload(); });
                    }
                }
            };
            dtButtons.push(deleteButton);
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-Restaurant:not(.ajaxTable)').DataTable({ buttons: dtButtons });
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false;
                let value  = strict && this.value ? '^' + this.value + '$' : this.value;
                table.column($(this).parent().index()).search(value, strict).draw();
            });
        });
    </script>
@endsection
