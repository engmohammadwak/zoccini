<?php

namespace App\Http\Requests;

use App\Models\Otherbranch;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOtherbranchRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('otherbranch_create');
    }

    public function rules()
    {
        return [


            'branch_name_ar'    => [
                'string',
                'nullable',
            ],
            'branch_name_en'    => [
                'string',
                'nullable',
            ],
            'branch_address_ar' => [
                'string',
                'nullable',
            ],
            'branch_address_en' => [
                'string',
                'nullable',
            ],
            'phone'             => [
                'string',
                'nullable',
            ],
            'email'             => [
                'required',
                'unique:users',
            ],
        ];
    }
}
