<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTopRestaurantRequest;
use App\Http\Requests\StoreTopRestaurantRequest;
use App\Http\Requests\UpdateTopRestaurantRequest;
use App\Models\CategoryTopRestaurant;
use App\Models\TopRestaurant;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class TopRestaurantsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('top_restaurant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topRestaurants = TopRestaurant::with(['category'])->get();

        return view('admin.topRestaurants.index', compact('topRestaurants'));
    }

    public function create()
    {
        abort_if(Gate::denies('top_restaurant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CategoryTopRestaurant::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.topRestaurants.create', compact('categories'));
    }

    public function store(StoreTopRestaurantRequest $request)
    {
        $topRestaurant = TopRestaurant::create($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/top_restaurants' , $topRestaurant->image);
            $topRestaurant->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.top-restaurants.index');
    }

    public function edit(TopRestaurant $topRestaurant)
    {
        abort_if(Gate::denies('top_restaurant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = CategoryTopRestaurant::all()->pluck('name_'.App::getLocale(), 'id')->prepend(trans('global.pleaseSelect'), '');
        $topRestaurant->load('category');

        return view('admin.topRestaurants.edit', compact('categories', 'topRestaurant'));
    }

    public function update(UpdateTopRestaurantRequest $request, TopRestaurant $topRestaurant)
    {
        $topRestaurant->update($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/top_restaurants' , $topRestaurant->image);
            $topRestaurant->fill(['image' => $image])->save();
        }
        return redirect()->route('admin.top-restaurants.index');
    }

    public function show(TopRestaurant $topRestaurant)
    {
        abort_if(Gate::denies('top_restaurant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topRestaurant->load('category');

        return view('admin.topRestaurants.show', compact('topRestaurant'));
    }

    public function destroy(TopRestaurant $topRestaurant)
    {
        abort_if(Gate::denies('top_restaurant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $topRestaurant->delete();

        return back();
    }

    public function massDestroy(MassDestroyTopRestaurantRequest $request)
    {
        TopRestaurant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
