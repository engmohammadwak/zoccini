<?php

namespace App\Http\Requests;

use App\Models\Onbordering;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOnborderingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('onbordering_edit');
    }

    public function rules()
    {
        return [
            'name_ar'        => [
                'string',
                'required',
            ],
            'name_en'        => [
                'string',
                'required',
            ],
            'description_ar' => [
                'required',
            ],
            'description_en' => [
                'required',
            ],
        ];
    }
}
