<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use App\City;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllAdResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\MyCategoryResource;
use App\Http\Resources\NationalityResource;
use App\Http\Resources\OnboadingResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\QuestionsRateResource;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\RestaurantSimpleResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SlideShowResource;
use App\Http\Resources\UserResource;
use App\Models\AllAd;
use App\Models\Restaurant;
use App\Models\SlideShow;
use App\Nationality;
use App\Onboading;
use App\Order;
use App\Package;
use App\Product;
use App\QuestionsRate;
use App\Service;
use App\ServiseRequest;
use App\SubscriptionsUser;
use App\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeApiController extends Controller
{

    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $slide_show = SlideShowResource::collection(SlideShow::where('status' , 1)->get());
        $ads_offer =  AllAdResource::collection(AllAd::with(['restaurant', 'category', 'winner'])->where('category_id' ,1 )->where('status' , 1)->take(10)->get());
        $ads_offer_deals =  AllAdResource::collection(AllAd::with(['restaurant', 'category', 'winner'])->where('category_id' ,2 )->where('status' , 1)->take(4)->get());

        if ($request->lat != '' && $request->lang != '') {
            $restaurant = Restaurant::whereHas('restaurant', function ($query) {
                $query->where('status_id', 1);
            })->whereRaw('"'.Carbon::now()->format('H:i:s').'" between `open_time` and `close_time`')->with(['restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city'])->selectRaw(get_nearest_sql("restaurants", $request->lat, $request->lang))->orderBy('distance', 'ASC')->take(10)->get();

        } else {
            $restaurant = Restaurant::whereHas('restaurant', function ($query) {
                $query->where('status_id', 1);
            })->whereRaw('"'.Carbon::now()->format('H:i:s').'" between `open_time` and `close_time`')->with(['restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city'])->take(10)->get();

        }
       $restaurant_resource =  RestaurantSimpleResource::collection($restaurant);

        $data = [
            'slide_show' => $slide_show,
            'ads_offer' => $ads_offer,
            'ads_offer_deals' => $ads_offer_deals,
            'restaurant_resource' => $restaurant_resource,
        ];
        return successResponse(trans('cruds.api.success'), $data);
    }


}
