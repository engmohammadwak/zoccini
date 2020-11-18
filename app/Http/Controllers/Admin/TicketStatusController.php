<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTicketStatusRequest;
use App\Http\Requests\StoreTicketStatusRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Models\TicketStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketStatuses = TicketStatus::all();

        return view('admin.ticketStatuses.index', compact('ticketStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketStatuses.create');
    }

    public function store(StoreTicketStatusRequest $request)
    {
        $ticketStatus = TicketStatus::create($request->all());

        return redirect()->route('admin.ticket-statuses.index');
    }

    public function edit(TicketStatus $ticketStatus)
    {
        abort_if(Gate::denies('ticket_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketStatuses.edit', compact('ticketStatus'));
    }

    public function update(UpdateTicketStatusRequest $request, TicketStatus $ticketStatus)
    {
        $ticketStatus->update($request->all());

        return redirect()->route('admin.ticket-statuses.index');
    }

    public function show(TicketStatus $ticketStatus)
    {
        abort_if(Gate::denies('ticket_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ticketStatuses.show', compact('ticketStatus'));
    }

    public function destroy(TicketStatus $ticketStatus)
    {
        abort_if(Gate::denies('ticket_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticketStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketStatusRequest $request)
    {
        TicketStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
