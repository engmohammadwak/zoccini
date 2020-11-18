<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportingRequest;
use App\Http\Requests\UpdateReportingRequest;
use App\Http\Resources\Admin\ReportingResource;
use App\Models\Reporting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reporting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReportingResource(Reporting::with(['restaurant', 'user'])->get());
    }

    public function store(StoreReportingRequest $request)
    {
        $reporting = Reporting::create($request->all());

        return (new ReportingResource($reporting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Reporting $reporting)
    {
        abort_if(Gate::denies('reporting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReportingResource($reporting->load(['restaurant', 'user']));
    }

    public function update(UpdateReportingRequest $request, Reporting $reporting)
    {
        $reporting->update($request->all());

        return (new ReportingResource($reporting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Reporting $reporting)
    {
        abort_if(Gate::denies('reporting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reporting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
