@extends('layouts.admin')
@section('content')
@can('favorite_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.favorites.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.favorite.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.favorite.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Favorite">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.favorite.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.favorite.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.favorite.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.favorite.fields.item') }}
                        </th>
                        <th>
                            {{ trans('cruds.favorite.fields.restaurant') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($favorites as $key => $favorite)
                        <tr data-entry-id="{{ $favorite->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $favorite->id ?? '' }}
                            </td>
                            <td>
                                {{ $favorite->user->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Favorite::TYPE_SELECT[$favorite->type] ?? '' }}
                            </td>
                            <td>
                                {{ $favorite->item->name ?? '' }}
                            </td>
                            <td>
                                {{ $favorite->restaurant->name_en ?? '' }}
                            </td>
                            <td>
                                @can('favorite_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.favorites.show', $favorite->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('favorite_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.favorites.edit', $favorite->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('favorite_delete')
                                    <form action="{{ route('admin.favorites.destroy', $favorite->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('favorite_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.favorites.massDestroy') }}",
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
  let table = $('.datatable-Favorite:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection