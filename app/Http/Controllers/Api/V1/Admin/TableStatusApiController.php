<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTableStatusRequest;
use App\Http\Requests\UpdateTableStatusRequest;
use App\Http\Resources\Admin\TableStatusResource;
use App\Models\TableStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TableStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('table_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TableStatusResource(TableStatus::all());
    }

    public function store(StoreTableStatusRequest $request)
    {
        $tableStatus = TableStatus::create($request->all());

        return (new TableStatusResource($tableStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TableStatus $tableStatus)
    {
        abort_if(Gate::denies('table_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TableStatusResource($tableStatus);
    }

    public function update(UpdateTableStatusRequest $request, TableStatus $tableStatus)
    {
        $tableStatus->update($request->all());

        return (new TableStatusResource($tableStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TableStatus $tableStatus)
    {
        abort_if(Gate::denies('table_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tableStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
