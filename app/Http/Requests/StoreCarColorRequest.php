<?php

namespace App\Http\Requests;

use App\Models\CarColor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCarColorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('car_color_create');
    }

    public function rules()
    {
        return [
            'name_ar' => [
                'string',
                'required',
                'unique:car_colors',
            ],
            'name_en' => [
                'string',
                'required',
                'unique:car_colors',
            ],
        ];
    }
}
