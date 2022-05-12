<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnboadingResource;
use App\Models\Onbordering;
use Illuminate\Http\Request;

class OnboadingsApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        if ($request->type)
        {
            $data = OnboadingResource::collection(Onbordering::where('status' , 1)->where('type' , $request->type)->get()) ;

        }else{
            $data = OnboadingResource::collection(Onbordering::where('status' , 1)->where('type' , 1)->get()) ;
        }
        return successResponse(trans('cruds.api.success') , $data);
    }
}
