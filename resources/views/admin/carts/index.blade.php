@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Carts" icon="fas fa-shopping-cart" color="amber"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Carts']]" />
    @php $total=$carts->count(); $totalVal=$carts->sum(fn($c)=>optional($c->item)->price ?? 0); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-shopping-cart"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Cart Items</div></div>
        </div>
    </div>
    <x-admin-table title="Carts" icon="fas fa-shopping-cart" color="amber" datatableClass="datatable-Cart" :count="$carts->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Item</th><th>Qty</th><th>Restaurant</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($carts as $cart)
            <tr data-entry-id="{{ $cart->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($cart->user)->name ?? 'U'" color="amber" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($cart->user)->name ?? '—' }}</span></span></td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($cart->item)->name_en ?? '—' }}</td>
                <td><span style="background:#fef9c3;color:#854d0e;padding:3px 9px;border-radius:7px;font-weight:700;font-size:0.82rem;">{{ $cart->quantity ?? $cart->qty ?? 1 }}</span></td>
                <td style="font-size:0.82rem;color:#64748b;">{{ optional($cart->restaurant)->name_en ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($cart->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
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
