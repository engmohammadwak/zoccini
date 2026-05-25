@extends('layouts.admin')
@section('content')
<div style="padding:24px;">
    <x-admin-page-header title="Employees" icon="fas fa-users" color="indigo"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Employees']]" />
    @php $total=$employees->count(); $active=$employees->where('status',1)->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-users"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Employees</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-check"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Active</div></div>
        </div>
    </div>
    <x-admin-table title="Employees" icon="fas fa-users" color="indigo" datatableClass="datatable-Employee" :count="$employees->count()" createPermission="employee_create" :createRoute="route('admin.employees.create')" :createLabel="trans('global.add').' Employee'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($employees as $employee)
            <tr data-entry-id="{{ $employee->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="$employee->name ?? 'E'" color="indigo" /><span style="font-weight:700;color:#1e293b;font-size:0.85rem;">{{ $employee->name ?? '—' }}</span></span></td>
                <td style="font-size:0.82rem;color:#475569;">{{ $employee->email ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ $employee->phone ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ optional($employee->role)->name ?? $employee->role ?? '—' }}</td>
                <td>@if(($employee->status??1)==1)<span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Active</span>@else<span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Inactive</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('employee_show')<x-admin-action-btn href="{{ route('admin.employees.show',$employee->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('employee_edit')<x-admin-action-btn href="{{ route('admin.employees.edit',$employee->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('employee_delete')<x-admin-action-btn href="{{ route('admin.employees.destroy',$employee->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-Employee:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
