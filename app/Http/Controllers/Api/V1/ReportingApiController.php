<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportingRequest;
use App\Http\Requests\UpdateReportingRequest;
use App\Http\Resources\ReportingResource;
use App\Http\Resources\CarListResource;
use App\Models\CarList;
use App\Models\Reporting;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ReportingApiController extends Controller
{

    public function store(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }
        $request->request->add(['user_id' => Auth::id(), 'type' => 0]);
        $report = Reporting::create($request->all());
        $data = new ReportingResource($report);

        alert_user($request->message ,url('admin/reportings/'.$report->id) );

        return successResponse(trans('cruds.api.success'), $data);
    }


    public function note(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validator = $this->validator($request);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->first());
        }
        $request->request->add(['user_id' => Auth::id(), 'type'=> 1]);
        $data = new ReportingResource(Reporting::create($request->all()));
        return successResponse(trans('cruds.api.success'), $data);
    }

    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'message' => 'required',
        ]);
    }
}
