@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.country.title')"
        icon="fas fa-globe"
        color="teal"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.country.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.country.title_singular').' '.trans('global.list')"
        icon="fas fa-globe"
        color="teal"
        datatableClass="datatable-Country"
        :count="$countries->count()"
        :createRoute="route('admin.countries.create')"
        :createLabel="trans('global.add').' '.trans('cruds.country.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.country.fields.name_en') }}</th>
                <th>{{ trans('cruds.country.fields.name_ar') }}</th>
                <th>{{ trans('cruds.country.fields.status') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($countries as $country)
            <tr data-entry-id="{{ $country->id }}">
                <td></td>
                <td>{{ $country->name_en ?? '' }}</td>
                <td>{{ $country->name_ar ?? '' }}</td>
                <td>
                    <x-admin-status-badge
                        :label="$country->status == 1 ? (trans('global.active') ?? 'Active') : (trans('global.inactive') ?? 'Inactive')"
                        :type="$country->status == 1 ? 'success' : 'danger'"
                    />
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('country_show')
                    <x-admin-action-btn href="{{ route('admin.countries.show',$country->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('country_edit')
                    <x-admin-action-btn href="{{ route('admin.countries.edit',$country->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('country_delete')
                    <x-admin-action-btn href="{{ route('admin.countries.destroy',$country->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('country_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.countries.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Country:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
