<?php

namespace App\Http\Requests;

use App\Models\SubscriptionUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubscriptionUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_user_edit');
    }

    public function rules()
    {
        return [
            'user_id'    => [
                'required',
                'integer',
            ],
            'package_id' => [
                'required',
                'integer',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_day'    => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'price'      => [
                'string',
                'nullable',
            ],
        ];
    }
}
