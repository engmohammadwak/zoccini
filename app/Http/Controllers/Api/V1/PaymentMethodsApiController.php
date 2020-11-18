<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodsApiController extends Controller
{

    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $data = PaymentMethodResource::collection(PaymentMethod::all());
        return successResponse(trans('cruds.api.success') , $data);
    }
}
