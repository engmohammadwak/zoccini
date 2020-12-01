<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllAdResource;
use App\Models\AdsCategory;
use App\Models\AllAd;
use Illuminate\Http\Request;

class AllAdsApiController extends Controller
{

    public function index(Request $request , $type)
    {

        $lang = $request->header('lang');
        setLang($lang);
        $category_ad = AdsCategory::find($type);
        if ($category_ad){
            $data =  AllAdResource::collection(AllAd::with(['restaurant', 'category', 'winner'])->where('category_id' ,$type )->where('status' , 1)->get());
        }else{
            return errorResponse(trans('cruds.api.category_not_found'));
        }
        return successResponse(trans('cruds.api.success') , $data);
    }
    public function show(Request $request , $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $allAd = AllAd::find($id);
        if ($allAd){
            $data =  new AllAdResource($allAd->load(['restaurant', 'category', 'winner']));
        }else{
            return errorResponse(trans('cruds.api.ads_not_found'));
        }
        return successResponse(trans('cruds.api.success') , $data);

    }

}
