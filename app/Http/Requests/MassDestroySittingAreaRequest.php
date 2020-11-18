<?php

namespace App\Http\Requests;

use App\Models\SittingArea;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySittingAreaRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sitting_area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:sitting_areas,id',
        ];
    }
}
