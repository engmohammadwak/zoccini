@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.reporting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Reporting">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.reporting.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.reporting.fields.restaurant') }}
                        </th>
                        <th>
                            {{ trans('cruds.reporting.fields.message') }}
                        </th>
                        <th>
                            {{ trans('cruds.reporting.fields.user') }}
                        </th>
{{--                        <th>--}}
{{--                            {{ trans('cruds.reporting.fields.type') }}--}}
{{--                        </th>--}}
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportings as $key => $reporting)
                        <tr data-entry-id="{{ $reporting->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $reporting->id ?? '' }}
                            </td>
                            <td>
                                {{ $reporting->restaurant->name ?? '' }}
                            </td>
                            <td>
                                {{ $reporting->message ?? '' }}
                            </td>
                            <td>
                                {{ $reporting->user->name ?? '' }}
                            </td>
{{--                            <td>--}}
{{--                                {{ App\Models\Reporting::TYPE_SELECT[$reporting->type] ?? '' }}--}}
{{--                            </td>--}}
                            <td>
                                @can('reporting_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.reportings.show', $reporting->id) }}">
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
@can('reporting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.reportings.massDestroy') }}",
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
  let table = $('.datatable-Reporting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection