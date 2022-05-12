@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.ticket.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Ticket">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.rate') }}
                        </th>
                        <th>
                            {{ trans('cruds.last_message') }}
                        </th>
                        <th>
                            {{ trans('cruds.admin_last_message') }}
                        </th>
                        <th>
                            {{ trans('cruds.ticket.fields.comment') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $key => $ticket)
                        <tr data-entry-id="{{ $ticket->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $ticket->id ?? '' }}
                            </td>
                            <td>
                                {{ $ticket->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $ticket->title ?? '' }}
                            </td>
                            <td>
                                {{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $ticket->status->name_ar : $ticket->status->name_en ?? '' }}
                            </td>
                            <td>
                                {{ $ticket->rate ?? '' }}
                            </td>
                            <td>
                                {{ optional(\App\Models\TicketMessage::where('ticket_id' , $ticket->id)->latest('id')->first())->created_at ?? '' }}
                            </td>
                            <td>
                                {{ optional(optional(\App\Models\TicketMessage::where('ticket_id' , $ticket->id)->latest('id')->first())->user)->name?? '' }}
                            </td>
                            <td>
                                {{ $ticket->comment ?? '' }}
                            </td>
                            <td>
                                @can('ticket_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.tickets.show', $ticket->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @if ($ticket->status_id != 3)
                                    <a class="btn btn-xs btn-danger"
                                       href="{{ route('admin.tickets.close', $ticket->id) }}">
                                        {{ trans('global.close') }}
                                    </a>
                                @endif

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                    @can('ticket_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.tickets.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-Ticket:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
