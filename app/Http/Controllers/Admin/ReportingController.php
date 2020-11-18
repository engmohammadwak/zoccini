<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReportingRequest;
use App\Http\Requests\StoreReportingRequest;
use App\Http\Requests\UpdateReportingRequest;
use App\Models\Reporting;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reporting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportings = Reporting::all();

        return view('admin.reportings.index', compact('reportings'));
    }

    public function create()
    {
        abort_if(Gate::denies('reporting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.reportings.create', compact('restaurants', 'users'));
    }

    public function store(StoreReportingRequest $request)
    {
        $reporting = Reporting::create($request->all());

        return redirect()->route('admin.reportings.index');
    }

    public function edit(Reporting $reporting)
    {
        abort_if(Gate::denies('reporting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reporting->load('restaurant', 'user');

        return view('admin.reportings.edit', compact('restaurants', 'users', 'reporting'));
    }

    public function update(UpdateReportingRequest $request, Reporting $reporting)
    {
        $reporting->update($request->all());

        return redirect()->route('admin.reportings.index');
    }

    public function show(Reporting $reporting)
    {
        abort_if(Gate::denies('reporting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reporting->load('restaurant', 'user');

        return view('admin.reportings.show', compact('reporting'));
    }

    public function destroy(Reporting $reporting)
    {
        abort_if(Gate::denies('reporting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reporting->delete();

        return back();
    }

    public function massDestroy(MassDestroyReportingRequest $request)
    {
        Reporting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
