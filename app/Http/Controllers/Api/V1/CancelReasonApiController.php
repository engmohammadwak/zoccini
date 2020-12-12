<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CancelReasonResource;
use App\Models\CancelReason;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CancelReasonApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = CancelReasonResource::collection(CancelReason::all());
        return successResponse(trans('cruds.api.success') , $data);
    }
}
