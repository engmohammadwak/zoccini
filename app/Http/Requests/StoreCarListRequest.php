<?php

namespace App\Http\Requests;

use App\Models\CarList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCarListRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('car_list_create');
    }

    public function rules()
    {
        return [
            'pate_number' => [
                'string',
                'nullable',
            ],
        ];
    }
}
