@extends('layouts.admin')
@section('content')
@can('subscription_vip_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.subscription-vips.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.subscriptionVip.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.subscriptionVip.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SubscriptionVip">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.start_day') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.end_day') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.subscriptionVip.fields.price') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptionVips as $key => $subscriptionVip)
                        <tr data-entry-id="{{ $subscriptionVip->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $subscriptionVip->id ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionVip->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionVip->start_day ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionVip->end_day ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\SubscriptionVip::STATUS_SELECT[$subscriptionVip->status] ?? '' }}
                            </td>
                            <td>
                                {{ $subscriptionVip->price ?? '' }}
                            </td>
                            <td>
                                @can('subscription_vip_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.subscription-vips.show', $subscriptionVip->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('subscription_vip_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.subscription-vips.edit', $subscriptionVip->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('subscription_vip_delete')
                                    <form action="{{ route('admin.subscription-vips.destroy', $subscriptionVip->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('subscription_vip_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.subscription-vips.massDestroy') }}",
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
  let table = $('.datatable-SubscriptionVip:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection