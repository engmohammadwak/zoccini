<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRateRequest;
use App\Http\Requests\StoreRateRequest;
use App\Http\Requests\UpdateRateRequest;
use App\Models\Rate;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RateController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rate_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rates = Rate::all();

        return view('admin.rates.index', compact('rates'));
    }

    public function create()
    {
        abort_if(Gate::denies('rate_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.rates.create', compact('users', 'restaurants'));
    }

    public function store(StoreRateRequest $request)
    {
        $rate = Rate::create($request->all());

        return redirect()->route('admin.rates.index');
    }

    public function edit(Rate $rate)
    {
        abort_if(Gate::denies('rate_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $rate->load('user', 'restaurant');

        return view('admin.rates.edit', compact('users', 'restaurants', 'rate'));
    }

    public function update(UpdateRateRequest $request, Rate $rate)
    {
        $rate->update($request->all());

        return redirect()->route('admin.rates.index');
    }

    public function show(Rate $rate)
    {
        abort_if(Gate::denies('rate_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rate->load('user', 'restaurant');

        return view('admin.rates.show', compact('rate'));
    }

    public function destroy(Rate $rate)
    {
        abort_if(Gate::denies('rate_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rate->delete();

        return back();
    }

    public function massDestroy(MassDestroyRateRequest $request)
    {
        Rate::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
