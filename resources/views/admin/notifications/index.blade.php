@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.notification.title')"
        icon="fas fa-bell"
        color="yellow"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.notification.title')],
        ]"
    />

    @php
        $total  = $notifications->count();
        $unread = $notifications->whereNull('read_at')->count();
        $read   = $notifications->whereNotNull('read_at')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#eab308,#facc15);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-bell"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#f87171);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-bell"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $unread }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Unread</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#eab308,#ca8a04);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(234,179,8,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $read }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Read</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.notification.title')"
        icon="fas fa-bell"
        color="yellow"
        datatableClass="datatable-Notification"
        :count="$notifications->count()"
        :createRoute="can('notification_create') ? route('admin.notifications.create') : null"
        :createLabel="trans('global.add').' Notification'"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>Title</th>
                <th>Body</th>
                <th>Type</th>
                <th>Date</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($notifications as $notification)
            @php $data = is_array($notification->data) ? $notification->data : json_decode($notification->data,true); @endphp
            <tr data-entry-id="{{ $notification->id }}">
                <td></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <div style="width:32px;height:32px;border-radius:9px;background:linear-gradient(135deg,#fef9c3,#fde68a);display:flex;align-items:center;justify-content:center;color:#ca8a04;font-size:13px;flex-shrink:0;"><i class="fas fa-bell"></i></div>
                        <span style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $notification->title ?? ($data['title'] ?? $notification->id) }}</span>
                    </span>
                </td>
                <td style="font-size:0.82rem;color:#64748b;max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $notification->body ?? ($data['body'] ?? '—') }}</td>
                <td>
                    @if($notification->type ?? null)
                    <span style="background:#fef9c3;color:#854d0e;padding:3px 9px;border-radius:7px;font-size:0.78rem;font-weight:600;">{{ $notification->type }}</span>
                    @endif
                </td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($notification->created_at)->format('d/m/Y H:i') }}</td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('notification_show')<x-admin-action-btn href="{{ route('admin.notifications.show',$notification->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('notification_edit')<x-admin-action-btn href="{{ route('admin.notifications.edit',$notification->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('notification_delete')<x-admin-action-btn href="{{ route('admin.notifications.destroy',$notification->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
$(function(){
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Notification:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)});
});
</script>
@endsection
