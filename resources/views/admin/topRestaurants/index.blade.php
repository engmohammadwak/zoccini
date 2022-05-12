@extends('layouts.admin')
@section('content')
@can('top_restaurant_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.top-restaurants.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.topRestaurant.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.topRestaurant.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-TopRestaurant">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.body') }}
                        </th>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.topRestaurant.fields.image') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topRestaurants as $key => $topRestaurant)
                        <tr data-entry-id="{{ $topRestaurant->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $topRestaurant->id ?? '' }}
                            </td>
                            <td>
                                {{ $topRestaurant->title ?? '' }}
                            </td>
                            <td>
                                {{ $topRestaurant->body ?? '' }}
                            </td>
                            <td>
                                {{ $topRestaurant->category->name ?? '' }}
                            </td>
                            <td>
                                @if($topRestaurant->image)
                                    <a href="{{$topRestaurant->image_url}}" target="_blank" style="display: inline-block">
                                        <img height="50" width="50" src="{{$topRestaurant->image_url}}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('top_restaurant_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.top-restaurants.show', $topRestaurant->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('top_restaurant_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.top-restaurants.edit', $topRestaurant->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('top_restaurant_delete')
                                    <form action="{{ route('admin.top-restaurants.destroy', $topRestaurant->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('top_restaurant_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.top-restaurants.massDestroy') }}",
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
  let table = $('.datatable-TopRestaurant:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection