<?php

namespace App\Http\Requests;

use App\Models\SittingArea;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSittingAreaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sitting_area_create');
    }

    public function rules()
    {
        return [
            'name_ar' => [
                'string',
                'required',
            ],
            'name_en' => [
                'string',
                'required',
            ],
        ];
    }
}
