<?php

namespace App\Http\Requests;

use App\Models\SubscriptionPackage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubscriptionPackageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscription_package_edit');
    }

    public function rules()
    {
        return [
            'name'            => [
                'string',
                'required',
            ],
            'description'     => [
                'required',
            ],
            'price'           => [
                'string',
                'required',
            ],
            'duration'        => [
                'string',
                'required',
            ],
            'number_branches' => [
                'string',
                'required',
            ],
            'file_size'       => [
                'string',
                'required',
            ],
        ];
    }
}
