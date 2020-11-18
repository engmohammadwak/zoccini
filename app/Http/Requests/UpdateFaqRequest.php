<?php

namespace App\Http\Requests;

use App\Models\Faq;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFaqRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('faq_edit');
    }

    public function rules()
    {
        return [
            'q_ar' => [
                'string',
                'required',
            ],
            'a_ar' => [
                'string',
                'required',
            ],
            'q_en' => [
                'string',
                'required',
            ],
            'a_en' => [
                'string',
                'required',
            ],
        ];
    }
}
