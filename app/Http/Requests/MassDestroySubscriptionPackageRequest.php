<?php

namespace App\Http\Requests;

use App\Models\SubscriptionPackage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySubscriptionPackageRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('subscription_package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:subscription_packages,id',
        ];
    }
}
