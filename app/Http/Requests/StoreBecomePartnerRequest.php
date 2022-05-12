<?php

namespace App\Http\Requests;

use App\Models\BecomePartner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBecomePartnerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('become_partner_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'body'  => [
                'required',
            ],
        ];
    }
}
