<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderRestaurantResource;
use App\Http\Resources\RestaurantRateResource;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\RestaurantSimpleResource;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestaurantsApiController extends Controller
{

    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);


        $search = $request->search ? $request->search : "";
        $lat = $request->lat ? $request->lat : -1;
        $lng = $request->lng ? $request->lng : -1;
        $city_id = $request->city_id ? $request->city_id : -1;
        $country_id = $request->country_id ? $request->country_id : -1;
        $rating = $request->rating ? $request->rating : -1;
        $filter = $request->filter ? $request->filter : -1;
        $sort = $request->sort ? $request->sort : -1;
        $price_from = $request->price_from ? $request->price_from : -1;
        $price_to = $request->price_to ? $request->price_to : -1;


        $companies = new Restaurant();

        $companies = $companies->with(['restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city'])->Search($search)->Active();

        if ($rating != -1) {
            $rate = json_decode($rating, true);
            $companies = $companies->where('rating', '>', $rate[0])->where('rating', '<', $rate[0] + 1);

            foreach ($rate as $key => $value) {
                if ($key > 0) {
                    if ($value != 5) {
                        $companies = $companies->orWhere('rating', '>', $value)->where('rating', '<', $value + 1);
                    } else {
                        $companies = $companies->orWhere('rating', $value);
                    }
                }
            }
        }

        if ($lat != -1 && $lng != -1) {
            $companies = $companies
                ->selectRaw(get_nearest_sql("restaurants", $request->lat, $request->lang))
                ->whereRaw(get_nearest_sql_n("restaurants" ,$request->lat ,$request->lang )." <= ?", 50)
            ;


            $companies = $companies->orderBy('distance');
        }


        if ($city_id != -1) {
            $companies = $companies->where('city_id', $city_id);
        }

        if ($country_id != -1) {
            $companies = $companies->where('country_id', $country_id);
        }

        if ($price_from != -1 && $price_to == -1) {
            $companies->where('mins', '>=', $price_from);
        } elseif ($price_from == -1 && $price_to != -1) {
            $companies->where('mins', '<=', $price_to);
        } else {
            if ($price_from != -1 && $price_to != -1) {
                $companies->whereBetween('mins', [$price_from, $price_to]);
            }
        }


        if ($sort != -1) {
            //sort rating
            if ($sort == 1) {
                $companies = $companies->orderByDesc('rating');
            } //sort A to Z
            elseif ($sort == 2) {
                if (App::getLocale() == 'ar') {
                    $companies = $companies->orderBy('name_ar');
                } else {
                    $companies = $companies->orderBy('name_en');
                }
            } //sort min-order
            elseif ($sort == 3) {
                $companies = $companies->orderBy('mins');
            }
        }

        if ($filter != -1) {
            //free delivery
            if ($filter == 1) {
                $companies = $companies->where('delivery_id', 1);
            } //deal and offer
            elseif ($filter == 2) {

            }
        }
        $companies = $companies->paginate(10);
        $data = RestaurantSimpleResource::collection($companies);
        $meta = collect($companies)->except('data');
        return successResponse(trans('cruds.api.success'), [
            'data' => $data,
            'meta' => $meta,
        ]);


    }

    public function show(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $restaurant->visits = $restaurant->visits + 1;
            $restaurant->save();

            $data = new RestaurantResource($restaurant->load(['restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city']));
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.restaurant_not_found'));
        }
    }

    public function show_rate(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $data = new RestaurantRateResource($restaurant->load(['rate']));
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.restaurant_not_found'));
        }
    }

    public function waiting(Request $request, $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $restaurant = Restaurant::find($id);
        if ($restaurant) {
            $data = [
                'number_reservation_inside'  => Order::where('restaurants_id'  , $id)->where('status_id' ,3 )->where('type_id' ,1 )->count() + 1,
                'number_reservation_outside' => Order::where('restaurants_id'  , $id)->where('status_id' ,3 )->where('type_id' ,2 )->count() + 1,
            ];
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.restaurant_not_found'));
        }
    }

    public function view_queue(Request $request, $phone)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $user = User::where('phone', $phone)->first();
        if ($user) {
            $restaurant = Restaurant::where('restaurant_id', $user->id)->first();
            if ($restaurant) {

                if ($user->image == '') {
                    $logo = url('local/public/img/setting/' . getSetting('restaurant_image'));
                } else {
                    $logo = url('local/public/img/user/' . $user->image);

                }


                $data = [
                    'logo' => $logo,
                    'name' => App::getLocale() == 'ar' ? $restaurant->name_ar : $restaurant->name_en,
                    'inside' => Order::where('restaurants_id', $restaurant->id)->where('status_id', 3)->where('type_id', 1)->count(),
                    'outside' => Order::where('restaurants_id', $restaurant->id)->where('status_id', 3)->where('type_id', 2)->count(),
                ];
                return successResponse(trans('cruds.api.success'), $data);
            } else {
                return errorResponse(trans('cruds.api.restaurant_not_found'));
            }
        } else {
            return errorResponse(trans('cruds.api.restaurant_not_found'));
        }
    }

    public function restaurants_home(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $user_restaurant = User::find(Auth::id())->restaurant_id;
        $restaurant = Restaurant::where('id', $user_restaurant)->first();
        $date = \Carbon\Carbon::today()->subDays(7);
        if ($restaurant) {
            $data = [
                'all_order' => Order::where('restaurants_id', $restaurant->id)->whereIn('status_id', [3, 1 , 5])->whereDate('created_at',  '>=', $date)->WhereNull('table_id')->count(),
                'external' => Order::where('restaurants_id', $restaurant->id)->whereIn('status_id', [3, 1 , 5])->where('type_id', 2)->whereDate('created_at', '>=', $date)->WhereNull('table_id')->count(),
                'internal' => Order::where('restaurants_id', $restaurant->id)->whereIn('status_id', [3, 1 , 5])->where('type_id', 1)->whereDate('created_at',  '>=', $date)->WhereNull('table_id')->count(),
                'orders' => OrderRestaurantResource::collection(Order::where('restaurants_id', $restaurant->id)->whereIn('status_id', [3, 1 , 5])->whereDate('created_at', '>=', $date)->WhereNull('table_id')->orderBy('id' , 'DESC')->get()),
            ];
            return successResponse(trans('cruds.api.success'), $data);
        } else {
            return errorResponse(trans('cruds.api.restaurant_not_found'));
        }
    }

}
