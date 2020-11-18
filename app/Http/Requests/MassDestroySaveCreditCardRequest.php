<?php

namespace App\Http\Requests;

use App\Models\SaveCreditCard;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySaveCreditCardRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('save_credit_card_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:save_credit_cards,id',
        ];
    }
}
