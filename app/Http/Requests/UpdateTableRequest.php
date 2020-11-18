<?php

namespace App\Http\Requests;

use App\Models\Table;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTableRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('table_edit');
    }

    public function rules()
    {
        return [
            'number'          => [
                'string',
                'required',
            ],
            'sitting_area_id' => [
                'required',
                'integer',
            ],
            'chares'          => [
                'string',
                'required',
            ],
            'status_id'       => [
                'required',
                'integer',
            ],
        ];
    }
}
