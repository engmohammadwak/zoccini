<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllAdResource;
use App\Http\Resources\AllAdWinnerResource;
use App\Models\AdsCategory;
use App\Models\AllAd;
use App\Models\OfferUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllAdsApiController extends Controller
{

    public function index(Request $request , $type)
    {

        $lang = $request->header('lang');
        setLang($lang);
        $category_ad = AdsCategory::find($type);
        if ($category_ad){
            $ads = AllAd::with(['restaurant', 'category', 'winner'])->where('category_id' ,$type )->where('status' , 1);

            if ($request->country_id) {
                $ads = $ads->whereHas('restaurant', function ($query) {
                    $query->where('country_id', request()->country_id);
                });
            }

            if ($request->city_id) {
                $ads = $ads->whereHas('restaurant', function ($query) {
                    $query->where('city_id', request()->city_id);
                });
            }

            if ($request->lat != '' && $request->lang != '') {
                $ads = $ads->whereHas('restaurant', function ($query) {
                    $query->select('*')
                        ->selectRaw(get_nearest_sql("restaurants", request()->lat, request()->lang))
                        ->whereRaw(get_nearest_sql_n("restaurants", request()->lat, request()->lang) . " <= ?", 50)
                        ->orderBy('distance', 'ASC');
                });
            }

            $ads = $ads->paginate(10);
            $data =  AllAdResource::collection($ads);
            $meta = collect($ads)->except('data');

        }else{
            return errorResponse(trans('cruds.api.category_not_found'));
        }
        return successResponse(trans('cruds.api.success') , $data , null , $meta);
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

    public function winner(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $allAd = AllAd::where('status' , 2)->where('winner_id' , '!=' , null)->get();
        $data =  AllAdWinnerResource::collection($allAd);
        return successResponse(trans('cruds.api.success') , $data);

    }

    public function ads_subscription(Request $request , $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $user = auth('api')->user();
        if ($user)
        {
            $allAd = OfferUser::with('offer')->where('offer_id' , $id)->where('user_id' , $user->id)->where('status' , 1)->get()->pluck('offer');
//            $allAd = OfferUser::with('offer')->where('offer_id' , $id)->where('status' , 1)->get()->pluck('offer');
            $data =  AllAdResource::collection($allAd);

            return successResponse(trans('cruds.api.success') , $data);
        }else{
            return errorResponse('no user found');
        }


    }

}
