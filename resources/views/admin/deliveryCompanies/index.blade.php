@extends('layouts.admin')
@section('content')
@can('delivery_company_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.delivery-companies.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.deliveryCompany.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.deliveryCompany.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-DeliveryCompany">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.name_ar') }}
                        </th>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.name_en') }}
                        </th>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.rate') }}
                        </th>
                        <th>
                            {{ trans('cruds.deliveryCompany.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryCompanies as $key => $deliveryCompany)
                        <tr data-entry-id="{{ $deliveryCompany->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $deliveryCompany->id ?? '' }}
                            </td>
                            <td>
                                {{ $deliveryCompany->name_ar ?? '' }}
                            </td>
                            <td>
                                {{ $deliveryCompany->name_en ?? '' }}
                            </td>
                            <td>
                                {{ $deliveryCompany->rate ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\DeliveryCompany::STATUS_SELECT[$deliveryCompany->status] ?? '' }}
                            </td>
                            <td>
                                @can('delivery_company_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.delivery-companies.show', $deliveryCompany->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('delivery_company_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.delivery-companies.edit', $deliveryCompany->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('delivery_company_delete')
                                    <form action="{{ route('admin.delivery-companies.destroy', $deliveryCompany->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('delivery_company_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.delivery-companies.massDestroy') }}",
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
  let table = $('.datatable-DeliveryCompany:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection