<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'name'               => [
                'string',
                'required',
            ],
            'last_name'          => [
                'string',
                'required',
            ],
            'phone'              => [
                'string',
                'required',
            ],
            'email'              => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
            ],
            'roles.*'            => [
                'integer',
            ],
            'roles'              => [
                'required',
                'array',
            ],
            'date_of_birth'      => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'gender'             => [
                'string',
                'nullable',
            ],
            'sms_subscription'   => [
                'string',
                'nullable',
            ],
            'email_subscription' => [
                'string',
                'nullable',
            ],
        ];
    }
}
