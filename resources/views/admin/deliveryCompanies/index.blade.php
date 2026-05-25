@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Delivery Companies" icon="fas fa-truck" color="orange" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Delivery Companies']]" />
    <x-admin-table title="Delivery Companies List" icon="fas fa-truck" color="orange" datatableClass="datatable-DeliveryCompany" :count="$deliveryCompanies->count()" :createRoute="route('admin.delivery-companies.create')" createLabel="Add Company">
        <x-slot name="thead"><tr><th width="10"></th><th>Name EN</th><th>Name AR</th><th>Phone</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($deliveryCompanies as $company)
            <tr data-entry-id="{{ $company->id }}">
                <td></td>
                <td>{{ $company->name_en ?? '' }}</td>
                <td>{{ $company->name_ar ?? '' }}</td>
                <td>{{ $company->phone ?? '' }}</td>
                <td><x-admin-status-badge :label="$company->status==1?'Active':'Inactive'" :type="$company->status==1?'success':'danger'" /></td>
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
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-DeliveryCompany:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
