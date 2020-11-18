<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSittingAreaRequest;
use App\Http\Requests\UpdateSittingAreaRequest;
use App\Http\Resources\Admin\SittingAreaResource;
use App\Models\SittingArea;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SittingAreaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sitting_area_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SittingAreaResource(SittingArea::all());
    }

    public function store(StoreSittingAreaRequest $request)
    {
        $sittingArea = SittingArea::create($request->all());

        return (new SittingAreaResource($sittingArea))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SittingArea $sittingArea)
    {
        abort_if(Gate::denies('sitting_area_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SittingAreaResource($sittingArea);
    }

    public function update(UpdateSittingAreaRequest $request, SittingArea $sittingArea)
    {
        $sittingArea->update($request->all());

        return (new SittingAreaResource($sittingArea))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SittingArea $sittingArea)
    {
        abort_if(Gate::denies('sitting_area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sittingArea->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
