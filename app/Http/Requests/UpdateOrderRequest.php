<?php

namespace App\Http\Requests;

use App\Models\Order;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    public function rules()
    {
        return [
            'restaurants_id' => [
                'required',
                'integer',
            ],
            'user_id'        => [
                'required',
                'integer',
            ],
            'type_id'        => [
                'required',
                'integer',
            ],
            'number_people'  => [
                'string',
                'nullable',
            ],
            'schedule_date'  => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'items.*'        => [
                'integer',
            ],
            'items'          => [
                'array',
            ],
        ];
    }
}
