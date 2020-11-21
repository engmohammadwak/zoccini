<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\RestaurantSimpleResource;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantsApiController extends Controller
{

    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
          if ($request->lat != '' && $request->lang != '') {
              $restaurant = Restaurant::whereHas('restaurant', function ($query) {
                  $query->where('status_id', 1);
              })->with(['restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city'])->get();

          } else {
              $restaurant = Restaurant::whereHas('restaurant', function ($query) {
                  $query->where('status_id', 1);
              })->with(['restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city'])->selectRaw(get_nearest_sql("restaurants", $request->lat, $request->lang))->orderBy('distance', 'ASC')->get();
          }
        $data =  RestaurantSimpleResource::collection($restaurant);
        return successResponse(trans('cruds.api.success') , $data);


    }


    public function show(Request $request,$id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $restaurant = Restaurant::find($id);
        if ($restaurant){
            $data =  new RestaurantResource($restaurant->load(['restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city']));
            return successResponse(trans('cruds.api.success') , $data);
        }else{
            return errorResponse(trans('cruds.api.restaurant_not_found'));
        }
    }


}
