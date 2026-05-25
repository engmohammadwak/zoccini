@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Become Partners" icon="fas fa-handshake" color="teal"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Become Partners']]" />
    @php
        $total    = $becomePartners->count();
        $pending  = $becomePartners->where('status','pending')->count();
        $approved = $becomePartners->where('status','approved')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-handshake"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-clock"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $pending }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Pending</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#0d9488,#0f766e);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(13,148,136,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $approved }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Approved</div></div>
        </div>
    </div>
    <x-admin-table title="Become Partners" icon="fas fa-handshake" color="teal" datatableClass="datatable-BecomePartner" :count="$becomePartners->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>Name</th><th>Phone</th><th>Restaurant</th><th>Status</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($becomePartners as $partner)
            @php $st=$partner->status ?? 'pending'; $sm=['pending'=>['bg'=>'#fef9c3','color'=>'#854d0e'],'approved'=>['bg'=>'#dcfce7','color'=>'#166534'],'rejected'=>['bg'=>'#fee2e2','color'=>'#991b1b']][$st] ?? ['bg'=>'#f1f5f9','color'=>'#64748b']; @endphp
            <tr data-entry-id="{{ $partner->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $partner->name ?? $partner->owner_name ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $partner->phone ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ $partner->restaurant_name ?? '—' }}</td>
                <td><span style="background:{{ $sm['bg'] }};color:{{ $sm['color'] }};padding:3px 9px;border-radius:7px;font-weight:600;font-size:0.78rem;">{{ ucfirst($st) }}</span></td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($partner->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('become_partner_show')<x-admin-action-btn href="{{ route('admin.become-partners.show',$partner->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('become_partner_delete')<x-admin-action-btn href="{{ route('admin.become-partners.destroy',$partner->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-BecomePartner:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
