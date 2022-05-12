<?php

namespace App\Http\Requests;

use App\Models\VentureCompany;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateVentureCompanyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('venture_company_edit');
    }

    public function rules()
    {
        return [
            'image' => [
                'nullable',
            ],
        ];
    }
}
