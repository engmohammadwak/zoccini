@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Saved Credit Cards" icon="fas fa-wallet" color="blue"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Saved Cards']]" />
    @php $total=$saveCreditCards->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-wallet"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Saved Cards</div></div>
        </div>
    </div>
    <x-admin-table title="Saved Credit Cards" icon="fas fa-wallet" color="blue" datatableClass="datatable-SaveCreditCard" :count="$saveCreditCards->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Card (Last 4)</th><th>Brand</th><th>Expiry</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($saveCreditCards as $card)
            <tr data-entry-id="{{ $card->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($card->user)->name ?? 'U'" color="blue" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($card->user)->name ?? '—' }}</span></span></td>
                <td><span style="background:#eff6ff;color:#1d4ed8;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;font-family:monospace;">•••• {{ $card->last_four ?? $card->card_last4 ?? '****' }}</span></td>
                <td style="font-size:0.82rem;color:#475569;text-transform:capitalize;">{{ $card->brand ?? $card->card_brand ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $card->exp_month ?? '—' }}/{{ $card->exp_year ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('save_credit_card_delete')<x-admin-action-btn href="{{ route('admin.save-credit-cards.destroy',$card->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25}); $('.datatable-SaveCreditCard:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
