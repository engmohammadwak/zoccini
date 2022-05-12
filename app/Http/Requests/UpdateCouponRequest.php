<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCouponRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_edit');
    }

    public function rules()
    {
        return [
            'code'          => [
                'string',
                'required',
            ],
            'value'         => [
                'string',
                'required',
            ],
            'status'        => [
                'required',
            ],
            'maximum_usage' => [
                'string',
                'required',
            ],
            'start_day'     => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
//            'type'          => [
//                'required',
//            ],
        ];
    }
}
