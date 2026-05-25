@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Subscription VIPs" icon="fas fa-crown" color="gold"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Subscription VIPs']]" />
    @php $total=$subscriptionVips->count(); $active=$subscriptionVips->where('status',1)->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#d97706,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-crown"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">VIP Members</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#d97706,#b45309);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(217,119,6,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Active</div></div>
        </div>
    </div>
    <x-admin-table title="Subscription VIPs" icon="fas fa-crown" color="gold" datatableClass="datatable-SubscriptionVip" :count="$subscriptionVips->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Package</th><th>Start</th><th>End</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($subscriptionVips as $vip)
            <tr data-entry-id="{{ $vip->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($vip->user)->name ?? 'V'" color="gold" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($vip->user)->name ?? '—' }}</span></span></td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($vip->subscriptionPackage)->name_en ?? optional($vip->package)->name_en ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#64748b;">{{ optional($vip->start_date)->format('d/m/Y') ?? $vip->start_date ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#64748b;">{{ optional($vip->end_date)->format('d/m/Y') ?? $vip->end_date ?? '—' }}</td>
                <td>@if($vip->status ?? 1)<span style="background:#fef9c3;color:#854d0e;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;"><i class="fas fa-crown" style="font-size:10px;margin-right:3px;"></i>VIP Active</span>@else<span style="background:#fef2f2;color:#991b1b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Expired</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('subscription_vip_show')<x-admin-action-btn href="{{ route('admin.subscription-vips.show',$vip->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('subscription_vip_delete')<x-admin-action-btn href="{{ route('admin.subscription-vips.destroy',$vip->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-SubscriptionVip:not(.ajaxTable)').DataTable({order:[[3,'desc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
