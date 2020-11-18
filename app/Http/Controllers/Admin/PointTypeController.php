<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPointTypeRequest;
use App\Http\Requests\StorePointTypeRequest;
use App\Http\Requests\UpdatePointTypeRequest;
use App\Models\PointType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PointTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('point_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pointTypes = PointType::all();

        return view('admin.pointTypes.index', compact('pointTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('point_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pointTypes.create');
    }

    public function store(StorePointTypeRequest $request)
    {
        $pointType = PointType::create($request->all());

        return redirect()->route('admin.point-types.index');
    }

    public function edit(PointType $pointType)
    {
        abort_if(Gate::denies('point_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pointTypes.edit', compact('pointType'));
    }

    public function update(UpdatePointTypeRequest $request, PointType $pointType)
    {
        $pointType->update($request->all());

        return redirect()->route('admin.point-types.index');
    }

    public function show(PointType $pointType)
    {
        abort_if(Gate::denies('point_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pointTypes.show', compact('pointType'));
    }

    public function destroy(PointType $pointType)
    {
        abort_if(Gate::denies('point_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pointType->delete();

        return back();
    }

    public function massDestroy(MassDestroyPointTypeRequest $request)
    {
        PointType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
