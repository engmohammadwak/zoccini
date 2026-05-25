@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header title="{{ trans('cruds.subscriptionVip.title') }}" icon="fas fa-crown" color="indigo"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.subscriptionVip.title')]]" />
    @php $total=$subscriptionVips->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#4338ca);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-crown"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.subscriptionVip.title') }}</div></div>
        </div>
    </div>
    <x-admin-table
        title="{{ trans('cruds.subscriptionVip.title') }}" icon="fas fa-crown" color="indigo"
        datatableClass="datatable-SubscriptionVip"
        :count="$subscriptionVips->count()"
        createPermission="subscription_vip_create"
        :createRoute="route('admin.subscription-vips.create')"
    >
        <x-slot name="thead"><tr><th width="10"></th><th>{{ trans('cruds.subscriptionVip.fields.user') }}</th><th>{{ trans('cruds.subscriptionVip.fields.package') }}</th><th>{{ trans('cruds.subscriptionVip.fields.expires_at') }}</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($subscriptionVips as $vip)
            <tr data-entry-id="{{ $vip->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ optional($vip->user)->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($vip->subscriptionPackage)->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $vip->expires_at ?? $vip->end_date ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('subscription_vip_show')<x-admin-action-btn href="{{ route('admin.subscription-vips.show',$vip->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('subscription_vip_edit')<x-admin-action-btn href="{{ route('admin.subscription-vips.edit',$vip->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
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
<script>
$(document).ready(function(){$('.datatable-SubscriptionVip').DataTable({pageLength:25,order:[[1,'asc']]});});
</script>
@stop
