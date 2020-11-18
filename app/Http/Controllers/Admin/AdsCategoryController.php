<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAdsCategoryRequest;
use App\Http\Requests\StoreAdsCategoryRequest;
use App\Http\Requests\UpdateAdsCategoryRequest;
use App\Models\AdsCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdsCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ads_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adsCategories = AdsCategory::all();

        return view('admin.adsCategories.index', compact('adsCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('ads_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adsCategories.create');
    }

    public function store(StoreAdsCategoryRequest $request)
    {
        $adsCategory = AdsCategory::create($request->all());

        return redirect()->route('admin.ads-categories.index');
    }

    public function edit(AdsCategory $adsCategory)
    {
        abort_if(Gate::denies('ads_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adsCategories.edit', compact('adsCategory'));
    }

    public function update(UpdateAdsCategoryRequest $request, AdsCategory $adsCategory)
    {
        $adsCategory->update($request->all());

        return redirect()->route('admin.ads-categories.index');
    }

    public function show(AdsCategory $adsCategory)
    {
        abort_if(Gate::denies('ads_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.adsCategories.show', compact('adsCategory'));
    }

    public function destroy(AdsCategory $adsCategory)
    {
        abort_if(Gate::denies('ads_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adsCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdsCategoryRequest $request)
    {
        AdsCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
