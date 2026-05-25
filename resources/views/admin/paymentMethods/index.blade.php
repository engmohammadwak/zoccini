@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Payment Methods" icon="fas fa-credit-card" color="green"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Payment Methods']]" />
    @php $total=$paymentMethods->count(); $active=$paymentMethods->where('status',1)->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-credit-card"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Methods</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#10b981,#059669);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(16,185,129,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $active }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Active</div></div>
        </div>
    </div>
    <x-admin-table title="Payment Methods" icon="fas fa-credit-card" color="green" datatableClass="datatable-PaymentMethod" :count="$paymentMethods->count()" :createRoute="\Illuminate\Support\Facades\Gate::allows('payment_method_create') ? route('admin.payment-methods.create') : null" :createLabel="trans('global.add').' Method'">
        <x-slot name="thead"><tr><th width="10"></th><th>Logo</th><th>Name EN</th><th>Name AR</th><th>Status</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($paymentMethods as $pm)
            <tr data-entry-id="{{ $pm->id }}">
                <td></td>
                <td>@if($pm->logo ?? null)<img src="{{ asset('storage/'.$pm->logo) }}" style="width:42px;height:32px;object-fit:contain;border-radius:6px;border:1px solid #f1f5f9;" alt="" loading="lazy">@else<div style="width:42px;height:32px;border-radius:6px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;color:#10b981;"><i class="fas fa-credit-card"></i></div>@endif</td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $pm->name_en ?? $pm->name ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;">{{ $pm->name_ar ?? '—' }}</td>
                <td>@if($pm->status == 1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">{{ trans('global.active') }}</span>@else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">{{ trans('global.inactive') }}</span>@endif</td>
                <td style="display:flex;gap:5px;">
                    @can('payment_method_show')<x-admin-action-btn href="{{ route('admin.payment-methods.show',$pm->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('payment_method_edit')<x-admin-action-btn href="{{ route('admin.payment-methods.edit',$pm->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('payment_method_delete')<x-admin-action-btn href="{{ route('admin.payment-methods.destroy',$pm->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'asc']],pageLength:25}); $('.datatable-PaymentMethod:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
