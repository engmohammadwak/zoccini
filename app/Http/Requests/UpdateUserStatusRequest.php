<?php

namespace App\Http\Requests;

use App\Models\UserStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_status_edit');
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
