<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\AllAd;
use App\Models\CanselReason;
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
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orders = Order::all();

        $restaurants = Restaurant::get();

        $users = User::get();

        $order_types = OrderType::get();

        $sitting_areas = SittingArea::get();

        $delivery_companies = DeliveryCompany::get();

        $order_statuses = OrderStatus::get();

        $items = Item::get();

        $cansel_reasons = CanselReason::get();

        $all_ads = AllAd::get();

        return view('admin.orders.index', compact('orders', 'restaurants', 'users', 'order_types', 'sitting_areas', 'delivery_companies', 'order_statuses', 'items', 'cansel_reasons', 'all_ads'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = OrderType::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sitting_areas = SittingArea::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $delivery_companies = DeliveryCompany::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = OrderStatus::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = Item::all()->pluck('name', 'id');

        $cansel_reasons = CanselReason::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.orders.create', compact('restaurants', 'users', 'types', 'sitting_areas', 'delivery_companies', 'statuses', 'items', 'cansel_reasons'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->all());
        $order->items()->sync($request->input('items', []));

        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = OrderType::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sitting_areas = SittingArea::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $delivery_companies = DeliveryCompany::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = OrderStatus::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = Item::all()->pluck('name', 'id');

        $cansel_reasons = CanselReason::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $order->load('restaurants', 'user', 'type', 'sitting_area', 'delivery_company', 'status', 'items', 'cansel_reason', 'winner');

        return view('admin.orders.edit', compact('restaurants', 'users', 'types', 'sitting_areas', 'delivery_companies', 'statuses', 'items', 'cansel_reasons', 'order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        $order->items()->sync($request->input('items', []));

        return redirect()->route('admin.orders.index');
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load('restaurants', 'user', 'type', 'sitting_area', 'delivery_company', 'status', 'items', 'cansel_reason', 'winner');

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        Order::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
