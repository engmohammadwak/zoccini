<?php

namespace App\Http\Requests;

use App\Models\SaveCreditCard;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSaveCreditCardRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('save_credit_card_create');
    }

    public function rules()
    {
        return [
            'name'        => [
                'string',
                'nullable',
            ],
            'card_number' => [
                'string',
                'nullable',
            ],
            'month'       => [
                'string',
                'nullable',
            ],
            'year'        => [
                'string',
                'nullable',
            ],
            'cvc'         => [
                'string',
                'nullable',
            ],
        ];
    }
}
