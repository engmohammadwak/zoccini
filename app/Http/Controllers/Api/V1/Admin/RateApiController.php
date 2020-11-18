<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRateRequest;
use App\Http\Requests\UpdateRateRequest;
use App\Http\Resources\Admin\RateResource;
use App\Models\Rate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RateApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RateResource(Rate::with(['user', 'restaurant'])->get());
    }

    public function store(StoreRateRequest $request)
    {
        $rate = Rate::create($request->all());

        return (new RateResource($rate))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Rate $rate)
    {
        abort_if(Gate::denies('rate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RateResource($rate->load(['user', 'restaurant']));
    }

    public function update(UpdateRateRequest $request, Rate $rate)
    {
        $rate->update($request->all());

        return (new RateResource($rate))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Rate $rate)
    {
        abort_if(Gate::denies('rate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rate->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
