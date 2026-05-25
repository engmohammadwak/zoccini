@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Table Statuses" icon="fas fa-toggle-on" color="green"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Table Statuses']]" />
    @php $total=$tableStatuses->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-toggle-on"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Statuses</div></div>
        </div>
    </div>
    <x-admin-table
        title="Table Statuses"
        icon="fas fa-toggle-on"
        color="green"
        datatableClass="datatable-TableStatus"
        :count="$tableStatuses->count()"
        createPermission="table_status_create"
        :createRoute="route('admin.table-statuses.create')"
        :createLabel="trans('global.add').' Status'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Color</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($tableStatuses as $status)
            <tr data-entry-id="{{ $status->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $status->name_en ?? $status->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $status->name_ar ?? '—' }}</td>
                <td>@if($status->color ?? null)<span style="display:inline-flex;align-items:center;gap:6px;"><span style="width:16px;height:16px;border-radius:4px;background:{{ $status->color }};display:inline-block;"></span><span style="font-size:0.78rem;font-family:monospace;color:#475569;">{{ $status->color }}</span></span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('table_status_show')<x-admin-action-btn href="{{ route('admin.table-statuses.show',$status->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('table_status_edit')<x-admin-action-btn href="{{ route('admin.table-statuses.edit',$status->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('table_status_delete')<x-admin-action-btn href="{{ route('admin.table-statuses.destroy',$status->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-TableStatus:not(.ajaxTable)').DataTable({order:[[1,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
