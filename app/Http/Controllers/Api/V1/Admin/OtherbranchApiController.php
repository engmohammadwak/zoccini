<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOtherbranchRequest;
use App\Http\Requests\UpdateOtherbranchRequest;
use App\Http\Resources\Admin\OtherbranchResource;
use App\Models\Otherbranch;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtherbranchApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('otherbranch_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtherbranchResource(Otherbranch::with(['restaurants'])->get());
    }

    public function store(StoreOtherbranchRequest $request)
    {
        $otherbranch = Otherbranch::create($request->all());

        return (new OtherbranchResource($otherbranch))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Otherbranch $otherbranch)
    {
        abort_if(Gate::denies('otherbranch_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OtherbranchResource($otherbranch->load(['restaurants']));
    }

    public function update(UpdateOtherbranchRequest $request, Otherbranch $otherbranch)
    {
        $otherbranch->update($request->all());

        return (new OtherbranchResource($otherbranch))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Otherbranch $otherbranch)
    {
        abort_if(Gate::denies('otherbranch_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherbranch->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
