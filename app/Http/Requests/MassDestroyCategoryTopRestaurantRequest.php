<?php

namespace App\Http\Requests;

use App\Models\CategoryTopRestaurant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCategoryTopRestaurantRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('category_top_restaurant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:category_top_restaurants,id',
        ];
    }
}
