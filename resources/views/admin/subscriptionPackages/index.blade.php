@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header title="{{ trans('cruds.subscriptionPackage.title') }}" icon="fas fa-box-open" color="purple"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.subscriptionPackage.title')]]" />
    @php $total=$subscriptionPackages->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#a855f7,#7c3aed);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-box-open"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.subscriptionPackage.title') }}</div></div>
        </div>
    </div>
    <x-admin-table
        title="{{ trans('cruds.subscriptionPackage.title') }}" icon="fas fa-box-open" color="purple"
        datatableClass="datatable-SubscriptionPackage"
        :count="$subscriptionPackages->count()"
        createPermission="subscription_package_create"
        :createRoute="route('admin.subscription-packages.create')"
    >
        <x-slot name="thead"><tr><th width="10"></th><th>{{ trans('cruds.subscriptionPackage.fields.name') }}</th><th>{{ trans('cruds.subscriptionPackage.fields.price') }}</th><th>{{ trans('cruds.subscriptionPackage.fields.duration') }}</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($subscriptionPackages as $pkg)
            <tr data-entry-id="{{ $pkg->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $pkg->name ?? $pkg->name_en ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $pkg->price ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $pkg->duration ?? '—' }}</td>
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
<script>
$(document).ready(function(){$('.datatable-SubscriptionPackage').DataTable({pageLength:25,order:[[1,'asc']]});});
</script>
@stop
