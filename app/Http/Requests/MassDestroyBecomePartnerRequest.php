<?php

namespace App\Http\Requests;

use App\Models\BecomePartner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBecomePartnerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('become_partner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:become_partners,id',
        ];
    }
}
