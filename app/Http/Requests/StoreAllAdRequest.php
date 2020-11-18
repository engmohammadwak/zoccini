<?php

namespace App\Http\Requests;

use App\Models\AllAd;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAllAdRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('all_ad_create');
    }

    public function rules()
    {
        return [
            'restaurant_id'   => [
                'required',
                'integer',
            ],
            'number_requests' => [
                'string',
                'nullable',
            ],
            'voucher_number'  => [
                'string',
                'nullable',
            ],
            'category_id'     => [
                'required',
                'integer',
            ],
            'discount'        => [
                'string',
                'nullable',
            ],
            'withdraw_day'    => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
