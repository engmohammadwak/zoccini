@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.role.title')"
        icon="fas fa-user-tag"
        color="indigo"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.role.title')],
        ]"
    />

    @php $total = $roles->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-user-tag"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.role.title') }}</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.role.title')"
        icon="fas fa-user-tag"
        color="indigo"
        datatableClass="datatable-Role"
        :count="$roles->count()"
        :createRoute="can('role_create') ? route('admin.roles.create') : null"
        :createLabel="trans('global.add').' '.trans('cruds.role.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.role.fields.title') }}</th>
                <th>Permissions</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($roles as $role)
            <tr data-entry-id="{{ $role->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#e0e7ff,#c7d2fe);display:flex;align-items:center;justify-content:center;color:#4f46e5;font-size:13px;flex-shrink:0;"><i class="fas fa-user-tag"></i></div>
                        <span style="font-weight:700;color:#1e293b;font-size:0.88rem;">{{ $role->title }}</span>
                    </span>
                </td>
                <td>
                    @if($role->permissions && $role->permissions->count())
                    <span style="background:#e0e7ff;color:#3730a3;padding:3px 10px;border-radius:8px;font-weight:600;font-size:0.78rem;"><i class="fas fa-key" style="font-size:0.7rem;"></i> {{ $role->permissions->count() }} permissions</span>
                    @else<span style="color:#94a3b8;font-size:0.8rem;">—</span>@endif
                </td>
                <td style="display:flex;gap:5px;">
                    @can('role_show')<x-admin-action-btn href="{{ route('admin.roles.show',$role->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('role_edit')<x-admin-action-btn href="{{ route('admin.roles.edit',$role->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('role_delete')<x-admin-action-btn href="{{ route('admin.roles.destroy',$role->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25});
    $('.datatable-Role:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)});
});
</script>
@endsection
