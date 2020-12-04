<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySlideShowRequest;
use App\Http\Requests\StoreSlideShowRequest;
use App\Http\Requests\UpdateSlideShowRequest;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\SlideShow;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SlideShowController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('slide_show_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slideShows = SlideShow::all();

        return view('admin.slideShows.index', compact('slideShows'));
    }

    public function create()
    {
        abort_if(Gate::denies('slide_show_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurants = Restaurant::all()->pluck('name_'.App::getLocale(), 'id')->prepend(trans('global.pleaseSelect'), '');
        $items = Item::all()->pluck('name_'.App::getLocale(), 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.slideShows.create' , compact('restaurants','items'));
    }

    public function store(StoreSlideShowRequest $request)
    {
        $slideShow = SlideShow::create($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/slidshow' , $slideShow->image);
            $slideShow->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.slide-shows.index');
    }

    public function edit(SlideShow $slideShow)
    {
        abort_if(Gate::denies('slide_show_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.slideShows.edit', compact('slideShow'));
    }

    public function update(UpdateSlideShowRequest $request, SlideShow $slideShow)
    {
        $slideShow->update($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/slidshow' , $slideShow->image);
            $slideShow->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.slide-shows.index');
    }

    public function show(SlideShow $slideShow)
    {
        abort_if(Gate::denies('slide_show_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.slideShows.show', compact('slideShow'));
    }

    public function destroy(SlideShow $slideShow)
    {
        abort_if(Gate::denies('slide_show_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slideShow->delete();

        return back();
    }

    public function massDestroy(MassDestroySlideShowRequest $request)
    {
        SlideShow::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('slide_show_create') && Gate::denies('slide_show_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new SlideShow();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
