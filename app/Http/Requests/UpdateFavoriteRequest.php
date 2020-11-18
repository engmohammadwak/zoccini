<?php

namespace App\Http\Requests;

use App\Models\Favorite;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFavoriteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('favorite_edit');
    }

    public function rules()
    {
        return [];
    }
}
