@extends('layouts.admin')
@section('content')
    @can('restaurant_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.restaurants.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.restaurant.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.restaurant.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Restaurant">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.restaurant.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurant.fields.name_ar') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurant.fields.name_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.phone') }}
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
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>

                        <td>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($restaurants as $key => $restaurant)
                        <tr data-entry-id="{{ $restaurant->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $restaurant->id ?? '' }}
                            </td>
                            <td>
                                {{ $restaurant->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ $restaurant->name_en ?? '' }}
                            </td>
                            <td>
                                {{ $restaurant->restaurant->phone ?? '' }}
                            </td>
                            <td>
                                @can('restaurant_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.restaurants.show', $restaurant->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @if (request()->get('type'))
                                        <a class="btn btn-xs btn-success"
                                           href="{{ route('admin.restaurants.active', $restaurant->id) }}">
                                            {{ trans('global.active') }}
                                        </a>
                                @else
                                    @can('restaurant_edit')
                                        <a class="btn btn-xs btn-info"
                                           href="{{ route('admin.restaurants.edit', $restaurant->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    <a class="btn btn-xs btn-success"
                                       href="{{ route('admin.restaurants.restaurant_order', $restaurant->id) }}">
                                        {{ trans('global.order_user') }}
                                    </a>
                                @endif

                                @can('restaurant_delete')
                                    <form action="{{ route('admin.restaurants.destroy', $restaurant->id) }}"
                                          method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                               value="{{ trans('global.delete') }}">
                                    </form>
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
            @can('restaurant_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.restaurants.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-Restaurant:not(.ajaxTable)').DataTable({buttons: dtButtons})
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
