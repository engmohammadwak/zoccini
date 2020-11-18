<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdsCategoryRequest;
use App\Http\Requests\UpdateAdsCategoryRequest;
use App\Http\Resources\Admin\AdsCategoryResource;
use App\Models\AdsCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdsCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ads_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdsCategoryResource(AdsCategory::all());
    }

    public function store(StoreAdsCategoryRequest $request)
    {
        $adsCategory = AdsCategory::create($request->all());

        return (new AdsCategoryResource($adsCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AdsCategory $adsCategory)
    {
        abort_if(Gate::denies('ads_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AdsCategoryResource($adsCategory);
    }

    public function update(UpdateAdsCategoryRequest $request, AdsCategory $adsCategory)
    {
        $adsCategory->update($request->all());

        return (new AdsCategoryResource($adsCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AdsCategory $adsCategory)
    {
        abort_if(Gate::denies('ads_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adsCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
