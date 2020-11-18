<?php

namespace App\Http\Requests;

use App\Models\Otherbranch;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOtherbranchRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('otherbranch_edit');
    }

    public function rules()
    {
        return [
            'restaurants_id'    => [
                'required',
                'integer',
            ],
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
                'string',
                'nullable',
            ],
        ];
    }
}
