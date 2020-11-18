<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAllAdRequest;
use App\Http\Requests\StoreAllAdRequest;
use App\Http\Requests\UpdateAllAdRequest;
use App\Models\AdsCategory;
use App\Models\AllAd;
use App\Models\Restaurant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AllAdsController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('all_ad_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allAds = AllAd::all();

        return view('admin.allAds.index', compact('allAds'));
    }

    public function create()
    {
        abort_if(Gate::denies('all_ad_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AdsCategory::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');


        return view('admin.allAds.create', compact('restaurants', 'categories'));
    }

    public function store(StoreAllAdRequest $request)
    {
        $allAd = AllAd::create($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/ads' , $allAd->image);
            $allAd->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.all-ads.index');
    }

    public function edit(AllAd $allAd)
    {
        abort_if(Gate::denies('all_ad_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = AdsCategory::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $winners = User::where('user_type',2)->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $allAd->load('restaurant', 'category', 'winner');

        return view('admin.allAds.edit', compact('restaurants', 'categories', 'winners', 'allAd'));
    }

    public function update(UpdateAllAdRequest $request, AllAd $allAd)
    {
        $allAd->update($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/ads' , $allAd->image);
            $allAd->fill(['image' => $image])->save();
        }
        return redirect()->route('admin.all-ads.index');
    }

    public function show(AllAd $allAd)
    {
        abort_if(Gate::denies('all_ad_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allAd->load('restaurant', 'category', 'winner');

        return view('admin.allAds.show', compact('allAd'));
    }

    public function destroy(AllAd $allAd)
    {
        abort_if(Gate::denies('all_ad_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allAd->delete();

        return back();
    }

    public function massDestroy(MassDestroyAllAdRequest $request)
    {
        AllAd::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('all_ad_create') && Gate::denies('all_ad_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new AllAd();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
