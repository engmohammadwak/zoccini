<?php

namespace App\Http\Requests;

use App\Models\CanselReason;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCanselReasonRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('cansel_reason_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:cansel_reasons,id',
        ];
    }
}
