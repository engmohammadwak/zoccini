<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySittingAreaRequest;
use App\Http\Requests\StoreSittingAreaRequest;
use App\Http\Requests\UpdateSittingAreaRequest;
use App\Models\SittingArea;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SittingAreaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sitting_area_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sittingAreas = SittingArea::all();

        return view('admin.sittingAreas.index', compact('sittingAreas'));
    }

    public function create()
    {
        abort_if(Gate::denies('sitting_area_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sittingAreas.create');
    }

    public function store(StoreSittingAreaRequest $request)
    {
        $sittingArea = SittingArea::create($request->all());

        return redirect()->route('admin.sitting-areas.index');
    }

    public function edit(SittingArea $sittingArea)
    {
        abort_if(Gate::denies('sitting_area_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sittingAreas.edit', compact('sittingArea'));
    }

    public function update(UpdateSittingAreaRequest $request, SittingArea $sittingArea)
    {
        $sittingArea->update($request->all());

        return redirect()->route('admin.sitting-areas.index');
    }

    public function show(SittingArea $sittingArea)
    {
        abort_if(Gate::denies('sitting_area_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sittingAreas.show', compact('sittingArea'));
    }

    public function destroy(SittingArea $sittingArea)
    {
        abort_if(Gate::denies('sitting_area_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sittingArea->delete();

        return back();
    }

    public function massDestroy(MassDestroySittingAreaRequest $request)
    {
        SittingArea::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
