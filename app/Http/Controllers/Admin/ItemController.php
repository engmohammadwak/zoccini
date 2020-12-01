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
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = Item::all();

        $restaurants = Restaurant::get();

        $categories = Category::get();

        return view('admin.items.index', compact('items', 'restaurants', 'categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $categories = Category::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.items.create', compact( 'categories'));
    }

    public function store(StoreItemRequest $request)
    {
        $item = Item::create($request->all());

        if ($request->file('photo')) {
            $image = uploadImage($request->file('photo'),'/public/img/item' , $item->photo);
            $item->fill(['photo' => $image])->save();
        }
        $category = Category::find($request->category_id);
        $item->restaurant_id = $category->restaurant_id;
        $item->save();

        return redirect()->route('admin.items.index');
    }


    public function edit(Item $item)
    {
        abort_if(Gate::denies('item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $item->load('category');

        return view('admin.items.edit', compact( 'categories', 'item'));
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $item->update($request->all());
        if ($request->file('photo')) {
            $image = uploadImage($request->file('photo'),'/public/img/item' , $item->photo);
            $item->fill(['photo' => $image])->save();
        }
        $category = Category::find($request->category_id);
        $item->restaurant_id = $category->restaurant_id;
        $item->save();

        return redirect()->route('admin.items.index');
    }

    public function show(Item $item)
    {
        abort_if(Gate::denies('item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item->load( 'category');

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

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('item_create') && Gate::denies('item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Item();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
