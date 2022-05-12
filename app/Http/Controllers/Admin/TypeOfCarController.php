<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTypeOfCarRequest;
use App\Http\Requests\StoreTypeOfCarRequest;
use App\Http\Requests\UpdateTypeOfCarRequest;
use App\Models\Carbrand;
use App\Models\TypeOfCar;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeOfCarController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_of_car_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfCars = TypeOfCar::with(['car_type'])->get();

        return view('admin.typeOfCars.index', compact('typeOfCars'));
    }

    public function create()
    {
        abort_if(Gate::denies('type_of_car_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $car_types = Carbrand::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.typeOfCars.create', compact('car_types'));
    }

    public function store(StoreTypeOfCarRequest $request)
    {
        $typeOfCar = TypeOfCar::create($request->all());

        return redirect()->route('admin.type-of-cars.index');
    }

    public function edit(TypeOfCar $typeOfCar)
    {
        abort_if(Gate::denies('type_of_car_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $car_types = Carbrand::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $typeOfCar->load('car_type');

        return view('admin.typeOfCars.edit', compact('car_types', 'typeOfCar'));
    }

    public function update(UpdateTypeOfCarRequest $request, TypeOfCar $typeOfCar)
    {
        $typeOfCar->update($request->all());

        return redirect()->route('admin.type-of-cars.index');
    }

    public function show(TypeOfCar $typeOfCar)
    {
        abort_if(Gate::denies('type_of_car_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfCar->load('car_type');

        return view('admin.typeOfCars.show', compact('typeOfCar'));
    }

    public function destroy(TypeOfCar $typeOfCar)
    {
        abort_if(Gate::denies('type_of_car_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfCar->delete();

        return back();
    }

    public function massDestroy(MassDestroyTypeOfCarRequest $request)
    {
        TypeOfCar::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}