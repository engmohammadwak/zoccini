@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.city.title')"
        icon="fas fa-city"
        color="cyan"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.city.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.city.title_singular').' '.trans('global.list')"
        icon="fas fa-city"
        color="cyan"
        datatableClass="datatable-City"
        :count="$cities->count()"
        :createRoute="route('admin.cities.create')"
        :createLabel="trans('global.add').' '.trans('cruds.city.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.city.fields.name_en') }}</th>
                <th>{{ trans('cruds.city.fields.name_ar') }}</th>
                <th>{{ trans('cruds.city.fields.country') }}</th>
                <th>{{ trans('cruds.city.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($cities as $city)
            <tr data-entry-id="{{ $city->id }}">
                <td></td>
                <td>{{ $city->name_en ?? '' }}</td>
                <td>{{ $city->name_ar ?? '' }}</td>
                <td>{{ optional($city->country)->name_en ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$city->status == 1 ? trans('global.active') ?? 'Active' : trans('global.inactive') ?? 'Inactive'"
                        :type="$city->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('city_show')
                    <x-admin-action-btn href="{{ route('admin.cities.show',$city->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('city_edit')
                    <x-admin-action-btn href="{{ route('admin.cities.edit',$city->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('city_delete')
                    <x-admin-action-btn href="{{ route('admin.cities.destroy',$city->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('city_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.cities.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-City:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
