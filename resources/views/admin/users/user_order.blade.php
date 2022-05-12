@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.order.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Order">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.order.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.restaurants') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.final_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.created_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($restaurants as $key => $item)
                                    <option value="{{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $item->name_ar : $item->name_en }}">{{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $item->name_ar : $item->name_en }}</option>
                                @endforeach
                            </select>
                        </td>

                        <td></td>
                        <td></td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($order_statuses as $key => $item)
                                    <option value="{{ $item->name_en }}">{{ $item->name_en }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key => $order)
                        <tr data-entry-id="{{ $order->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $order->id ?? '' }}
                            </td>

                            <td>
                                {{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $order->restaurants->name_ar : $order->restaurants->name_en ?? '' }}
                            </td>

                            <td>
                                {{ $order->final_price ?? '' }}
                            </td>
                            <td>
                                {{ $order->created_at->translatedFormat('d/m/Y  h:i A') ?? '' }}
                            </td>

                            <td>
                                {{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $order->status->name_ar : $order->status->name_en ?? '' }}

                            </td>
                            <td>
                                @can('order_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.orders.show', $order->id) }}">
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



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-Order:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
        })

    </script>
@endsection