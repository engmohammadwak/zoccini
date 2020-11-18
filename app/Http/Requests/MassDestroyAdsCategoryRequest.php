<?php

namespace App\Http\Requests;

use App\Models\AdsCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAdsCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ads_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ads_categories,id',
        ];
    }
}
