@extends('layouts.admin')
@section('content')
@can('referral_subscription_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.referral-subscriptions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.referralSubscription.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.referralSubscription.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ReferralSubscription">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.referralSubscription.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.referralSubscription.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.referralSubscription.fields.user_loop') }}
                        </th>
                        <th>
                            {{ trans('cruds.referralSubscription.fields.plan') }}
                        </th>
                        <th>
                            {{ trans('cruds.referralSubscription.fields.price') }}
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
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($restaurant as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($users as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach($subscription_packages as $key => $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($referralSubscriptions as $key => $referralSubscription)
                        <tr data-entry-id="{{ $referralSubscription->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $referralSubscription->id ?? '' }}
                            </td>
                            <td>
                                {{ $referralSubscription->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $referralSubscription->user_loop->name ?? '' }}
                            </td>
                            <td>
                                {{ $referralSubscription->plan->name ?? '' }}
                            </td>
                            <td>
                                {{ $referralSubscription->price ?? '' }}
                            </td>
                            <td>
                                @can('referral_subscription_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.referral-subscriptions.show', $referralSubscription->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('referral_subscription_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.referral-subscriptions.edit', $referralSubscription->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('referral_subscription_delete')
                                    <form action="{{ route('admin.referral-subscriptions.destroy', $referralSubscription->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('referral_subscription_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.referral-subscriptions.massDestroy') }}",
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
  let table = $('.datatable-ReferralSubscription:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection
