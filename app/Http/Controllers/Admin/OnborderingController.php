<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOnborderingRequest;
use App\Http\Requests\StoreOnborderingRequest;
use App\Http\Requests\UpdateOnborderingRequest;
use App\Models\Onbordering;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class OnborderingController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('onbordering_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $onborderings = Onbordering::all();

        return view('admin.onborderings.index', compact('onborderings'));
    }

    public function create()
    {
        abort_if(Gate::denies('onbordering_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.onborderings.create');
    }

    public function store(StoreOnborderingRequest $request)
    {
        $onbordering = Onbordering::create($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/onbording' , $onbordering->image);
            $onbordering->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.onborderings.index');
    }

    public function edit(Onbordering $onbordering)
    {
        abort_if(Gate::denies('onbordering_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.onborderings.edit', compact('onbordering'));
    }

    public function update(UpdateOnborderingRequest $request, Onbordering $onbordering)
    {
        $onbordering->update($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/onbording' , $onbordering->image);
            $onbordering->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.onborderings.index');
    }

    public function show(Onbordering $onbordering)
    {
        abort_if(Gate::denies('onbordering_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.onborderings.show', compact('onbordering'));
    }

    public function destroy(Onbordering $onbordering)
    {
        abort_if(Gate::denies('onbordering_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $onbordering->delete();

        return back();
    }

    public function massDestroy(MassDestroyOnborderingRequest $request)
    {
        Onbordering::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('onbordering_create') && Gate::denies('onbordering_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Onbordering();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
