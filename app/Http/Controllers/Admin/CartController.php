<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCartRequest;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cart_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carts = Cart::where('user_id' ,Auth::id())->get();

        return view('admin.carts.index', compact('carts'));
    }

    public function create()
    {
        abort_if(Gate::denies('cart_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = Item::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.carts.create', compact('restaurants', 'users', 'items'));
    }

    public function store(StoreCartRequest $request)
    {
        $cart = Cart::create($request->all());

        return redirect()->route('admin.carts.index');
    }

    public function edit(Cart $cart)
    {
        abort_if(Gate::denies('cart_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = Item::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cart->load('restaurant', 'user', 'item');

        return view('admin.carts.edit', compact('restaurants', 'users', 'items', 'cart'));
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->update($request->all());

        return redirect()->route('admin.carts.index');
    }

    public function show(Cart $cart)
    {
        abort_if(Gate::denies('cart_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cart->load('restaurant', 'user', 'item');

        return view('admin.carts.show', compact('cart'));
    }

    public function destroy(Cart $cart)
    {
        abort_if(Gate::denies('cart_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cart->delete();

        return back();
    }

    public function massDestroy(MassDestroyCartRequest $request)
    {
        Cart::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
