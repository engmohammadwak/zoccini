<?php

namespace App\Http\Requests;

use App\Models\Extra;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExtraRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('extra_edit');
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
            'price'   => [
                'string',
                'required',
            ],
            'item_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
