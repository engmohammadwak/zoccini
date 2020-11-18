<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePointTypeRequest;
use App\Http\Requests\UpdatePointTypeRequest;
use App\Http\Resources\Admin\PointTypeResource;
use App\Models\PointType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PointTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('point_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PointTypeResource(PointType::all());
    }

    public function store(StorePointTypeRequest $request)
    {
        $pointType = PointType::create($request->all());

        return (new PointTypeResource($pointType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(PointType $pointType)
    {
        abort_if(Gate::denies('point_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PointTypeResource($pointType);
    }

    public function update(UpdatePointTypeRequest $request, PointType $pointType)
    {
        $pointType->update($request->all());

        return (new PointTypeResource($pointType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(PointType $pointType)
    {
        abort_if(Gate::denies('point_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pointType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
