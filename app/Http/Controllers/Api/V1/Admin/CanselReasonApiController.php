<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCanselReasonRequest;
use App\Http\Requests\UpdateCanselReasonRequest;
use App\Http\Resources\Admin\CanselReasonResource;
use App\Models\CanselReason;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanselReasonApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cansel_reason_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CanselReasonResource(CanselReason::all());
    }

    public function store(StoreCanselReasonRequest $request)
    {
        $canselReason = CanselReason::create($request->all());

        return (new CanselReasonResource($canselReason))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CanselReason $canselReason)
    {
        abort_if(Gate::denies('cansel_reason_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CanselReasonResource($canselReason);
    }

    public function update(UpdateCanselReasonRequest $request, CanselReason $canselReason)
    {
        $canselReason->update($request->all());

        return (new CanselReasonResource($canselReason))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CanselReason $canselReason)
    {
        abort_if(Gate::denies('cansel_reason_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $canselReason->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
