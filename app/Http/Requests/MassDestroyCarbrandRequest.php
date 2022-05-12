<?php

namespace App\Http\Requests;

use App\Models\Carbrand;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCarbrandRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('carbrand_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:carbrands,id',
        ];
    }
}
