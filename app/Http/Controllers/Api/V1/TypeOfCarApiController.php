<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeOfCarResource;
use App\Models\TypeOfCar;
use Illuminate\Http\Request;

class TypeOfCarApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        if ($request->id)
        {
            $data = TypeOfCarResource::collection(TypeOfCar::where('car_type_id' , $request->id)->get());
        }else{
            $data = TypeOfCarResource::collection(TypeOfCar::all());
        }
        return successResponse(trans('cruds.api.success') , $data);
    }
}
