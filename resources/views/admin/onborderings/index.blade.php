@extends('layouts.admin')
@section('content')
@can('onbordering_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.onborderings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.onbordering.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.onbordering.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Onbordering">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.onbordering.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.onbordering.fields.image') }}
                        </th>
                        <th>
                            {{ trans('cruds.onbordering.fields.name_ar') }}
                        </th>
                        <th>
                            {{ trans('cruds.onbordering.fields.name_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.onbordering.fields.type') }}
                        </th>

                        <th>
                            {{ trans('cruds.onbordering.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($onborderings as $key => $onbordering)
                        <tr data-entry-id="{{ $onbordering->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $onbordering->id ?? '' }}
                            </td>
                            <td>
                                @if($onbordering->image)
                                    <a href="{{ url('local/public/img/onbording/' . $onbordering->image) }}" target="_blank">
                                        <img src="{{ url('local/public/img/onbording/' . $onbordering->image) }}" width="50px" height="50px">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $onbordering->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ $onbordering->name_en ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Onbordering::TYPE_SELECT[$onbordering->type] ?? '' }}
                            </td>

                            <td>
                                {{ App\Models\Onbordering::STATUS_SELECT[$onbordering->status] ?? '' }}
                            </td>
                            <td>
                                @can('onbordering_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.onborderings.show', $onbordering->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('onbordering_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.onborderings.edit', $onbordering->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('onbordering_delete')
                                    <form action="{{ route('admin.onborderings.destroy', $onbordering->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('onbordering_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.onborderings.massDestroy') }}",
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
  let table = $('.datatable-Onbordering:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection