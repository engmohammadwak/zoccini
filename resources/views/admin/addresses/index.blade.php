@extends('layouts.admin')
@section('content')
<div style="padding:24px;">
    <x-admin-page-header title="Addresses" icon="fas fa-map-marker-alt" color="blue"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Addresses']]" />
    @php $total=$addresses->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-map-marker-alt"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Addresses</div></div>
        </div>
    </div>
    <x-admin-table title="Addresses" icon="fas fa-map-marker-alt" color="blue" datatableClass="datatable-Address" :count="$addresses->count()" :createRoute="can('address_create') ? route('admin.addresses.create') : null" :createLabel="trans('global.add').' Address'">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Address</th><th>City</th><th>Default</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($addresses as $address)
            <tr data-entry-id="{{ $address->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($address->user)->name ?? 'U'" color="blue" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($address->user)->name ?? '—' }}</span></span></td>
                <td style="font-size:0.83rem;color:#475569;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $address->address ?? $address->street ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($address->city)->name_en ?? $address->city ?? '—' }}</td>
                <td>@if($address->is_default ?? false)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Default</span>@endif</td>
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
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-Address:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
