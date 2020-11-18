<?php

namespace App\Http\Requests;

use App\Models\TicketStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTicketStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ticket_status_create');
    }

    public function rules()
    {
        return [
            'name_ar' => [
                'string',
                'required',
            ],
            'name_en' => [
                'string',
                'required',
            ],
        ];
    }
}
