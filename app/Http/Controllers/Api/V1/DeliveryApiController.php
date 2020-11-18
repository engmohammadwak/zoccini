<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryResource;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $data = DeliveryResource::collection(Delivery::all());
        return successResponse(trans('cruds.api.success') , $data);
    }
}
