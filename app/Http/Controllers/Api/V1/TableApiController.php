<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $user_restaurant = User::find(Auth::id())->restaurant_id;
        $restaurant = Restaurant::where('id' , $user_restaurant)->first();
        if (!$request->type){
            $table_inside = Table::where('restaurants_id', $restaurant->id)->where('sitting_area_id' , 1)->get();
            $table_outside = Table::where('restaurants_id', $restaurant->id)->where('sitting_area_id' , 2)->get();

        }else{
            $table_inside = Table::where('restaurants_id', $restaurant->id)->where('sitting_area_id' , 1)->where('status_id' , $request->type)->get();
            $table_outside = Table::where('restaurants_id', $restaurant->id)->where('sitting_area_id' , 2)->where('status_id' , $request->type)->get();
        }
        $data = [
            'inside' => TableResource::collection($table_inside),
            'outside' => TableResource::collection($table_outside)
        ];
        return successResponse(trans('cruds.api.success') , $data);
    }

    public function release_all(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $user_restaurant = User::find(Auth::id())->restaurant_id;
        $restaurant = Restaurant::where('id' , $user_restaurant)->first();
        $table = Table::where('restaurants_id', $restaurant->id)->get();
        foreach ($table as $value){
            $value->status_id = 1 ;
            $value->save() ;
        }
        return successResponse(trans('cruds.api.success'));
    }

    public function change_status(Request $request , $id)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $table = Table::find($id);
        if ($table)
        {
            if ($table->status_id == 1)
            {
                $table->status_id = 2;
            }else{
                $table->status_id = 1;
                $orders = Order::where('status_id' , 5)->where('table_id' , $id)->get();
                foreach ($orders as $order)
                {
                    $order->status_id = 2;
                    $order->save();
                }

            }
            $table->save();
            return successResponse(trans('cruds.api.success'));

        }else{
            return errorResponse(trans('cruds.api.table_not_found'));
        }
    }

}
