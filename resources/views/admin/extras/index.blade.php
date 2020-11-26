@extends('layouts.admin')
@section('content')
@can('extra_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.extras.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.extra.title_singular') }}
            </a>
        </div>
    </div>

@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.extra.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Extra">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.extra.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.extra.fields.name_ar') }}
                        </th>
                        <th>
                            {{ trans('cruds.extra.fields.name_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.extra.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.extra.fields.item') }}
                        </th>
                        <th>
                            {{ trans('cruds.extra.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($extras as $key => $extra)
                        <tr data-entry-id="{{ $extra->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $extra->id ?? '' }}
                            </td>
                            <td>
                                {{ $extra->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ $extra->name_en ?? '' }}
                            </td>
                            <td>
                                {{ $extra->price ?? '' }}
                            </td>
                            <td>
                                {{ $extra->item->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Extra::STATUS_SELECT[$extra->status] ?? '' }}
                            </td>
                            <td>
                                @can('extra_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.extras.show', $extra->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('extra_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.extras.edit', $extra->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('extra_delete')
                                    <form action="{{ route('admin.extras.destroy', $extra->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('extra_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.extras.massDestroy') }}",
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
  let table = $('.datatable-Extra:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection