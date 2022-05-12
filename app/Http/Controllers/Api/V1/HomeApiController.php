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
        $slide_show = SlideShowResource::collection(SlideShow::where('status', 1)->get());
        $ads_offer_data = AllAd::with(['restaurant', 'category', 'winner'])->where('category_id', 1)->where('status', 1);
        $ads_offer_deals_data = AllAd::with(['restaurant', 'category', 'winner'])->where('category_id', 2)->where('status', 1);
        $restaurant = Restaurant::whereHas('restaurant', function ($query) {
            $query->where('status_id', 1);
        })->whereRaw('"' . Carbon::now()->format('H:i:s') . '" between `open_time` and `close_time`')->with(['restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city']);

        if ($request->lat != '' && $request->lang != '') {
            $restaurant = $restaurant->select('*')
                ->selectRaw(get_nearest_sql("restaurants", $request->lat, $request->lang))
                ->whereRaw(get_nearest_sql_n("restaurants", $request->lat, $request->lang) . " <= ?", 50)
                ->orderBy('distance', 'ASC');

            $ads_offer_data = $ads_offer_data->whereHas('restaurant', function ($query) {
                $query->select('*')
                    ->selectRaw(get_nearest_sql("restaurants", request()->lat, request()->lang))
                    ->whereRaw(get_nearest_sql_n("restaurants", request()->lat, request()->lang) . " <= ?", 50)
                    ->orderBy('distance', 'ASC');
            });

            $ads_offer_deals_data = $ads_offer_deals_data->whereHas('restaurant', function ($query) {
                $query->select('*')
                    ->selectRaw(get_nearest_sql("restaurants", request()->lat, request()->lang))
                    ->whereRaw(get_nearest_sql_n("restaurants", request()->lat, request()->lang) . " <= ?", 50)
                    ->orderBy('distance', 'ASC');
            });


        }

        if ($request->country_id) {
            $ads_offer_data = $ads_offer_data->whereHas('restaurant', function ($query) {
                $query->where('country_id', request()->country_id);
            });

            $ads_offer_deals_data = $ads_offer_deals_data->whereHas('restaurant', function ($query) {
                $query->where('country_id', request()->country_id);
            });

            $restaurant = $restaurant->where('country_id', $request->country_id);


        }

        if ($request->city_id) {
            $ads_offer_data = $ads_offer_data->whereHas('restaurant', function ($query) {
                $query->where('city_id', request()->city_id);
            });

            $ads_offer_deals_data = $ads_offer_deals_data->whereHas('restaurant', function ($query) {
                $query->where('city_id', request()->city_id);
            });

            $restaurant = $restaurant->where('city_id', $request->city_id);

        }

        $ads_offer_data = $ads_offer_data->take(10)->get();
        $ads_offer_deals_data = $ads_offer_deals_data->take(4)->get();
        $ads_offer = AllAdResource::collection($ads_offer_data);
        $ads_offer_deals = AllAdResource::collection($ads_offer_deals_data);


        $restaurant_resource = RestaurantSimpleResource::collection($restaurant->take(10)->get());


        $data = [
            'slide_show' => $slide_show,
            'ads_offer' => $ads_offer,
            'ads_offer_deals' => $ads_offer_deals,
            'restaurant_resource' => $restaurant_resource,
        ];
        return successResponse(trans('cruds.api.success'), $data);
    }

    public function setting()
    {
        $data = [
            'phone' => getSetting('phone') ?? '',
            'email' => getSetting('email') ?? '',
            'facebook' => getSetting('facebook') ?? '',
            'twitter' => getSetting('twitter') ?? '',
            'watsapp' => getSetting('watsapp') ?? '',
            'instagram' => getSetting('instagram') ?? '',
            'youtube' => getSetting('youtube') ?? '',
            'tiktok' => getSetting('tiktok') ?? '',
            'linkedin' => getSetting('linkedin') ?? '',
            'about_app' => App::getLocale() == 'ar' ? getSetting('about_app_ar') : getSetting('about_app'),
            'privacy_app' => App::getLocale() == 'ar' ? getSetting('privacy_app_ar') : getSetting('privacy_app'),
            'save_address' => true,
            'vat' => true,
            'vip' => true,
            'Deal_Offers' => true,
            'delivery' => true,
            'delivery_country' => true,
            'cash' => true,
            'application_services' => (float)getSetting('application_services'),
            'vat_percent' => (float) getSetting('vat'),
            'discount_application_services_rate_inside_percent' => (float) getSetting('rate_inside'),
            'discount_application_services_rate_outside_percent' => (float) getSetting('rate_outside'),
            'release' => getSetting('release'),
            'qr_code' => asset(url('/local/public/img/setting/' . getSetting('rq_code'))),
        ];

        return successResponse(trans('cruds.api.success'), $data);
    }
}
