<?php

namespace App\Http\Requests;

use App\Models\TableStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTableStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('table_status_create');
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
        ];
    }
}
