<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ReportController extends Controller
{
    public function index()
    {

        $from = Carbon::parse(sprintf(
            '%s-%s-01',
            request()->query('y', Carbon::now()->year),
            request()->query('m', Carbon::now()->month)
        ));
        $to = clone $from;
        $to->day = $to->daysInMonth;


        $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();

        if (Auth::user()['user_type'] == 3) {
            $order = Order::where('restaurants_id', $restaurant->id)
                ->whereBetween('created_at', [$from, $to]);

        } else {
            $order = Order::whereBetween('created_at', [$from, $to]);
        }

        $total = $order->sum('final_price');
        $avg = $order->avg('final_price');
        $count = $order->count('id');
        $orders = $order->get();



        if (Auth::user()['user_type'] != 3)
        {
            $settings18 = [
                'chart_title'           => 'sale  price',
                'chart_type'            => 'line',
                'report_type'           => 'group_by_date',
                'model'                 => 'App\Models\Order',
                'group_by_field'        => 'created_at',
                'group_by_period'       => 'day',
                'aggregate_function'    => 'sum',
                'aggregate_field'       => 'final_price',
                'filter_field'          => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class'          => 'col-md-10',
                'entries_number'        => '5',
            ];

            $settings20 = [
                'chart_title'           => 'sale avg',
                'chart_type'            => 'line',
                'report_type'           => 'group_by_date',
                'model'                 => 'App\Models\Order',
                'group_by_field'        => 'created_at',
                'group_by_period'       => 'day',
                'aggregate_function'    => 'avg',
                'aggregate_field'       => 'final_price',
                'filter_field'          => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class'          => 'col-md-10',
                'entries_number'        => '5',
            ];

        }else{

            $settings18 = [
                'chart_title'           => 'sale price',
                'chart_type'            => 'line',
                'report_type'           => 'group_by_date',
                'model'                 => 'App\Models\Order',
                'group_by_field'        => 'created_at',
                'group_by_period'       => 'day',
                'aggregate_function'    => 'sum',
                'aggregate_field'       => 'final_price',
                'filter_field'          => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class'          => 'col-md-12',
                'entries_number'        => '5',
                'conditions' => [
                    ['name' => 'restaurant', 'condition' => 'restaurants_id = '.$restaurant->id, 'color' => 'black'],
                ],
            ];

            $settings20 = [
                'chart_title'           => 'sale avg',
                'chart_type'            => 'line',
                'report_type'           => 'group_by_date',
                'model'                 => 'App\Models\Order',
                'group_by_field'        => 'created_at',
                'group_by_period'       => 'day',
                'aggregate_function'    => 'avg',
                'aggregate_field'       => 'final_price',
                'filter_field'          => 'created_at',
                'group_by_field_format' => 'Y-m-d H:i:s',
                'column_class'          => 'col-md-12',
                'entries_number'        => '5',
                'conditions' => [
                    ['name' => 'restaurant', 'condition' => 'restaurants_id = '.$restaurant->id, 'color' => 'black'],
                ],
            ];
        }

        $chart_order = new LaravelChart($settings18);
        $chart_avg = new LaravelChart($settings20);




        return view('admin.reports.index', compact(
            'total',
            'orders',
            'avg',
            'count'
        ));
    }



    public function show($type)
    {
       //type 1 = best sale product
        $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();

        if (Auth::user()['user_type'] == 3) {
            $items = Item::where('restaurant_id' , $restaurant->id)->where('sale_count' , '>' , 0 )->get();
        } else {
            $items = Item::where('sale_count' , '>' , 0 )->get();
        }
        return view('admin.reports.product', compact(
            'items'
        ));

    }
}