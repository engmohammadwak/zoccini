<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ticket_create');
    }

    public function rules()
    {
        return [
            'title'   => [
                'string',
                'nullable',
            ],
            'message' => [
                'string',
                'nullable',
            ],
            'comment' => [
                'string',
                'nullable',
            ],
        ];
    }
}
