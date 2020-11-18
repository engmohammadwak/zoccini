@extends('layouts.admin')
@section('content')
@can('point_type_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.point-types.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pointType.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.pointType.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-PointType">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.pointType.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.pointType.fields.name_ar') }}
                        </th>
                        <th>
                            {{ trans('cruds.pointType.fields.name_en') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pointTypes as $key => $pointType)
                        <tr data-entry-id="{{ $pointType->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $pointType->id ?? '' }}
                            </td>
                            <td>
                                {{ $pointType->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ $pointType->name_en ?? '' }}
                            </td>
                            <td>
                                @can('point_type_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.point-types.show', $pointType->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('point_type_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.point-types.edit', $pointType->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('point_type_delete')
                                    <form action="{{ route('admin.point-types.destroy', $pointType->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('point_type_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.point-types.massDestroy') }}",
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
  let table = $('.datatable-PointType:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection