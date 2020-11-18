<?php

namespace App\Http\Requests;

use App\Models\Delivery;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('delivery_edit');
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
