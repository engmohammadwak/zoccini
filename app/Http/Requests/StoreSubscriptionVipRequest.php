<?php

namespace App\Http\Requests;

use App\Models\SubscriptionVip;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSubscriptionVipRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_vip_create');
    }

    public function rules()
    {
        return [
            'start_day' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end_day'   => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'price'     => [
                'string',
                'nullable',
            ],
        ];
    }
}
