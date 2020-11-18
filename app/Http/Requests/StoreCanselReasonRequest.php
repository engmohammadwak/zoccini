<?php

namespace App\Http\Requests;

use App\Models\CanselReason;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCanselReasonRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cansel_reason_create');
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
