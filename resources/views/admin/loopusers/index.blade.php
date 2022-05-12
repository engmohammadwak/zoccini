@extends('layouts.admin')
@section('content')
    @can('loopuser_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.loopusers.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.loopuser.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.loopuser.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.full_name') }}
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($loopusers as $key => $value)
                        <tr data-entry-id="{{ $value->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $value->user->id ?? '' }}
                            </td>
                            <td>
                                {{ optional($value->user)->name .' '. optional($value->user)->last_name  }}
                            </td>
                            <td>
                                {{ optional($value->user)->phone ?? '' }}
                            </td>

                            <td>
                                @can('loopuser_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.loopusers.show', $value->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('loopuser_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.loopusers.edit', $value->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @if (request()->get('type'))
                                    <a class="btn btn-xs btn-success"
                                       href="{{ route('admin.loopusers.active', $value->id) }}">
                                        {{ trans('global.active') }}
                                    </a>
                                @endif
                                @can('loopuser_delete')
                                    <form action="{{ route('admin.loopusers.destroy', $value->id) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-User:not(.ajaxTable)').DataTable({buttons: dtButtons})
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
