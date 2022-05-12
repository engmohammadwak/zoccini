<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\AllAd;
use App\Models\CancelReason;
use App\Models\CarList;
use App\Models\Category;
use App\Models\DeliveryCompany;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderType;
use App\Models\Restaurant;
use App\Models\SittingArea;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();
        if (Auth::user()['user_type'] == 3) {
            $orders = Order::with(['restaurants', 'user', 'type', 'sitting_area', 'delivery_company', 'status', 'items', 'cansel_reason', 'winner', 'car_number'])->where('restaurants_id', $restaurant->id)->get();
            $restaurants = null;

        } else {
            $orders = Order::with(['restaurants', 'user', 'type', 'sitting_area', 'delivery_company', 'status', 'items', 'cansel_reason', 'winner', 'car_number'])->get();
            $restaurants = Restaurant::get();
        }
        $users = User::get();
        $order_statuses = OrderStatus::get();

        return view('admin.orders.index', compact('orders', 'restaurants', 'users', 'order_statuses'));
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load('restaurants', 'user', 'type', 'sitting_area', 'delivery_company', 'status', 'items', 'cansel_reason', 'winner', 'car_number');

        return view('admin.orders.show', compact('order'));
    }

}
