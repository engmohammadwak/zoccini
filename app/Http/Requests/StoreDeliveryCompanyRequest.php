<?php

namespace App\Http\Requests;

use App\Models\DeliveryCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDeliveryCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('delivery_company_create');
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
            'rate'    => [
                'string',
                'nullable',
            ],
        ];
    }
}
