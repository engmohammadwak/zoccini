@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Subscription Packages" icon="fas fa-box-open" color="purple"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Subscription Packages']]" />
    @php $total=$subscriptionPackages->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#9333ea,#c084fc);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-box-open"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Packages</div></div>
        </div>
    </div>
    <x-admin-table title="Subscription Packages" icon="fas fa-box-open" color="purple" datatableClass="datatable-SubscriptionPackage" :count="$subscriptionPackages->count()" createPermission="subscription_package_create" :createRoute="route('admin.subscription-packages.create')" :createLabel="trans('global.add').' Package'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Price</th><th>Duration</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($subscriptionPackages as $pkg)
            <tr data-entry-id="{{ $pkg->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $pkg->name_en ?? $pkg->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $pkg->name_ar ?? '—' }}</td>
                <td><span style="background:#faf5ff;color:#7e22ce;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ number_format($pkg->price ?? 0,2) }}</span></td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $pkg->duration ?? $pkg->days ?? '—' }} <span style="color:#94a3b8;font-size:0.75rem;">{{ isset($pkg->duration) ? 'days' : '' }}</span></td>
                <td>@if($pkg->status ?? 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Active</span>@else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Inactive</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('subscription_package_show')<x-admin-action-btn href="{{ route('admin.subscription-packages.show',$pkg->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('subscription_package_edit')<x-admin-action-btn href="{{ route('admin.subscription-packages.edit',$pkg->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('subscription_package_delete')<x-admin-action-btn href="{{ route('admin.subscription-packages.destroy',$pkg->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-SubscriptionPackage:not(.ajaxTable)').DataTable({order:[[1,'asc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
