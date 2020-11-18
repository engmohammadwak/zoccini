<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlideShowResource;
use App\Models\SlideShow;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SlideShowApiController extends Controller
{

    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $data = SlideShowResource::collection(SlideShow::where('status' , 1)->get());
        return successResponse(trans('cruds.api.success') , $data);
    }

}
