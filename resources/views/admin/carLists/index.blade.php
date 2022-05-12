@extends('layouts.admin')
@section('content')
@can('car_list_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.car-lists.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.carList.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.carList.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CarList">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.carList.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.carList.fields.car_brand') }}
                        </th>
                        <th>
                            {{ trans('cruds.carList.fields.car_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.carList.fields.car_color') }}
                        </th>
                        <th>
                            {{ trans('cruds.carList.fields.pate_number') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carLists as $key => $carList)
                        <tr data-entry-id="{{ $carList->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $carList->id ?? '' }}
                            </td>
                            <td>
                                {{ optional($carList->car_brand)->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ optional($carList->car_type)->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ optional($carList->car_color)->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ $carList->pate_number ?? '' }}
                            </td>
                            <td>
                                @can('car_list_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.car-lists.show', $carList->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('car_list_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.car-lists.edit', $carList->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('car_list_delete')
                                    <form action="{{ route('admin.car-lists.destroy', $carList->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
@can('car_list_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.car-lists.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-CarList:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
