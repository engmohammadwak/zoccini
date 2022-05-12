<?php

namespace App\Http\Requests;

use App\Models\TopRestaurant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTopRestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('top_restaurant_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'body'  => [
                'required',
            ],
        ];
    }
}
