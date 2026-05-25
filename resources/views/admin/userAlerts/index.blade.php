@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">
    <x-admin-page-header title="User Alerts" icon="fas fa-bell" color="red"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'User Alerts']]" />
    @php $total=$userAlerts->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;"><i class="fas fa-bell"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Alerts</div></div>
        </div>
    </div>
    <x-admin-table title="User Alerts" icon="fas fa-bell" color="red" datatableClass="datatable-UserAlert" :count="$userAlerts->count()" :createRoute="can('user_alert_create') ? route('admin.user-alerts.create') : null" :createLabel="trans('global.add').' Alert'">
        <x-slot name="thead"><tr><th width="10"></th><th>Title</th><th>Message</th><th>Users</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($userAlerts as $alert)
            <tr data-entry-id="{{ $alert->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $alert->title ?? '—' }}</td>
                <td style="font-size:0.82rem;color:#475569;max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $alert->message ?? $alert->body ?? '—' }}</td>
                <td>@if(method_exists($alert,'users') && $alert->users->count())
                    <span style="background:#fef2f2;color:#991b1b;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.82rem;">{{ $alert->users->count() }} users</span>
                @else<span style="background:#f1f5f9;color:#64748b;padding:3px 9px;border-radius:7px;font-size:0.78rem;">All</span>@endif</td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($alert->created_at)->format('d/m/Y H:i') }}</td>
                <td style="display:flex;gap:5px;">
                    @can('user_alert_show')<x-admin-action-btn href="{{ route('admin.user-alerts.show',$alert->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('user_alert_edit')<x-admin-action-btn href="{{ route('admin.user-alerts.edit',$alert->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('user_alert_delete')<x-admin-action-btn href="{{ route('admin.user-alerts.destroy',$alert->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){ $('.datatable-UserAlert:not(.ajaxTable)').DataTable({order:[[4,'desc']],pageLength:25,buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)}); });</script>
@endsection
