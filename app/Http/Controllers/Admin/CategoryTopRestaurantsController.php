<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCategoryTopRestaurantRequest;
use App\Http\Requests\StoreCategoryTopRestaurantRequest;
use App\Http\Requests\UpdateCategoryTopRestaurantRequest;
use App\Models\CategoryTopRestaurant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryTopRestaurantsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('category_top_restaurant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categoryTopRestaurants = CategoryTopRestaurant::all();

        return view('admin.categoryTopRestaurants.index', compact('categoryTopRestaurants'));
    }

    public function create()
    {
        abort_if(Gate::denies('category_top_restaurant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryTopRestaurants.create');
    }

    public function store(StoreCategoryTopRestaurantRequest $request)
    {
        $categoryTopRestaurant = CategoryTopRestaurant::create($request->all());

        return redirect()->route('admin.category-top-restaurants.index');
    }

    public function edit(CategoryTopRestaurant $categoryTopRestaurant)
    {
        abort_if(Gate::denies('category_top_restaurant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryTopRestaurants.edit', compact('categoryTopRestaurant'));
    }

    public function update(UpdateCategoryTopRestaurantRequest $request, CategoryTopRestaurant $categoryTopRestaurant)
    {
        $categoryTopRestaurant->update($request->all());

        return redirect()->route('admin.category-top-restaurants.index');
    }

    public function show(CategoryTopRestaurant $categoryTopRestaurant)
    {
        abort_if(Gate::denies('category_top_restaurant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoryTopRestaurants.show', compact('categoryTopRestaurant'));
    }

    public function destroy(CategoryTopRestaurant $categoryTopRestaurant)
    {
        abort_if(Gate::denies('category_top_restaurant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categoryTopRestaurant->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategoryTopRestaurantRequest $request)
    {
        CategoryTopRestaurant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
