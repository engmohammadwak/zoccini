<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('category_edit');
    }

    public function rules()
    {
        return [
            'name_en'       => [
                'string',
                'required',
                'unique:categories,name_en,' . request()->route('category')->id,
            ],
            'name_ar'       => [
                'string',
                'required',
                'unique:categories,name_ar,' . request()->route('category')->id,
            ],
            'restaurant_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
