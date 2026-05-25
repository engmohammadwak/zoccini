@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.notification.title')"
        icon="fas fa-bell"
        color="orange"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.notification.title')],
        ]"
    />

    <x-admin-table
        :title="trans('cruds.notification.title_singular').' '.trans('global.list')"
        icon="fas fa-bell"
        color="orange"
        datatableClass="datatable-Notification"
        :count="$notifications->count()"
        :createRoute="route('admin.notifications.create')"
        :createLabel="trans('global.add').' '.trans('cruds.notification.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>{{ trans('cruds.notification.fields.title_en') }}</th>
                <th>{{ trans('cruds.notification.fields.title_ar') }}</th>
                <th>{{ trans('cruds.notification.fields.type') }}</th>
                <th>{{ trans('cruds.notification.fields.created_at') }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($notifications as $notification)
            <tr data-entry-id="{{ $notification->id }}">
                <td></td>
                <td>{{ $notification->title_en ?? '' }}</td>
                <td>{{ $notification->title_ar ?? '' }}</td>
                <td><x-admin-status-badge :label="$notification->type ?? ''" type="info" /></td>
                <td style="color:#7a80a0;font-size:0.82rem;">
                    <i class="far fa-clock" style="margin-left:4px;"></i>
                    {{ optional($notification->created_at)->translatedFormat('d/m/Y H:i') ?? '' }}
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('notification_show')
                    <x-admin-action-btn href="{{ route('admin.notifications.show',$notification->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('notification_delete')
                    <x-admin-action-btn href="{{ route('admin.notifications.destroy',$notification->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
                    @endcan
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
    let dtButtons=$.extend(true,[],$.fn.dataTable.defaults.buttons);
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});
    $('.datatable-Notification:not(.ajaxTable)').DataTable({buttons:dtButtons});
});
</script>
@endsection
