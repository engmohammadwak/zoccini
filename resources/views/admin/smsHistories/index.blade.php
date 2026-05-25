@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="SMS Histories" icon="fas fa-sms" color="cyan"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'SMS Histories']]" />
    @php $total=$smsHistories->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#06b6d4,#22d3ee);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-sms"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Messages</div></div>
        </div>
    </div>
    <x-admin-table title="SMS Histories" icon="fas fa-sms" color="cyan" datatableClass="datatable-SmsHistory" :count="$smsHistories->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>Phone</th><th>Message</th><th>Status</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($smsHistories as $sms)
            <tr data-entry-id="{{ $sms->id }}">
                <td></td>
                <td><span style="font-family:monospace;font-size:0.83rem;color:#1e293b;font-weight:600;">{{ $sms->phone ?? $sms->mobile ?? '—' }}</span></td>
                <td style="font-size:0.82rem;color:#475569;max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $sms->message ?? '—' }}</td>
                <td>@php $st=$sms->status ?? null; @endphp
                    @if($st=='sent' || $st==1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Sent</span>
                    @elseif($st=='failed' || $st==0)<span style="background:#fef2f2;color:#991b1b;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Failed</span>
                    @else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">{{ $st ?? '—' }}</span>@endif</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($sms->created_at)->format('d/m/Y H:i') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('sms_history_show')<x-admin-action-btn href="{{ route('admin.sms-histories.show',$sms->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('sms_history_delete')<x-admin-action-btn href="{{ route('admin.sms-histories.destroy',$sms->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-SmsHistory:not(.ajaxTable)').DataTable({order:[[4,'desc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
