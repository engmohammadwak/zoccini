<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Http\Resources\Admin\TableResource;
use App\Models\Table;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TablesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('table_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TableResource(Table::with(['sitting_area', 'status'])->get());
    }

    public function store(StoreTableRequest $request)
    {
        $table = Table::create($request->all());

        return (new TableResource($table))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Table $table)
    {
        abort_if(Gate::denies('table_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TableResource($table->load(['sitting_area', 'status']));
    }

    public function update(UpdateTableRequest $request, Table $table)
    {
        $table->update($request->all());

        return (new TableResource($table))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Table $table)
    {
        abort_if(Gate::denies('table_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $table->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
