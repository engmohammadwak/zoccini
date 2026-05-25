@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Subscription Users" icon="fas fa-user-tag" color="violet"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Subscription Users']]" />
    @php $total=$subscriptionUsers->count(); $active=$subscriptionUsers->where('status',1)->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-user-tag"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Subscriptions</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#7c3aed,#5b21b6);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(124,58,237,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Active</div></div>
        </div>
    </div>
    <x-admin-table title="Subscription Users" icon="fas fa-user-tag" color="violet" datatableClass="datatable-SubscriptionUser" :count="$subscriptionUsers->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Package</th><th>Start</th><th>End</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($subscriptionUsers as $su)
            <tr data-entry-id="{{ $su->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($su->user)->name ?? 'U'" color="violet" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($su->user)->name ?? '—' }}</span></span></td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($su->subscriptionPackage)->name_en ?? optional($su->package)->name_en ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#64748b;">{{ optional($su->start_date)->format('d/m/Y') ?? $su->start_date ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#64748b;">{{ optional($su->end_date)->format('d/m/Y') ?? $su->end_date ?? '—' }}</td>
                <td>@if($su->status ?? 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Active</span>@else<span style="background:#fef2f2;color:#991b1b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Expired</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('subscription_user_show')<x-admin-action-btn href="{{ route('admin.subscription-users.show',$su->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('subscription_user_delete')<x-admin-action-btn href="{{ route('admin.subscription-users.destroy',$su->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-SubscriptionUser:not(.ajaxTable)').DataTable({order:[[3,'desc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
