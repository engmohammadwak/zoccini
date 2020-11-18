<?php

namespace App\Http\Requests;

use App\Models\OrderStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOrderStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_status_create');
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
