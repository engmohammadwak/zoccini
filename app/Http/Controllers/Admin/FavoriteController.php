<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFavoriteRequest;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FavoriteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('favorite_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $favorites = Favorite::all();

        return view('admin.favorites.index', compact('favorites'));
    }

    public function create()
    {
        abort_if(Gate::denies('favorite_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = Item::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.favorites.create', compact('users', 'items', 'restaurants'));
    }

    public function store(StoreFavoriteRequest $request)
    {
        $favorite = Favorite::create($request->all());

        return redirect()->route('admin.favorites.index');
    }

    public function edit(Favorite $favorite)
    {
        abort_if(Gate::denies('favorite_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $items = Item::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $favorite->load('user', 'item', 'restaurant');

        return view('admin.favorites.edit', compact('users', 'items', 'restaurants', 'favorite'));
    }

    public function update(UpdateFavoriteRequest $request, Favorite $favorite)
    {
        $favorite->update($request->all());

        return redirect()->route('admin.favorites.index');
    }

    public function show(Favorite $favorite)
    {
        abort_if(Gate::denies('favorite_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $favorite->load('user', 'item', 'restaurant');

        return view('admin.favorites.show', compact('favorite'));
    }

    public function destroy(Favorite $favorite)
    {
        abort_if(Gate::denies('favorite_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $favorite->delete();

        return back();
    }

    public function massDestroy(MassDestroyFavoriteRequest $request)
    {
        Favorite::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
