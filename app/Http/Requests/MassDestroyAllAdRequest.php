<?php

namespace App\Http\Requests;

use App\Models\AllAd;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAllAdRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('all_ad_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:all_ads,id',
        ];
    }
}
