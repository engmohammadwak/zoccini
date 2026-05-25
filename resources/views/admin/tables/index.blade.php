@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Tables" icon="fas fa-table" color="indigo"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Tables']]" />
    @php $total=$tables->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-table"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Tables</div></div>
        </div>
    </div>
    <x-admin-table title="Tables" icon="fas fa-table" color="indigo" datatableClass="datatable-Table" :count="$tables->count()" :createRoute="can('table_create') ? route('admin.tables.create') : null" :createLabel="trans('global.add').' Table'">
        <x-slot name="thead"><tr><th width="10"></th><th>Number</th><th>Capacity</th><th>Area</th><th>Restaurant</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($tables as $table)
            <tr data-entry-id="{{ $table->id }}">
                <td></td>
                <td><span style="background:#eef2ff;color:#4338ca;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">#{{ $table->number ?? $table->table_number ?? $table->id }}</span></td>
                <td style="font-size:0.83rem;color:#475569;">{{ $table->capacity ?? '—' }} <span style="color:#94a3b8;font-size:0.75rem;">seats</span></td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($table->sittingArea)->name_en ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($table->restaurant)->name_en ?? '—' }}</td>
                <td>@php $s=optional($table->tableStatus)->name_en ?? ($table->status ?? null); @endphp
                    @if($s)<span style="background:#f0fdf4;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">{{ $s }}</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('table_show')<x-admin-action-btn href="{{ route('admin.tables.show',$table->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('table_edit')<x-admin-action-btn href="{{ route('admin.tables.edit',$table->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('table_delete')<x-admin-action-btn href="{{ route('admin.tables.destroy',$table->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-Table:not(.ajaxTable)').DataTable({order:[[1,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
