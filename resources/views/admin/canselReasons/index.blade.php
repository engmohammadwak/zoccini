@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Cancel Reasons" icon="fas fa-ban" color="red"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Cancel Reasons']]" />
    @php $total=$canselReasons->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-ban"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Reasons</div></div>
        </div>
    </div>
    <x-admin-table title="Cancel Reasons" icon="fas fa-ban" color="red" datatableClass="datatable-CanselReason" :count="$canselReasons->count()" :createRoute="can('cansel_reason_create') ? route('admin.cansel-reasons.create') : null" :createLabel="trans('global.add').' Reason'">
        <x-slot name="thead"><tr><th width="10"></th><th>Reason EN</th><th>Reason AR</th><th>Type</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($canselReasons as $reason)
            <tr data-entry-id="{{ $reason->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $reason->reason_en ?? $reason->name_en ?? $reason->reason ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $reason->reason_ar ?? $reason->name_ar ?? '—' }}</td>
                <td><span style="background:#fee2e2;color:#991b1b;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">{{ $reason->type ?? 'Order' }}</span></td>
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
