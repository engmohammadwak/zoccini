<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketMessageResource;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\UserAlert;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = TicketResource::collection(Ticket::where('user_id', Auth::id())->orderBy('id', 'desc')->get());
        return successResponse(trans('cruds.api.success'), $data);
    }

    public function message(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = TicketMessageResource::collection(TicketMessage::where('ticket_id', $id)->orderBy('id', 'desc')->get());
        return successResponse(trans('cruds.api.success'), $data);
    }

    public function store(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }
        $request->request->add(['user_id' => Auth::id(), 'status_id' => 1]);
        $ticket = Ticket::create($request->all());

        $message = new TicketMessage();
        $message->ticket_id = $ticket->id;
        $message->user_id = Auth::id();
        $message->message = $request->message;
        $message->save();

        alert_user($request->message ,url('admin/tickets/'.$ticket->id) );

        $data = new TicketResource($ticket);

        return successResponse(trans('cruds.api.success'), $data);
    }


    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'title' => 'required',
            'message' => 'required',
        ]);
    }

    public function rate(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->validator_rate($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }

        $ticket = Ticket::find($id);
        if ($ticket) {
            if ($ticket->rate)
            {
                return errorResponse('You have already rated it');

            }else{
                $ticket->rate = $request->rate;
                $ticket->comment = $request->comment;
                $ticket->status_id = 3;
                $ticket->save();
            }



            $data = new TicketResource($ticket);
        } else {
            return errorResponse('ticket not found');

        }


        return successResponse(trans('cruds.api.success'), $data);
    }


    private function validator_rate(Request $request)
    {
        return Validator::make($request->all(), [
            'rate' => 'required',
            'comment' => 'required',
        ]);
    }

    public function replay(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->validator_replay($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }

        $message = new TicketMessage();
        $message->ticket_id = $id;
        $message->user_id = Auth::id();
        $message->message = $request->message;
        $message->save();

        $data = new TicketMessageResource($message);

        alert_user($request->message ,url('admin/tickets/'.$id) );

        return successResponse(trans('cruds.api.success'), $data);
    }


    private function validator_replay(Request $request)
    {
        return Validator::make($request->all(), [
            'message' => 'required',
        ]);
    }


}
