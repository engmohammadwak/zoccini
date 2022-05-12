<?php

namespace App\Http\Requests;

use App\Models\TypeOfCar;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTypeOfCarRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('type_of_car_create');
    }

    public function rules()
    {
        return [
            'name_ar' => [
                'string',
                'required',
                'unique:type_of_cars',
            ],
            'name_en' => [
                'string',
                'required',
                'unique:type_of_cars',
            ],
        ];
    }
}
