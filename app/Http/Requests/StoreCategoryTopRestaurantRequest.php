<?php

namespace App\Http\Requests;

use App\Models\CategoryTopRestaurant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCategoryTopRestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('category_top_restaurant_create');
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
