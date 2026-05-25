@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.restaurant.title')"
        icon="fas fa-utensils"
        color="red"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.restaurant.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.restaurant.title_singular').' '.trans('global.list')"
        icon="fas fa-utensils"
        color="red"
        datatableClass="datatable-Restaurant"
        :count="$restaurants->count()"
        :createRoute="can('restaurant_create') ? route('admin.restaurants.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.restaurant.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.restaurant.fields.name_en') }}</th>
                <th>{{ trans('cruds.restaurant.fields.name_ar') }}</th>
                <th>{{ trans('cruds.restaurant.fields.phone') }}</th>
                <th>{{ trans('cruds.restaurant.fields.status') }}</th>
                <th>{{ trans('cruds.restaurant.fields.city') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($restaurants as $restaurant)
            <tr data-entry-id="{{ $restaurant->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        @if($restaurant->logo)
                            <img src="{{ asset('storage/'.$restaurant->logo) }}" style="width:32px;height:32px;border-radius:8px;object-fit:cover;" alt="" />
                        @else
                            <x-admin-avatar :name="$restaurant->name_en" color="red" />
                        @endif
                        {{ $restaurant->name_en ?? '' }}
                    </span>
                </td>
                <td>{{ $restaurant->name_ar ?? '' }}</td>
                <td>{{ $restaurant->phone ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$restaurant->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$restaurant->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td>{{ optional($restaurant->city)->name_en ?? '' }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('restaurant_show')
                    <x-admin-action-btn href="{{ route('admin.restaurants.show',$restaurant->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('restaurant_edit')
                    <x-admin-action-btn href="{{ route('admin.restaurants.edit',$restaurant->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('restaurant_delete')
                    <x-admin-action-btn href="{{ route('admin.restaurants.destroy',$restaurant->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
                    @endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>

</div>
@endsection
@section('scripts')
@parent
<script>
$(function(){
    let dtButtons=$.extend(true,[],$.fn.dataTable.defaults.buttons);
    @can('restaurant_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.restaurants.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Restaurant:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
