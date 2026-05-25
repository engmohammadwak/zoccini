@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Referral Subscriptions" icon="fas fa-share-alt" color="teal"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Referral Subscriptions']]" />
    @php $total=$referralSubscriptions->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-share-alt"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Referrals</div></div>
        </div>
    </div>
    <x-admin-table title="Referral Subscriptions" icon="fas fa-share-alt" color="teal" datatableClass="datatable-ReferralSubscription" :count="$referralSubscriptions->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>Referrer</th><th>Referred User</th><th>Package</th><th>Reward</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($referralSubscriptions as $ref)
            <tr data-entry-id="{{ $ref->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:7px;"><x-admin-avatar :name="optional($ref->referrer)->name ?? optional($ref->user)->name ?? 'R'" color="teal" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($ref->referrer)->name ?? optional($ref->user)->name ?? '—' }}</span></span></td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($ref->referredUser)->name ?? optional($ref->referred)->name ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($ref->subscriptionPackage)->name_en ?? optional($ref->package)->name_en ?? '—' }}</td>
                <td><span style="background:#f0fdfa;color:#0f766e;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ number_format($ref->reward ?? $ref->commission ?? 0,2) }}</span></td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($ref->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('referral_subscription_show')<x-admin-action-btn href="{{ route('admin.referral-subscriptions.show',$ref->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('referral_subscription_delete')<x-admin-action-btn href="{{ route('admin.referral-subscriptions.destroy',$ref->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-ReferralSubscription:not(.ajaxTable)').DataTable({order:[[5,'desc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
