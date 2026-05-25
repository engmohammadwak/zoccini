@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f4f6fb;min-height:100vh;padding:24px;">
    <x-admin-page-header title="Ticket Statuses" icon="fas fa-tag" color="indigo" :breadcrumbs="[['label'=>trans('global.dashboard'),'url'=>route('admin.home')],['label'=>'Ticket Statuses']]" />
    <x-admin-table title="Ticket Statuses List" icon="fas fa-tag" color="indigo" datatableClass="datatable-TicketStatus" :count="$ticketStatuses->count()" :createRoute="route('admin.ticket-statuses.create')" createLabel="Add Status">
        <x-slot name="thead"><tr><th width="10"></th><th>Name</th><th>Color</th><th>&nbsp;</th></tr></x-slot>
        <x-slot name="tbody">
            @foreach($ticketStatuses as $status)
            <tr data-entry-id="{{ $status->id }}">
                <td></td>
                <td>{{ $status->name ?? '' }}</td>
                <td>@if($status->color)<span style="display:inline-block;width:18px;height:18px;border-radius:50%;background:{{ $status->color }};vertical-align:middle;margin-left:5px;"></span> {{ $status->color }}@endif</td>
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
<script>$(function(){$.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:100});$('.datatable-TicketStatus:not(.ajaxTable)').DataTable({buttons:[]});});</script>
@endsection
