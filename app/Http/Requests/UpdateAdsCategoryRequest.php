<?php

namespace App\Http\Requests;

use App\Models\AdsCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdsCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ads_category_edit');
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
