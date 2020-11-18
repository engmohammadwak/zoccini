<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOtherbranchRequest;
use App\Http\Requests\StoreOtherbranchRequest;
use App\Http\Requests\UpdateOtherbranchRequest;
use App\Models\Otherbranch;
use App\Models\Restaurant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtherbranchController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('otherbranch_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherbranches = Otherbranch::all();

        return view('admin.otherbranches.index', compact('otherbranches'));
    }

    public function create()
    {
        abort_if(Gate::denies('otherbranch_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.otherbranches.create', compact('restaurants'));
    }

    public function store(StoreOtherbranchRequest $request)
    {
        $otherbranch = Otherbranch::create($request->all());

        return redirect()->route('admin.otherbranches.index');
    }

    public function edit(Otherbranch $otherbranch)
    {
        abort_if(Gate::denies('otherbranch_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $otherbranch->load('restaurants');

        return view('admin.otherbranches.edit', compact('restaurants', 'otherbranch'));
    }

    public function update(UpdateOtherbranchRequest $request, Otherbranch $otherbranch)
    {
        $otherbranch->update($request->all());

        return redirect()->route('admin.otherbranches.index');
    }

    public function show(Otherbranch $otherbranch)
    {
        abort_if(Gate::denies('otherbranch_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherbranch->load('restaurants');

        return view('admin.otherbranches.show', compact('otherbranch'));
    }

    public function destroy(Otherbranch $otherbranch)
    {
        abort_if(Gate::denies('otherbranch_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherbranch->delete();

        return back();
    }

    public function massDestroy(MassDestroyOtherbranchRequest $request)
    {
        Otherbranch::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
