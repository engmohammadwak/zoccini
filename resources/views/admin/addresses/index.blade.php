@extends('layouts.admin')
@section('content')
@can('address_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.addresses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.address.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.address.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Address">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.address.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.nice_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.area') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.street') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.building') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.floor') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.apartment_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.additional_direction') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.landing_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.lat') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.lang') }}
                        </th>
                        <th>
                            {{ trans('cruds.address.fields.main_address') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addresses as $key => $address)
                        <tr data-entry-id="{{ $address->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $address->id ?? '' }}
                            </td>
                            <td>
                                {{ $address->nice_name ?? '' }}
                            </td>
                            <td>
                                {{ $address->area ?? '' }}
                            </td>
                            <td>
                                {{ $address->street ?? '' }}
                            </td>
                            <td>
                                {{ $address->building ?? '' }}
                            </td>
                            <td>
                                {{ $address->floor ?? '' }}
                            </td>
                            <td>
                                {{ $address->apartment_no ?? '' }}
                            </td>
                            <td>
                                {{ $address->additional_direction ?? '' }}
                            </td>
                            <td>
                                {{ $address->landing_number ?? '' }}
                            </td>
                            <td>
                                {{ $address->phone ?? '' }}
                            </td>
                            <td>
                                {{ $address->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $address->lat ?? '' }}
                            </td>
                            <td>
                                {{ $address->lang ?? '' }}
                            </td>
                            <td>
                                {{ $address->main_address ?? '' }}
                            </td>
                            <td>
                                @can('address_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.addresses.show', $address->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('address_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.addresses.edit', $address->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('address_delete')
                                    <form action="{{ route('admin.addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('address_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.addresses.massDestroy') }}",
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
  let table = $('.datatable-Address:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection