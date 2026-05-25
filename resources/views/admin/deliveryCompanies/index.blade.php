@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Delivery Companies" icon="fas fa-truck" color="cyan"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Delivery Companies']]" />
    @php $total=$deliveryCompanies->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#06b6d4,#22d3ee);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-truck"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Companies</div></div>
        </div>
    </div>
    <x-admin-table title="Delivery Companies" icon="fas fa-truck" color="cyan" datatableClass="datatable-DeliveryCompany" :count="$deliveryCompanies->count()" :createRoute="can('delivery_company_create') ? route('admin.delivery-companies.create') : null" :createLabel="trans('global.add').' Company'">
        <x-slot name="thead"><tr><th width="10"></th><th>Logo</th><th>Name EN</th><th>Name AR</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($deliveryCompanies as $company)
            <tr data-entry-id="{{ $company->id }}">
                <td></td>
                <td>@if($company->logo ?? $company->image ?? null)<img src="{{ asset('storage/'.($company->logo ?? $company->image)) }}" style="width:42px;height:32px;object-fit:contain;border-radius:6px;" alt="" loading="lazy">@else<div style="width:42px;height:32px;border-radius:6px;background:#ecfeff;display:flex;align-items:center;justify-content:center;color:#06b6d4;"><i class="fas fa-truck"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $company->name_en ?? $company->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $company->name_ar ?? '—' }}</td>
                <td>@if($company->status ?? 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Active</span>@else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Inactive</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('delivery_company_show')<x-admin-action-btn href="{{ route('admin.delivery-companies.show',$company->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('delivery_company_edit')<x-admin-action-btn href="{{ route('admin.delivery-companies.edit',$company->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('delivery_company_delete')<x-admin-action-btn href="{{ route('admin.delivery-companies.destroy',$company->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-DeliveryCompany:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
