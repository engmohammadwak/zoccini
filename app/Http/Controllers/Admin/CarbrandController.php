<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCarbrandRequest;
use App\Http\Requests\StoreCarbrandRequest;
use App\Http\Requests\UpdateCarbrandRequest;
use App\Models\Carbrand;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarbrandController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('carbrand_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carbrands = Carbrand::all();

        return view('admin.carbrands.index', compact('carbrands'));
    }

    public function create()
    {
        abort_if(Gate::denies('carbrand_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carbrands.create');
    }

    public function store(StoreCarbrandRequest $request)
    {
        $carbrand = Carbrand::create($request->all());

        return redirect()->route('admin.carbrands.index');
    }

    public function edit(Carbrand $carbrand)
    {
        abort_if(Gate::denies('carbrand_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carbrands.edit', compact('carbrand'));
    }

    public function update(UpdateCarbrandRequest $request, Carbrand $carbrand)
    {
        $carbrand->update($request->all());

        return redirect()->route('admin.carbrands.index');
    }

    public function show(Carbrand $carbrand)
    {
        abort_if(Gate::denies('carbrand_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carbrands.show', compact('carbrand'));
    }

    public function destroy(Carbrand $carbrand)
    {
        abort_if(Gate::denies('carbrand_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carbrand->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarbrandRequest $request)
    {
        Carbrand::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
