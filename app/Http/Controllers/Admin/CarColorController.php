<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCarColorRequest;
use App\Http\Requests\StoreCarColorRequest;
use App\Http\Requests\UpdateCarColorRequest;
use App\Models\CarColor;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarColorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('car_color_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carColors = CarColor::all();

        return view('admin.carColors.index', compact('carColors'));
    }

    public function create()
    {
        abort_if(Gate::denies('car_color_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carColors.create');
    }

    public function store(StoreCarColorRequest $request)
    {
        $carColor = CarColor::create($request->all());

        return redirect()->route('admin.car-colors.index');
    }

    public function edit(CarColor $carColor)
    {
        abort_if(Gate::denies('car_color_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carColors.edit', compact('carColor'));
    }

    public function update(UpdateCarColorRequest $request, CarColor $carColor)
    {
        $carColor->update($request->all());

        return redirect()->route('admin.car-colors.index');
    }

    public function show(CarColor $carColor)
    {
        abort_if(Gate::denies('car_color_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carColors.show', compact('carColor'));
    }

    public function destroy(CarColor $carColor)
    {
        abort_if(Gate::denies('car_color_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carColor->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarColorRequest $request)
    {
        CarColor::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
