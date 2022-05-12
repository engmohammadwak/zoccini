<?php

namespace App\Http\Requests;

use App\Models\SlideShow;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSlideShowRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('slide_show_edit');
    }

    public function rules()
    {
        return [
            'video_url' => [
                'string',
                'nullable',
            ],'product_restaurant_id' => [
                'int',
                'nullable',
            ],
        ];
    }
}
