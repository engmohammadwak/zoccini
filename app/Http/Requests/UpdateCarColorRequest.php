<?php

namespace App\Http\Requests;

use App\Models\CarColor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarColorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('car_color_edit');
    }

    public function rules()
    {
        return [
            'name_ar' => [
                'string',
                'required',
                'unique:car_colors,name_ar,' . request()->route('car_color')->id,
            ],
            'name_en' => [
                'string',
                'required',
                'unique:car_colors,name_en,' . request()->route('car_color')->id,
            ],
        ];
    }
}
