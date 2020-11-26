<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityApiController extends Controller
{

    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $data = CityResource::collection(City::with(['countries'])->where('status' , 1)->get());
        return successResponse(trans('cruds.api.success') , $data);
    }
}
