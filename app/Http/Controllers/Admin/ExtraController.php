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
    public function index($id)
    {
        abort_if(Gate::denies('extra_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extras = Extra::where('item_id' , $id)->get();

        return view('admin.extras.index', compact('extras' , 'id'));
    }

    public function create($id)
    {
        abort_if(Gate::denies('extra_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        $items = Item::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.extras.create', compact('id'));
    }

    public function store(StoreExtraRequest $request)
    {
        $extra = Extra::create($request->all());

        return redirect()->route('admin.items.extra', $request->item_id);
    }

    public function edit(Extra $extra)
    {
        abort_if(Gate::denies('extra_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.extras.edit', compact( 'extra'));
    }

    public function update(UpdateExtraRequest $request, Extra $extra)
    {
        $extra->update($request->all());

        return redirect()->route('admin.items.extra', $request->item_id);
    }

    public function show(Extra $extra)
    {
        abort_if(Gate::denies('extra_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
