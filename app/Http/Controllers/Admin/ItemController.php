<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyItemRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        if (Auth::user()['user_type'] == 3) {
            $items = Item::where('restaurant_id' ,$restaurant->id)->get();
            $restaurants = Restaurant::where('restaurant_id' , $restaurant->id)->get();
            $categories = Category::where('restaurant_id' , $restaurant->id)->get();
        } else {
            $items = Item::all();
            $restaurants = Restaurant::get();
            $categories = Category::get();
        }
        return view('admin.items.index', compact('items', 'restaurants', 'categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();

        $categories = Category::where('restaurant_id' , $restaurant->id)->get()->pluck('name_' . App::getLocale(), 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.items.create', compact('categories'));
    }

    public function store(StoreItemRequest $request)
    {
        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        $request->request->add(['restaurant_id' => $restaurant->id]);
        $item = Item::create($request->all());

        if ($request->file('photo')) {
            $image = uploadImage($request->file('photo'), '/public/img/item', $item->photo);
            $item->fill(['photo' => $image])->save();
        }
        return redirect()->route('admin.items.index');
    }


    public function edit(Item $item)
    {
        abort_if(Gate::denies('item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (Auth::user()['user_type'] != 3)
        {
            $restaurant = Restaurant::where('id' , $item->restaurant_id)->first();
        }else{
            $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        }

        $categories = Category::where('restaurant_id' , $restaurant->id)->get()->pluck('name_' . App::getLocale(), 'id')->prepend(trans('global.pleaseSelect'), '');

        $item->load('category');

        return view('admin.items.edit', compact('categories', 'item'));
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->all());
        if ($request->file('photo')) {
            $image = uploadImage($request->file('photo'), '/public/img/item', $item->photo);
            $item->fill(['photo' => $image])->save();
        }
        return redirect()->route('admin.items.index');
    }

    public function show(Item $item)
    {
        abort_if(Gate::denies('item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item->load('category');

        return view('admin.items.show', compact('item'));
    }

    public function destroy(Item $item)
    {
        abort_if(Gate::denies('item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item->delete();

        return back();
    }

    public function massDestroy(MassDestroyItemRequest $request)
    {
        Item::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
