<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarbrandResource;
use App\Models\Carbrand;
use Illuminate\Http\Request;

class CarbrandApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $data = CarbrandResource::collection(Carbrand::all());
        return successResponse(trans('cruds.api.success') , $data);
    }
}
