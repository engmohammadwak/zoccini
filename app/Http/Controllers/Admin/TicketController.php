<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->all());

        return redirect()->route('admin.tickets.index');
    }

    public function edit(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->load('user', 'status');

        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->all());

        return redirect()->route('admin.tickets.index');
    }

    public function show(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->load('user', 'status');

        return view('admin.tickets.show', compact('ticket'));
    }

    public function destroy(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketRequest $request)
    {
        Ticket::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
