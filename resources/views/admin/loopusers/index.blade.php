@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Loop Users" icon="fas fa-sync-alt" color="cyan"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Loop Users']]" />
    @php $total=$loopusers->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#06b6d4,#22d3ee);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-sync-alt"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Loop Users</div></div>
        </div>
    </div>
    <x-admin-table title="Loop Users" icon="fas fa-sync-alt" color="cyan" datatableClass="datatable-Loopuser" :count="$loopusers->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Bank</th><th>Amount</th><th>Status</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($loopusers as $lu)
            <tr data-entry-id="{{ $lu->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($lu->user)->name ?? 'U'" color="cyan" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($lu->user)->name ?? '—' }}</span></span></td>
                <td style="font-size:0.83rem;color:#475569;">{{ optional($lu->loopBank)->name_en ?? optional($lu->bank)->name_en ?? '—' }}</td>
                <td><span style="background:#ecfeff;color:#0e7490;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.83rem;">{{ number_format($lu->amount ?? 0,2) }}</span></td>
                <td>@php $st=$lu->status ?? null; @endphp
                    @if($st=='approved'||$st==1)<span style="background:#dcfce7;color:#166534;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Approved</span>
                    @elseif($st=='pending')<span style="background:#fef9c3;color:#854d0e;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">Pending</span>
                    @elseif($st=='rejected'||$st==0)<span style="background:#fef2f2;color:#991b1b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">Rejected</span>
                    @else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">{{ $st ?? '—' }}</span>@endif</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($lu->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('loopuser_show')<x-admin-action-btn href="{{ route('admin.loopusers.show',$lu->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('loopuser_delete')<x-admin-action-btn href="{{ route('admin.loopusers.destroy',$lu->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-Loopuser:not(.ajaxTable)').DataTable({order:[[5,'desc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
