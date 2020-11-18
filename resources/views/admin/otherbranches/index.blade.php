@extends('layouts.admin')
@section('content')
@can('otherbranch_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.otherbranches.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.otherbranch.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.otherbranch.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Otherbranch">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.otherbranch.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.otherbranch.fields.restaurants') }}
                        </th>
                        <th>
                            {{ trans('cruds.otherbranch.fields.branch_name_ar') }}
                        </th>
                        <th>
                            {{ trans('cruds.otherbranch.fields.branch_name_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.otherbranch.fields.branch_address_ar') }}
                        </th>
                        <th>
                            {{ trans('cruds.otherbranch.fields.branch_address_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.otherbranch.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.otherbranch.fields.email') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($otherbranches as $key => $otherbranch)
                        <tr data-entry-id="{{ $otherbranch->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $otherbranch->id ?? '' }}
                            </td>
                            <td>
                                {{ $otherbranch->restaurants->name_en ?? '' }}
                            </td>
                            <td>
                                {{ $otherbranch->branch_name_ar ?? '' }}
                            </td>
                            <td>
                                {{ $otherbranch->branch_name_en ?? '' }}
                            </td>
                            <td>
                                {{ $otherbranch->branch_address_ar ?? '' }}
                            </td>
                            <td>
                                {{ $otherbranch->branch_address_en ?? '' }}
                            </td>
                            <td>
                                {{ $otherbranch->phone ?? '' }}
                            </td>
                            <td>
                                {{ $otherbranch->email ?? '' }}
                            </td>
                            <td>
                                @can('otherbranch_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.otherbranches.show', $otherbranch->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('otherbranch_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.otherbranches.edit', $otherbranch->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('otherbranch_delete')
                                    <form action="{{ route('admin.otherbranches.destroy', $otherbranch->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('otherbranch_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.otherbranches.massDestroy') }}",
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
  let table = $('.datatable-Otherbranch:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection