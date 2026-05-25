@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Reports" icon="fas fa-chart-bar" color="blue"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Reports']]" />
    @php $total=$reports->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#3b82f6,#60a5fa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-chart-bar"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Reports</div></div>
        </div>
    </div>
    <x-admin-table title="Reports" icon="fas fa-chart-bar" color="blue" datatableClass="datatable-Report" :count="$reports->count()">
        <x-slot name="thead"><tr><th width="10"></th><th>User</th><th>Type</th><th>Description</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($reports as $report)
            <tr data-entry-id="{{ $report->id }}">
                <td></td>
                <td><span style="display:flex;align-items:center;gap:8px;"><x-admin-avatar :name="optional($report->user)->name ?? 'U'" color="blue" /><span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($report->user)->name ?? '—' }}</span></span></td>
                <td><span style="background:#eff6ff;color:#1d4ed8;padding:3px 10px;border-radius:8px;font-size:0.78rem;font-weight:600;">{{ $report->type ?? '—' }}</span></td>
                <td style="font-size:0.82rem;color:#475569;max-width:240px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $report->description ?? $report->body ?? '—' }}</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($report->created_at)->format('d/m/Y') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('report_show')<x-admin-action-btn href="{{ route('admin.reports.show',$report->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('report_delete')<x-admin-action-btn href="{{ route('admin.reports.destroy',$report->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-Report:not(.ajaxTable)').DataTable({order:[[4,'desc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
