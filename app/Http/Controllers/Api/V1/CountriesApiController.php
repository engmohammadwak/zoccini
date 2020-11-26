<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountriesApiController extends Controller
{

    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data =  CountryResource::collection(Country::with(['currency'])->where('status' , 1)->get());
        return successResponse(trans('cruds.api.success') , $data);

    }

    public function show(Request $request , Country $country)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data =  new CountryResource($country->load(['currency']));
        return successResponse(trans('cruds.api.success') , $data);

    }
}
