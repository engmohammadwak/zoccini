<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
//    public function authorize()
//    {
//        return Gate::allows('user_create');
//    }

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
                'unique:users',
                'min:9',
            ],
            'email'              => [
                'required',
                'unique:users',
            ],
            'password'           => [
                'required',
            ],
            'roles.*'            => [
                'integer',
            ],
            'roles'              => [
                'required',
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
