@extends('layouts.admin')
@section('content')
<div class="content-wrapper" style="background:#f0f2f8;min-height:100vh;padding:24px;">

    <x-admin-page-header
        :title="trans('cruds.ticket.title')"
        icon="fas fa-headset"
        color="indigo"
        :breadcrumbs="[
            ['label' => trans('global.dashboard'), 'url' => route('admin.home')],
            ['label' => trans('cruds.ticket.title')],
        ]"
    />

    {{-- ===== Stats Cards ===== --}}
    @php
        $totalT   = $tickets->count();
        $openT    = $tickets->where('status','open')->count();
        $closedT  = $tickets->where('status','closed')->count();
        $pendingT = $tickets->where('status','pending')->count();
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:22px;">

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#6366f1,#818cf8);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-headset"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $totalT }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('cruds.ticket.title') }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#10b981,#34d399);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-envelope-open"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $openT }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.open') ?? 'Open' }}</div>
            </div>
        </div>

        <div style="background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 2px 10px rgba(0,0,0,0.06);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:linear-gradient(135deg,#f59e0b,#fbbf24);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#1e293b;line-height:1;">{{ $pendingT }}</div>
                <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">{{ trans('global.pending') ?? 'Pending' }}</div>
            </div>
        </div>

        <div style="background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(99,102,241,0.3);display:flex;align-items:center;gap:12px;">
            <div style="width:42px;height:42px;border-radius:11px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;flex-shrink:0;">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <div style="font-size:1.4rem;font-weight:800;color:#fff;line-height:1;">{{ $closedT }}</div>
                <div style="font-size:0.72rem;color:rgba(255,255,255,0.75);margin-top:2px;">{{ trans('global.closed') ?? 'Closed' }}</div>
            </div>
        </div>

    </div>

    {{-- ===== Table ===== --}}
    <x-admin-table
        :title="trans('cruds.ticket.title_singular').' '.trans('global.list')"
        icon="fas fa-headset"
        color="indigo"
        datatableClass="datatable-Ticket"
        :count="$tickets->count()"
        :createRoute="route('admin.tickets.create')"
        :createLabel="trans('global.add').' '.trans('cruds.ticket.title_singular')"
    >
        <x-slot name="thead">
            <tr>
                <th width="10"></th>
                <th>#</th>
                <th>{{ trans('cruds.ticket.fields.subject') ?? 'Subject' }}</th>
                <th>{{ trans('cruds.ticket.fields.user') ?? 'User' }}</th>
                <th>{{ trans('cruds.ticket.fields.status') ?? 'Status' }}</th>
                <th>{{ trans('global.created_at') ?? 'Date' }}</th>
                <th>&nbsp;</th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach($tickets as $ticket)
            <tr data-entry-id="{{ $ticket->id }}">
                <td></td>
                <td>
                    <span style="background:linear-gradient(135deg,#e0e7ff,#ede9fe);color:#4338ca;padding:3px 10px;border-radius:8px;font-weight:700;font-size:0.8rem;">
                        #{{ $ticket->id }}
                    </span>
                </td>
                <td>
                    <span style="font-weight:600;color:#1e293b;font-size:0.85rem;display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-ticket-alt" style="color:#a5b4fc;font-size:0.72rem;"></i>
                        {{ $ticket->subject ?? '' }}
                    </span>
                </td>
                <td>
                    <span style="display:flex;align-items:center;gap:8px;">
                        <x-admin-avatar :name="optional($ticket->user)->name ?? 'U'" color="indigo" />
                        <span style="font-size:0.83rem;color:#475569;">{{ optional($ticket->user)->name ?? '' }}</span>
                    </span>
                </td>
                <td>
                    @php
                        $tMap = [
                            'open'    => ['bg'=>'#dcfce7','color'=>'#166534','icon'=>'fa-envelope-open'],
                            'closed'  => ['bg'=>'#f1f5f9','color'=>'#64748b','icon'=>'fa-check-double'],
                            'pending' => ['bg'=>'#fef9c3','color'=>'#854d0e','icon'=>'fa-clock'],
                        ];
                        $tm = $tMap[$ticket->status ?? ''] ?? ['bg'=>'#f1f5f9','color'=>'#64748b','icon'=>'fa-circle'];
                    @endphp
                    <span style="background:{{ $tm['bg'] }};color:{{ $tm['color'] }};padding:3px 10px;border-radius:8px;font-weight:600;font-size:0.78rem;display:inline-flex;align-items:center;gap:5px;">
                        <i class="fas {{ $tm['icon'] }}"></i>
                        {{ $ticket->status ?? '' }}
                    </span>
                </td>
                <td style="color:#94a3b8;font-size:0.8rem;white-space:nowrap;">
                    <i class="far fa-calendar-alt" style="margin-left:4px;color:#cbd5e1;"></i>
                    {{ optional($ticket->created_at)->format('d/m/Y') ?? '' }}
                    <span style="display:block;font-size:0.72rem;color:#cbd5e1;">{{ optional($ticket->created_at)->format('H:i') ?? '' }}</span>
                </td>
                <td style="display:flex;gap:5px;flex-wrap:wrap;">
                    @can('ticket_show')
                    <x-admin-action-btn href="{{ route('admin.tickets.show',$ticket->id) }}" icon="fas fa-eye" :label="trans('global.view')" color="blue" />
                    @endcan
                    @can('ticket_edit')
                    <x-admin-action-btn href="{{ route('admin.tickets.edit',$ticket->id) }}" icon="fas fa-edit" :label="trans('global.edit')" color="orange" />
                    @endcan
                    @can('ticket_delete')
                    <x-admin-action-btn href="{{ route('admin.tickets.destroy',$ticket->id) }}" icon="fas fa-trash" color="red" method="DELETE" />
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
    $.extend(true,$.fn.dataTable.defaults,{orderCellsTop:true,order:[[1,'desc']],pageLength:25});
    $('.datatable-Ticket:not(.ajaxTable)').DataTable({buttons:[]});
});
</script>
@endsection
