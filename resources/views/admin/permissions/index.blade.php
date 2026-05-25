@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.permission.title')"
        icon="fas fa-lock"
        color="purple"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.permission.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.permission.title_singular').' '.trans('global.list')"
        icon="fas fa-lock"
        color="purple"
        datatableClass="datatable-Permission"
        :count="$permissions->count()"
        :createRoute="route('admin.permissions.create')"
        :createLabel="trans('global.add').' '.trans('cruds.permission.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.permission.fields.id') }}</th>
                <th>{{ trans('cruds.permission.fields.title') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($permissions as $permission)
            <tr data-entry-id="{{ $permission->id }}">
                <td></td>
                <td><span style="background:#f3e8ff;color:#7c3aed;padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.8rem;">#{{ $permission->id }}</span></td>
                <td>{{ $permission->title ?? '' }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('permission_show')
                    <x-admin-action-btn href="{{ route('admin.permissions.show',$permission->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('permission_edit')
                    <x-admin-action-btn href="{{ route('admin.permissions.edit',$permission->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('permission_delete')
                    <x-admin-action-btn href="{{ route('admin.permissions.destroy',$permission->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('permission_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.permissions.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Permission:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
