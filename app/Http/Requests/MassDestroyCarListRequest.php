<?php

namespace App\Http\Requests;

use App\Models\CarList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCarListRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('car_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:car_lists,id',
        ];
    }
}
