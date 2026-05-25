@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header title="{{ trans('cruds.ticketStatus.title') }}" icon="fas fa-ticket-alt" color="teal"
        :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.ticketStatus.title')]]" />
    @php $total=$ticketStatuses->count(); @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#14b8a6,#0f766e);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-ticket-alt"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.ticketStatus.title') }}</div></div>
        </div>
    </div>
    <x-admin-table
        title="{{ trans('cruds.ticketStatus.title') }}" icon="fas fa-ticket-alt" color="teal"
        datatableClass="datatable-TicketStatus"
        :count="$ticketStatuses->count()"
        createPermission="ticket_status_create"
        :createRoute="route('admin.ticket-statuses.create')"
    >
        <x-slot name="thead"><tr><th width="10"></th><th>{{ trans('cruds.ticketStatus.fields.name') }}</th><th>{{ trans('cruds.ticketStatus.fields.color') ?? 'Color' }}</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($ticketStatuses as $status)
            <tr data-entry-id="{{ $status->id }}">
                <td></td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;">{{ $status->name ?? '—' }}</td>
                <td><span style="display:inline-block;width:16px;height:16px;border-radius:50%;background:{{ $status->color ?? '#ccc' }};"></span> {{ $status->color ?? '—' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('ticket_status_show')<x-admin-action-btn href="{{ route('admin.ticket-statuses.show',$status->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('ticket_status_edit')<x-admin-action-btn href="{{ route('admin.ticket-statuses.edit',$status->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('ticket_status_delete')<x-admin-action-btn href="{{ route('admin.ticket-statuses.destroy',$status->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
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
$(document).ready(function(){$('.datatable-TicketStatus').DataTable({pageLength:25,order:[[1,'asc']]});});
</script>
@stop
