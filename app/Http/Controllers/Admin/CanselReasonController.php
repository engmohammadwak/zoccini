<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCanselReasonRequest;
use App\Http\Requests\StoreCanselReasonRequest;
use App\Http\Requests\UpdateCanselReasonRequest;
use App\Models\CancelReason;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanselReasonController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cansel_reason_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $canselReasons = CancelReason::all();

        return view('admin.canselReasons.index', compact('canselReasons'));
    }

    public function create()
    {
        abort_if(Gate::denies('cansel_reason_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.canselReasons.create');
    }

    public function store(StoreCanselReasonRequest $request)
    {
        $canselReason = CancelReason::create($request->all());

        return redirect()->route('admin.cansel-reasons.index');
    }

    public function edit(CancelReason $canselReason)
    {
        abort_if(Gate::denies('cansel_reason_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.canselReasons.edit', compact('canselReason'));
    }

    public function update(UpdateCanselReasonRequest $request, CancelReason $canselReason)
    {
        $canselReason->update($request->all());

        return redirect()->route('admin.cansel-reasons.index');
    }

    public function show(CancelReason $canselReason)
    {
        abort_if(Gate::denies('cansel_reason_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.canselReasons.show', compact('canselReason'));
    }

    public function destroy(CancelReason $canselReason)
    {
        abort_if(Gate::denies('cansel_reason_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $canselReason->delete();

        return back();
    }

    public function massDestroy(MassDestroyCanselReasonRequest $request)
    {
        CancelReason::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
