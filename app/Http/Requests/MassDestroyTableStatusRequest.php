<?php

namespace App\Http\Requests;

use App\Models\TableStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTableStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('table_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:table_statuses,id',
        ];
    }
}
