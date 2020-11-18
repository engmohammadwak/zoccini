<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExtraRequest;
use App\Http\Requests\StoreExtraRequest;
use App\Http\Requests\UpdateExtraRequest;
use App\Models\Extra;
use App\Models\Item;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtraController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('extra_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extras = Extra::all();

        return view('admin.extras.index', compact('extras'));
    }

    public function create()
    {
        abort_if(Gate::denies('extra_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = Item::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.extras.create', compact('items'));
    }

    public function store(StoreExtraRequest $request)
    {
        $extra = Extra::create($request->all());

        return redirect()->route('admin.extras.index');
    }

    public function edit(Extra $extra)
    {
        abort_if(Gate::denies('extra_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $items = Item::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $extra->load('item');

        return view('admin.extras.edit', compact('items', 'extra'));
    }

    public function update(UpdateExtraRequest $request, Extra $extra)
    {
        $extra->update($request->all());

        return redirect()->route('admin.extras.index');
    }

    public function show(Extra $extra)
    {
        abort_if(Gate::denies('extra_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extra->load('item');

        return view('admin.extras.show', compact('extra'));
    }

    public function destroy(Extra $extra)
    {
        abort_if(Gate::denies('extra_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extra->delete();

        return back();
    }

    public function massDestroy(MassDestroyExtraRequest $request)
    {
        Extra::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
