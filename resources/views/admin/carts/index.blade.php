@extends('layouts.admin')
@section('content')
<div style="padding:24px;">
    <x-admin-page-header title="Carts" icon="fas fa-shopping-cart" color="amber"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Carts']]" />
    @php $total=$carts->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-shopping-cart"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Carts</div></div>
        </div>
    </div>
    <x-admin-table title="Carts" icon="fas fa-shopping-cart" color="amber" datatableClass="datatable-Cart" :count="$carts->count()" createPermission="cart_create" :createRoute="route('admin.carts.create')" :createLabel="trans('global.add').' Cart'">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Items</th><th>Total</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($carts as $cart)
            <tr data-entry-id="{{ $cart->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ optional($cart->user)->name ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;">{{ $cart->items_count ?? $cart->cartItems?->count() ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#1e293b;font-weight:600;">{{ $cart->total ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('cart_show')<x-admin-action-btn href="{{ route('admin.carts.show',$cart->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('cart_edit')<x-admin-action-btn href="{{ route('admin.carts.edit',$cart->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('cart_delete')<x-admin-action-btn href="{{ route('admin.carts.destroy',$cart->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-Cart:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
