<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarColorResource;
use App\Models\CarColor;
use Illuminate\Http\Request;

class CarColorApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = CarColorResource::collection(CarColor::all());
        return successResponse(trans('cruds.api.success') , $data);
    }
}
