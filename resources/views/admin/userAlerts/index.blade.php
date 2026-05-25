@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header title="{{ trans('cruds.userAlert.title') }}" icon="fas fa-bell" color="red"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.userAlert.title')]]" />
    @php $total=$userAlerts->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#b91c1c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-bell"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.userAlert.title') }}</div></div>
        </div>
    </div>
    <x-admin-table
        title="{{ trans('cruds.userAlert.title') }}" icon="fas fa-bell" color="red"
        datatableClass="datatable-UserAlert"
        :count="$userAlerts->count()"
        createPermission="user_alert_create"
        :createRoute="route('admin.user-alerts.create')"
    >
        <x-slot name="thead"><tr><th width="10"></th><th>{{ trans('cruds.userAlert.fields.title') }}</th><th>{{ trans('cruds.userAlert.fields.message') ?? 'Message' }}</th><th>{{ trans('cruds.userAlert.fields.created_at') ?? 'Date' }}</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($userAlerts as $alert)
            <tr data-entry-id="{{ $alert->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $alert->title ?? '—' }}</td>
                <td style="font-size:0.83rem;color:#475569;max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit($alert->message ?? $alert->body ?? '', 60) }}</td>
                <td style="font-size:0.82rem;color:#64748b;">{{ $alert->created_at ?? '—' }}</td>
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
<script>
$(document).ready(function(){$('.datatable-UserAlert').DataTable({pageLength:25,order:[[3,'desc']]});});
</script>
@stop
