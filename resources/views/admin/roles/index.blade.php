@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.role.title')"
        icon="fas fa-shield-alt"
        color="purple"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.role.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.role.title_singular').' '.trans('global.list')"
        icon="fas fa-shield-alt"
        color="purple"
        datatableClass="datatable-Role"
        :count="$roles->count()"
        :createRoute="route('admin.roles.create')"
        :createLabel="trans('global.add').' '.trans('cruds.role.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.role.fields.id') }}</th>
                <th>{{ trans('cruds.role.fields.title') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($roles as $role)
            <tr data-entry-id="{{ $role->id }}">
                <td></td>
                <td><span style="background:#f3e8ff;color:#7c3aed;padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.8rem;">#{{ $role->id }}</span></td>
                <td>{{ $role->title ?? '' }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('role_show')
                    <x-admin-action-btn href="{{ route('admin.roles.show',$role->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('role_edit')
                    <x-admin-action-btn href="{{ route('admin.roles.edit',$role->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('role_delete')
                    <x-admin-action-btn href="{{ route('admin.roles.destroy',$role->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    @can('role_delete')
    dtButtons.push({text:'{{ trans('global.datatables.delete') }}',url:"{{ route('admin.roles.massDestroy') }}",className:'btn-danger',action:function(e,dt,node,config){var ids=$.map(dt.rows({selected:true}).nodes(),function(entry){return $(entry).data('entry-id')});if(ids.length===0){alert('{{ trans('global.datatables.zero_selected') }}');return}if(confirm('{{ trans('global.areYouSure') }}')){$.ajax({headers:{'x-csrf-token':_token},method:'POST',url:config.url,data:{ids:ids,_method:'DELETE'}}).done(function(){location.reload()})}}});
    @endcan
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Role:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
