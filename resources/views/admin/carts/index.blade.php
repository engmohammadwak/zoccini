@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Carts" icon="fas fa-shopping-cart" color="blue" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Carts']]" />
    <x-admin-table title="Cart List" icon="fas fa-shopping-cart" color="blue" datatableClass="datatable-Cart" :count="$carts->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Restaurant</th><th>Items Count</th><th>Total</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($carts as $cart)
            <tr data-entry-id="{{ $cart->id }}">
                <td></td>
                <td>{{ optional($cart->user)->name ?? '' }}</td>
                <td>{{ optional($cart->restaurant)->name_en ?? '' }}</td>
                <td><span style="background:#dbeafe;color:#1d4ed8;padding:3px 10px;border-radius:99px;font-size:0.8rem;">{{ $cart->items_count ?? $cart->cartItems->count() }}</span></td>
                <td><strong style="color:#059669;">{{ number_format($cart->total??0,2) }}</strong></td>
                <td style="color:#7a80a0;font-size:0.82rem;">{{ optional($cart->created_at)->format('d/m/Y') ?? '' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('cart_show')<x-admin-action-btn href="{{ route('admin.carts.show',$cart->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
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
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-Cart:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
