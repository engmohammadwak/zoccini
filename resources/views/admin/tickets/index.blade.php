@extends('layouts.admin')
@section('content')
<div style="min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.ticket.title')"
        icon="fas fa-headset"
        color="teal"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.ticket.title')],
        ]"
    />

    @php
        $total  = $tickets->count();
        $open   = $tickets->whereIn('status',['open',0,1])->count();
        $closed = $tickets->whereIn('status',['closed',2,3])->count();
        $urgent = $tickets->whereIn('priority',['high','urgent'])->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:22px;">
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#0d9488,#14b8a6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-headset"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $total }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Total</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-door-open"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $open }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Open</div></div>
        </div>
        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-check-circle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $closed }}</div><div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">Closed</div></div>
        </div>
        <div style="background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(239,68,68,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;"><i class="fas fa-exclamation-triangle"></i></div>
            <div><div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $urgent }}</div><div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">Urgent</div></div>
        </div>
    </div>

    <x-admin-table
        :title="trans('cruds.ticket.title')"
        icon="fas fa-headset"
        color="teal"
        datatableClass="datatable-Ticket"
        :count="$tickets->count()"
        :createRoute="route('admin.tickets.create')"
        createPermission="ticket_create"
        :createLabel="trans('global.add').' Ticket'"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>#</th>
                <th>User</th>
                <th>Subject</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Date</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($tickets as $ticket)
            @php
                $priorityMap = [
                    'low'    => ['bg'=>'#f0fdf4','color'=>'#166534'],
                    'medium' => ['bg'=>'#fef9c3','color'=>'#854d0e'],
                    'high'   => ['bg'=>'#fee2e2','color'=>'#991b1b'],
                    'urgent' => ['bg'=>'#fce7f3','color'=>'#9d174d'],
                ];
                $statusMap = [
                    'open'        => ['bg'=>'#dbeafe','color'=>'#1e40af'],
                    'in_progress' => ['bg'=>'#fef9c3','color'=>'#854d0e'],
                    'closed'      => ['bg'=>'#dcfce7','color'=>'#166534'],
                ];
                $pr = $ticket->priority ?? 'medium';
                $st = $ticket->status   ?? 'open';
                $pm = $priorityMap[$pr] ?? ['bg'=>'#f1f5f9','color'=>'#475569'];
                $sm = $statusMap[$st]   ?? ['bg'=>'#f1f5f9','color'=>'#475569'];
            @endphp
            <tr data-entry-id="{{ $ticket->id }}">
                <td></td>
                <td><span style="font-weight:700;color:#0d9488;font-size:0.88rem;">#{{ $ticket->id }}</span></td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <x-admin-avatar :name="optional($ticket->user)->name ?? 'U'" color="teal" />
                        <span style="font-size:0.83rem;color:#1e293b;font-weight:600;">{{ optional($ticket->user)->name ?? '—' }}</span>
                    </span>
                </td>
                <td style="font-weight:600;color:#1e293b;font-size:0.85rem;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $ticket->subject ?? $ticket->title ?? '—' }}</td>
                <td><span style="background:{{ $pm['bg'] }};color:{{ $pm['color'] }};padding:3px 9px;border-radius:7px;font-weight:600;font-size:0.78rem;">{{ ucfirst($pr) }}</span></td>
                <td><span style="background:{{ $sm['bg'] }};color:{{ $sm['color'] }};padding:3px 9px;border-radius:7px;font-weight:600;font-size:0.78rem;">{{ ucfirst(str_replace('_',' ',$st)) }}</span></td>
                <td style="font-size:0.8rem;color:#94a3b8;">{{ optional($ticket->created_at)->format('d/m/Y') }}</td>
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
<script>
$(function(){
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Ticket:not(.ajaxTable)').DataTable({buttons:$.extend(true,[],$.fn.dataTable.defaults.buttons)});
});
</script>
@endsection
