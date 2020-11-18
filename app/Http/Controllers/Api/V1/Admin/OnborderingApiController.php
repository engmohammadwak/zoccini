<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreOnborderingRequest;
use App\Http\Requests\UpdateOnborderingRequest;
use App\Http\Resources\Admin\OnborderingResource;
use App\Models\Onbordering;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnborderingApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('onbordering_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OnborderingResource(Onbordering::all());
    }

    public function store(StoreOnborderingRequest $request)
    {
        $onbordering = Onbordering::create($request->all());

        if ($request->input('image', false)) {
            $onbordering->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        return (new OnborderingResource($onbordering))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Onbordering $onbordering)
    {
        abort_if(Gate::denies('onbordering_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OnborderingResource($onbordering);
    }

    public function update(UpdateOnborderingRequest $request, Onbordering $onbordering)
    {
        $onbordering->update($request->all());

        if ($request->input('image', false)) {
            if (!$onbordering->image || $request->input('image') !== $onbordering->image->file_name) {
                if ($onbordering->image) {
                    $onbordering->image->delete();
                }

                $onbordering->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($onbordering->image) {
            $onbordering->image->delete();
        }

        return (new OnborderingResource($onbordering))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Onbordering $onbordering)
    {
        abort_if(Gate::denies('onbordering_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $onbordering->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
