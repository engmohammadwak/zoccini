<?php

namespace App\Http\Requests;

use App\Models\SubscriptionVip;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySubscriptionVipRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('subscription_vip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:subscription_vips,id',
        ];
    }
}
