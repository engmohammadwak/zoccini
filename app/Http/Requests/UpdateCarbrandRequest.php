<?php

namespace App\Http\Requests;

use App\Models\Carbrand;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarbrandRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('carbrand_edit');
    }

    public function rules()
    {
        return [
            'name_ar' => [
                'string',
                'required',
                'unique:carbrands,name_ar,' . request()->route('carbrand')->id,
            ],
            'name_en' => [
                'string',
                'required',
                'unique:carbrands,name_en,' . request()->route('carbrand')->id,
            ],
        ];
    }
}
