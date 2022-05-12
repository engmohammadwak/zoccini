<?php

namespace App\Http\Requests;

use App\Models\Item;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('item_create');
    }

    public function rules()
    {
        return [
            'name_en'           => [
                'string',
                'required',
            ],
            'name_ar'        => [
                'string',
                'required',
            ],
            'description_en'    => [
                'required',
            ],
            'description_ar' => [
                'string',
                'required',
            ],
            'photo.*'        => [
                'required',
            ],
            'price'          => [
                'string',
                'nullable',
            ],
        ];
    }
}
