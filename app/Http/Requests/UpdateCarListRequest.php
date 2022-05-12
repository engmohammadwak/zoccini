<?php

namespace App\Http\Requests;

use App\Models\CarList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarListRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('car_list_edit');
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
