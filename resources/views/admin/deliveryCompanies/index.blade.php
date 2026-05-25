@extends('layouts.admin')
@section('content')
<div style="padding:24px;">
    <x-admin-page-header title="Delivery Companies" icon="fas fa-truck" color="blue"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Delivery Companies']]" />
    @php $total=$deliveryCompanies->count(); $active=$deliveryCompanies->where('status',1)->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-truck"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Companies</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-check"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Active</div></div>
        </div>
    </div>
    <x-admin-table title="Delivery Companies" icon="fas fa-truck" color="blue" datatableClass="datatable-DeliveryCompany" :count="$deliveryCompanies->count()" createPermission="delivery_company_create" :createRoute="route('admin.delivery-companies.create')" :createLabel="trans('global.add').' Company'">
        <x-slot name="thead"><tr><th width="10"></th><th>Name</th><th>Phone</th><th>Email</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($deliveryCompanies as $company)
            <tr data-entry-id="{{ $company->id }}">
                <td></td>
                <td style="font-weight:700;color:#1e293b;font-size:0.85rem;">{{ $company->name_en ?? $company->name ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ $company->phone ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ $company->email ?? '—' }}</td>
                <td>@if(($company->status??1)==1)<span style="background:rgba(16,185,129,.12);color:#065f46;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Active</span>@else<span style="background:rgba(148,163,184,.12);color:#475569;padding:4px 11px;border-radius:999px;font-weight:600;font-size:0.75rem;">Inactive</span>@endif</td>
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
