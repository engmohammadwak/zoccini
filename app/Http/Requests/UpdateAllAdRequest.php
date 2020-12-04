<?php

namespace App\Http\Requests;

use App\Models\AllAd;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAllAdRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('all_ad_edit');
    }

    public function rules()
    {
        return [
            'restaurant_id'   => [
                'nullable',
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
