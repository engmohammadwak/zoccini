@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.permission.title')"
        icon="fas fa-key"
        color="yellow"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.permission.title')],
        ]"
    />

    @php
        $totalPerm = $permissions->count();
        $groups = $permissions->groupBy(function($p){
            $parts = explode('_',$p->title);
            array_pop($parts);
            return implode('_',$parts);
        });
    @endphp

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#eab308,#facc15);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-key"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalPerm }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.permission.title') }}</div>
            </div>
        </div>
        <div style="background:linear-gradient(135deg,#eab308,#ca8a04);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(234,179,8,0.28);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $groups->count() }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Groups</div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <x-admin-table
        :title="trans('cruds.permission.title_singular').' '.trans('global.list')"
        icon="fas fa-key"
        color="yellow"
        datatableClass="datatable-Permission"
        :count="$permissions->count()"
        :createRoute="route('admin.permissions.create')"
        :createLabel="trans('global.add').' '.trans('cruds.permission.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.permission.fields.title') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($permissions as $perm)
            <tr data-entry-id="{{ $perm->id }}">
                <td></td>
                <td>
                    <span style="background:#fef9c3;color:#854d0e;padding:3px 10px;border-radius:8px;font-size:0.8rem;font-weight:600;font-family:monospace;display:inline-flex;align-items:center;gap:6px;">
                        <i class="fas fa-key" style="font-size:0.7rem;"></i>
                        {{ $perm->title }}
                    </span>
                </td>
                <td style="display:flex;gap:5px;">
                    @can('permission_show')<x-admin-action-btn href="{{ route('admin.permissions.show',$perm->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('permission_edit')<x-admin-action-btn href="{{ route('admin.permissions.edit',$perm->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('permission_delete')<x-admin-action-btn href="{{ route('admin.permissions.destroy',$perm->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:50});
    $('.datatable-Permission:not(.ajaxTable)').DataTable({buttons:[]});
});
</script>
@endsection
