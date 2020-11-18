<?php

namespace App\Http\Requests;

use App\Models\Reporting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReportingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('reporting_edit');
    }

    public function rules()
    {
        return [];
    }
}
