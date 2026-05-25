@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Addresses" icon="fas fa-map-marker-alt" color="teal" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Addresses']]" />
    <x-admin-table title="Address List" icon="fas fa-map-marker-alt" color="teal" datatableClass="datatable-Address" :count="$addresses->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Address</th><th>City</th><th>Default</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($addresses as $address)
            <tr data-entry-id="{{ $address->id }}">
                <td></td>
                <td>{{ optional($address->user)->name ?? '' }}</td>
                <td>{{ $address->address ?? '' }}</td>
                <td>{{ optional($address->city)->name_en ?? '' }}</td>
                <td><x-admin-status-badge :label="$address->is_default ? 'Default' : 'No'" :type="$address->is_default ? 'success' : 'info'" /></td>
                <td style="display:flex;gap:5px;">
                    @can('address_show')<x-admin-action-btn href="{{ route('admin.addresses.show',$address->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('address_edit')<x-admin-action-btn href="{{ route('admin.addresses.edit',$address->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('address_delete')<x-admin-action-btn href="{{ route('admin.addresses.destroy',$address->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-Address:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
