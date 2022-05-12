<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCarListRequest;
use App\Http\Requests\StoreCarListRequest;
use App\Http\Requests\UpdateCarListRequest;
use App\Models\Carbrand;
use App\Models\CarColor;
use App\Models\CarList;
use App\Models\TypeOfCar;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarListController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('car_list_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carLists = CarList::with(['car_brand', 'car_type', 'car_color'])->get();

        return view('admin.carLists.index', compact('carLists'));
    }

    public function create()
    {
        abort_if(Gate::denies('car_list_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $car_brands = Carbrand::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $car_types = TypeOfCar::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $car_colors = CarColor::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.carLists.create', compact('car_brands', 'car_types', 'car_colors'));
    }

    public function store(StoreCarListRequest $request)
    {
        $carList = CarList::create($request->all());

        return redirect()->route('admin.car-lists.index');
    }

    public function edit(CarList $carList)
    {
        abort_if(Gate::denies('car_list_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $car_brands = Carbrand::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $car_types = TypeOfCar::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $car_colors = CarColor::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $carList->load('car_brand', 'car_type', 'car_color');

        return view('admin.carLists.edit', compact('car_brands', 'car_types', 'car_colors', 'carList'));
    }

    public function update(UpdateCarListRequest $request, CarList $carList)
    {
        $carList->update($request->all());

        return redirect()->route('admin.car-lists.index');
    }

    public function show(CarList $carList)
    {
        abort_if(Gate::denies('car_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carList->load('car_brand', 'car_type', 'car_color');

        return view('admin.carLists.show', compact('carList'));
    }

    public function destroy(CarList $carList)
    {
        abort_if(Gate::denies('car_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carList->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarListRequest $request)
    {
        CarList::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
