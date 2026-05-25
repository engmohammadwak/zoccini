@extends('layouts.admin')
@section('content')

<style>
/* ── Tickets Page ── */
.tickets-page-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.tickets-page-title {
    font-size: 1.35rem; font-weight: 700; color: #1a1f2e;
    display: flex; align-items: center; gap: 10px;
}
.tickets-page-title .title-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1rem;
    box-shadow: 0 4px 12px rgba(14,165,233,0.35);
}

.tickets-card {
    background: #fff; border-radius: 14px;
    border: 1px solid #e8ecf4;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06); overflow: hidden;
}
.tickets-card-header {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-bottom: 1px solid #bae6fd;
    padding: 16px 20px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
}
.tickets-card-header-title {
    font-size: 0.92rem; font-weight: 700; color: #1a1f2e;
    display: flex; align-items: center; gap: 8px;
}
.tickets-card-header-title i { color: #0ea5e9; }
.tickets-card-body { padding: 20px; }

/* Table */
.tickets-table-wrap { overflow-x: auto; border-radius: 10px; border: 1px solid #eef0f8; }
.tickets-table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
.tickets-table thead tr:first-child th {
    background: #f0f9ff; color: #0a4a70;
    font-weight: 700; font-size: 0.76rem;
    text-transform: uppercase; letter-spacing: 0.5px;
    padding: 12px 14px; border-bottom: 2px solid #bae6fd; white-space: nowrap;
}
.tickets-table tbody tr { border-bottom: 1px solid #f0f5fa; transition: background 0.15s; }
.tickets-table tbody tr:last-child { border-bottom: none; }
.tickets-table tbody tr:hover { background: #f0f9ff; }
.tickets-table tbody td { padding: 13px 14px; color: #2d3250; vertical-align: middle; }

/* ID badge */
.ticket-id-badge {
    display: inline-flex; align-items: center; justify-content: center;
    background: #e0f2fe; color: #0284c7;
    font-weight: 700; font-size: 0.8rem;
    border-radius: 7px; padding: 3px 10px; min-width: 38px;
}

/* Title cell */
.ticket-title-cell { max-width: 200px; }
.ticket-title-text {
    font-weight: 600; color: #1a1f2e; font-size: 0.85rem;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 180px; display: block;
}

/* User cell */
.ticket-user-cell { display: flex; align-items: center; gap: 8px; }
.ticket-user-av {
    width: 30px; height: 30px; border-radius: 50%;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 0.72rem; font-weight: 700; flex-shrink: 0;
}
.ticket-user-name { font-size: 0.83rem; font-weight: 600; color: #2d3250; }

/* Status badges */
.ticket-status {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 20px;
    font-size: 0.75rem; font-weight: 600; white-space: nowrap;
}
.ticket-status::before {
    content: ''; width: 6px; height: 6px;
    border-radius: 50%; background: currentColor; opacity: 0.8;
}
.t-status-open     { background: #dbeafe; color: #1d4ed8; }
.t-status-progress { background: #fef3c7; color: #b45309; }
.t-status-closed   { background: #f1f5f9; color: #64748b; }
.t-status-default  { background: #f0f2fa; color: #4a5080; }

/* Star rating */
.ticket-stars { color: #f59e0b; font-size: 0.82rem; letter-spacing: 1px; white-space: nowrap; }
.ticket-stars .empty-star { color: #d1d5db; }

/* Date / Last message */
.ticket-date {
    font-size: 0.77rem; color: #7a80a0; white-space: nowrap;
    display: flex; align-items: center; gap: 4px;
}
.ticket-date i { color: #0ea5e9; font-size: 0.7rem; }

/* Admin name chip */
.ticket-admin-chip {
    display: inline-flex; align-items: center; gap: 4px;
    background: #ede9fe; color: #5b21b6;
    border-radius: 20px; padding: 3px 9px;
    font-size: 0.74rem; font-weight: 600;
}

/* Comment */
.ticket-comment {
    max-width: 140px; font-size: 0.78rem; color: #6b7280;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    display: block;
}

/* Action buttons */
.ticket-actions { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.btn-ticket-view {
    display:inline-flex;align-items:center;gap:4px;padding:5px 12px;
    background:linear-gradient(135deg,#0ea5e9,#0284c7);
    color:#fff !important;border-radius:7px;font-size:0.75rem;font-weight:600;
    text-decoration:none;border:none;cursor:pointer;
    box-shadow:0 2px 6px rgba(14,165,233,0.3);transition:opacity 0.2s,transform 0.15s;
}
.btn-ticket-close {
    display:inline-flex;align-items:center;gap:4px;padding:5px 12px;
    background:linear-gradient(135deg,#f87171,#ef4444);
    color:#fff !important;border-radius:7px;font-size:0.75rem;font-weight:600;
    text-decoration:none;border:none;cursor:pointer;
    box-shadow:0 2px 6px rgba(239,68,68,0.25);transition:opacity 0.2s,transform 0.15s;
}
.btn-ticket-view:hover, .btn-ticket-close:hover {
    opacity:0.85; transform:translateY(-1px);
    color:#fff !important; text-decoration:none;
}

/* DataTables */
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #bae6fd !important; border-radius: 8px !important;
    padding: 6px 12px !important; font-size: 0.83rem !important;
}
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.12) !important; outline: none !important;
}
.dataTables_wrapper .dataTables_length select {
    border: 1px solid #bae6fd !important; border-radius: 8px !important;
    padding: 4px 8px !important; font-size: 0.83rem !important;
}
.dataTables_wrapper .paginate_button.current,
.dataTables_wrapper .paginate_button.current:hover {
    background: linear-gradient(135deg,#0ea5e9,#0284c7) !important;
    color: #fff !important; border: none !important; border-radius: 7px !important;
}
</style>

<div class="content-wrapper" style="background:#f4f6fb; min-height:100vh; padding:24px;">

    {{-- Page Header --}}
    <div class="tickets-page-header">
        <div class="tickets-page-title">
            <div class="title-icon"><i class="fas fa-headset"></i></div>
            {{ trans('cruds.ticket.title') }}
        </div>
        <nav aria-label="breadcrumb" style="font-size:0.8rem;">
            <ol class="breadcrumb mb-0" style="background:transparent;padding:0;">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}" style="color:#0ea5e9;">{{ trans('global.dashboard') }}</a></li>
                <li class="breadcrumb-item active" style="color:#7a80a0;">{{ trans('cruds.ticket.title') }}</li>
            </ol>
        </nav>
    </div>

    {{-- Main Card --}}
    <div class="tickets-card">
        <div class="tickets-card-header">
            <div class="tickets-card-header-title">
                <i class="fas fa-ticket-alt"></i>
                {{ trans('cruds.ticket.title_singular') }} {{ trans('global.list') }}
                <span style="background:#e0f2fe;color:#0284c7;font-size:0.72rem;font-weight:700;padding:2px 10px;border-radius:20px;margin-inline-start:4px;">
                    {{ $tickets->count() }}
                </span>
            </div>
            <span style="font-size:0.78rem;color:#5aa0c0;">
                <i class="fas fa-sync-alt" style="margin-left:4px;"></i>
                {{ now()->translatedFormat('d/m/Y H:i') }}
            </span>
        </div>

        <div class="tickets-card-body">
            <div class="tickets-table-wrap">
                <table class="tickets-table table datatable datatable-Ticket">
                    <thead>
                    <tr>
                        <th width="10"></th>
                        <th>{{ trans('cruds.ticket.fields.id') }}</th>
                        <th>{{ trans('cruds.ticket.fields.user') }}</th>
                        <th>{{ trans('cruds.ticket.fields.title') }}</th>
                        <th>{{ trans('cruds.ticket.fields.status') }}</th>
                        <th>{{ trans('cruds.ticket.fields.rate') }}</th>
                        <th>{{ trans('cruds.last_message') }}</th>
                        <th>{{ trans('cruds.admin_last_message') }}</th>
                        <th>{{ trans('cruds.ticket.fields.comment') }}</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        @php
                            $statusId   = $ticket->status_id ?? 0;
                            $statusName = App::getLocale() == 'ar' ? optional($ticket->status)->name_ar : optional($ticket->status)->name_en;
                            $statusClass = match(true) {
                                $statusId == 1 => 't-status-open',
                                $statusId == 2 => 't-status-progress',
                                $statusId == 3 => 't-status-closed',
                                default        => 't-status-default',
                            };
                            $rate = $ticket->rate ?? 0;
                            $lastMsg = \App\Models\TicketMessage::where('ticket_id', $ticket->id)->latest('id')->first();
                        @endphp
                        <tr data-entry-id="{{ $ticket->id }}">
                            <td></td>
                            <td><span class="ticket-id-badge">#{{ $ticket->id }}</span></td>
                            <td>
                                <div class="ticket-user-cell">
                                    <div class="ticket-user-av">
                                        {{ strtoupper(mb_substr(optional($ticket->user)->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="ticket-user-name">{{ optional($ticket->user)->name ?? '—' }}</span>
                                </div>
                            </td>
                            <td class="ticket-title-cell">
                                <span class="ticket-title-text" title="{{ $ticket->title }}">{{ $ticket->title ?? '—' }}</span>
                            </td>
                            <td>
                                <span class="ticket-status {{ $statusClass }}">{{ $statusName ?? '—' }}</span>
                            </td>
                            <td>
                                @if($rate > 0)
                                    <span class="ticket-stars">
                                        @for($s = 1; $s <= 5; $s++)
                                            @if($s <= $rate)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star empty-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                @else
                                    <span style="color:#d1d5db;font-size:0.78rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($lastMsg)
                                    <span class="ticket-date">
                                        <i class="far fa-clock"></i>
                                        {{ $lastMsg->created_at->diffForHumans() }}
                                    </span>
                                @else
                                    <span style="color:#d1d5db;font-size:0.78rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($lastMsg && $lastMsg->user)
                                    <span class="ticket-admin-chip">
                                        <i class="fas fa-user-shield" style="font-size:0.65rem;"></i>
                                        {{ $lastMsg->user->name }}
                                    </span>
                                @else
                                    <span style="color:#d1d5db;font-size:0.78rem;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->comment)
                                    <span class="ticket-comment" title="{{ $ticket->comment }}">{{ $ticket->comment }}</span>
                                @else
                                    <span style="color:#d1d5db;font-size:0.78rem;">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="ticket-actions">
                                    @can('ticket_show')
                                        <a class="btn-ticket-view" href="{{ route('admin.tickets.show', $ticket->id) }}">
                                            <i class="fas fa-eye"></i> {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @if($ticket->status_id != 3)
                                        <a class="btn-ticket-close" href="{{ route('admin.tickets.close', $ticket->id) }}">
                                            <i class="fas fa-times-circle"></i> {{ trans('global.close') }}
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            @can('ticket_delete')
            let deleteButton = {
                text: '{{ trans('global.datatables.delete') }}',
                url: "{{ route('admin.tickets.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id');
                    });
                    if (ids.length === 0) { alert('{{ trans('global.datatables.zero_selected') }}'); return; }
                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: { 'x-csrf-token': _token },
                            method: 'POST', url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        }).done(function () { location.reload(); });
                    }
                }
            };
            dtButtons.push(deleteButton);
            @endcan
            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true, order: [[1, 'desc']], pageLength: 100,
            });
            let table = $('.datatable-Ticket:not(.ajaxTable)').DataTable({ buttons: dtButtons });
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function () {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
        });
    </script>
@endsection
