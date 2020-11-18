<?php

namespace App\Http\Requests;

use App\Models\Address;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAddressRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('address_edit');
    }

    public function rules()
    {
        return [
            'nice_name'            => [
                'string',
                'nullable',
            ],
            'area'                 => [
                'string',
                'nullable',
            ],
            'street'               => [
                'string',
                'nullable',
            ],
            'building'             => [
                'string',
                'nullable',
            ],
            'floor'                => [
                'string',
                'nullable',
            ],
            'apartment_no'         => [
                'string',
                'nullable',
            ],
            'additional_direction' => [
                'string',
                'nullable',
            ],
            'landing_number'       => [
                'string',
                'nullable',
            ],
            'phone'                => [
                'string',
                'nullable',
            ],
            'lat'                  => [
                'string',
                'nullable',
            ],
            'lang'                 => [
                'string',
                'nullable',
            ],
            'main_address'         => [
                'string',
                'nullable',
            ],
        ];
    }
}
