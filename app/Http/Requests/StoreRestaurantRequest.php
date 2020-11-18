<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('restaurant_create');
    }

    public function rules()
    {
        return [
            'name_ar'              => [
                'string',
                'required',
            ],
            'name_en'              => [
                'string',
                'required',
            ],
            'mins'                 => [
                'string',
                'nullable',
            ],
            'payment_methods.*'    => [
                'integer',
            ],
            'payment_methods'      => [
                'array',
            ],
            'tag'                  => [
                'string',
                'nullable',
            ],
            'sitting_areas.*'      => [
                'integer',
            ],
            'sitting_areas'        => [
                'array',
            ],
            'address'              => [
                'string',
                'nullable',
            ],
            'opening_time'         => [
                'string',
                'nullable',
            ],
            'number_of_employees'  => [
                'string',
                'nullable',
            ],
            'number_branches'      => [
                'string',
                'nullable',
            ],
            'subscription_package' => [
                'string',
                'nullable',
            ],
            'open_time'            => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'close_time'           => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'min_waiting'          => [
                'string',
                'nullable',
            ],
            'max_waiting'          => [
                'string',
                'nullable',
            ],
        ];
    }
}
