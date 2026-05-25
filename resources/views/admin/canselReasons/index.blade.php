@extends('layouts.admin')
@section('content')
<div style="padding:24px;">

    <x-admin-page-header
        title="Cancel Reasons"
        icon="fas fa-times-circle"
        color="red"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => 'Cancel Reasons'],
        ]"
    />

    @php
        $total  = $canselReasons->count();
        $active = $canselReasons->where('status', 1)->count();
    @endphp

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-times-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Reasons</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-check"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Active</div></div>
        </div>
    </div>

    <x-admin-table title="Cancel Reasons" icon="fas fa-times-circle" color="red" datatableClass="datatable-CanselReason" :count="$canselReasons->count()" createPermission="cansel_reason_create" :createRoute="route('admin.cansel-reasons.create')" :createLabel="trans('global.add').' Reason'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($canselReasons as $reason)
            <tr data-entry-id="{{ $reason->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $reason->name_en ?? $reason->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $reason->name_ar ?? '—' }}</td>
                <td>@if(($reason->status??1)==1)<span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Active</span>@else<span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Inactive</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('cansel_reason_show')<x-admin-action-btn href="{{ route('admin.cansel-reasons.show',$reason->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('cansel_reason_edit')<x-admin-action-btn href="{{ route('admin.cansel-reasons.edit',$reason->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('cansel_reason_delete')<x-admin-action-btn href="{{ route('admin.cansel-reasons.destroy',$reason->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>

</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-CanselReason:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
