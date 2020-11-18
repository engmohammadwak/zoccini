<?php

namespace App\Http\Requests;

use App\Models\Rate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rate_create');
    }

    public function rules()
    {
        return [
            'rating' => [
                'string',
                'nullable',
            ],
            'rate_1' => [
                'string',
                'nullable',
            ],
            'rate_2' => [
                'string',
                'nullable',
            ],
            'rate_3' => [
                'string',
                'nullable',
            ],
            'rate_4' => [
                'string',
                'nullable',
            ],
        ];
    }
}
