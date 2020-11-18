<?php

namespace App\Http\Requests;

use App\Models\SubscriptionUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySubscriptionUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('subscription_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:subscription_users,id',
        ];
    }
}
