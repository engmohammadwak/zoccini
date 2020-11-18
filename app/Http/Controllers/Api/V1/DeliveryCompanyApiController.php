<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryCompanyResource;
use App\Models\DeliveryCompany;
use Illuminate\Http\Request;

class DeliveryCompanyApiController extends Controller
{

    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $data = DeliveryCompanyResource::collection(DeliveryCompany::where('status' , 1)->get());
        return successResponse(trans('cruds.api.success') , $data);
    }}
