@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header :title="trans('cruds.ticket.title')" icon="fas fa-headset" color="indigo" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>trans('cruds.ticket.title')]]" />
    <x-admin-table :title="trans('cruds.ticket.title_singular').' '.trans('global.list')" icon="fas fa-headset" color="indigo" datatableClass="datatable-Ticket" :count="$tickets->count()" :createRoute="route('admin.tickets.create')" :createLabel="trans('global.add').' '.trans('cruds.ticket.title_singular')">
        <x-slot name="thead"><tr><th width="10"></th><th>#</th><th>Subject</th><th>User</th><th>Status</th><th>Date</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($tickets as $ticket)
            <tr data-entry-id="{{ $ticket->id }}">
                <td></td>
                <td><span style="background:#e0e7ff;color:#4338ca;padding:3px 10px;border-radius:7px;font-weight:700;font-size:0.8rem;">#{{ $ticket->id }}</span></td>
                <td>{{ $ticket->subject ?? '' }}</td>
                <td>{{ optional($ticket->user)->name ?? '' }}</td>
                <td><x-admin-status-badge :label="$ticket->status ?? ''" :type="$ticket->status=='open' ? 'success' : ($ticket->status=='closed' ? 'danger' : 'warning')" /></td>
                <td style="color:#7a80a0;font-size:0.82rem;">{{ optional($ticket->created_at)->format('d/m/Y H:i') ?? '' }}</td>
                <td style="display:flex;gap:5px;">
                    @can('ticket_show')<x-admin-action-btn href="{{ route('admin.tickets.show',$ticket->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />@endcan
                    @can('ticket_edit')<x-admin-action-btn href="{{ route('admin.tickets.edit',$ticket->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />@endcan
                    @can('ticket_delete')<x-admin-action-btn href="{{ route('admin.tickets.destroy',$ticket->id) }}" icon="fas fa-trash" color="red" method="DELETE" />@endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-admin-table>
</div>
@endsection
@section('scripts')
@parent
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-Ticket:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
