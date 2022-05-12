<?php

namespace App\Http\Requests;

use App\Models\Carbrand;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCarbrandRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('carbrand_create');
    }

    public function rules()
    {
        return [
            'name_ar' => [
                'string',
                'required',
                'unique:carbrands',
            ],
            'name_en' => [
                'string',
                'required',
                'unique:carbrands',
            ],
        ];
    }
}
