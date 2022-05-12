<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketMessageResource;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tickets = Ticket::all();

        return view('admin.tickets.index', compact('tickets'));
    }


    public function show(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->load('user', 'status');
        $ticket_messages = TicketMessage::where('ticket_id', $ticket->id)->orderBy('id' , 'asc')->get();
        return view('admin.tickets.show', compact('ticket','ticket_messages'));
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

    public function replay(Request $request , $id)
    {

        $message = new TicketMessage();
        $message->ticket_id = $id;
        $message->user_id = Auth::id() ;
        $message->message = $request->message;
        $message->save() ;
        return back();
    }


    public function close(Request $request , $id)
    {

        $ticket =  Ticket::where('id' , $id)->first();
        $ticket->status_id = 3;
        $ticket->save() ;
        return back();
    }

}
