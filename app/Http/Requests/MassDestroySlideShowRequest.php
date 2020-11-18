<?php

namespace App\Http\Requests;

use App\Models\SlideShow;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySlideShowRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('slide_show_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:slide_shows,id',
        ];
    }
}
