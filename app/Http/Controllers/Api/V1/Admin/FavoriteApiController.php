<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Http\Resources\Admin\FavoriteResource;
use App\Models\Favorite;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FavoriteApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('favorite_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FavoriteResource(Favorite::with(['user', 'item', 'restaurant'])->get());
    }

    public function store(StoreFavoriteRequest $request)
    {
        $favorite = Favorite::create($request->all());

        return (new FavoriteResource($favorite))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Favorite $favorite)
    {
        abort_if(Gate::denies('favorite_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FavoriteResource($favorite->load(['user', 'item', 'restaurant']));
    }

    public function update(UpdateFavoriteRequest $request, Favorite $favorite)
    {
        $favorite->update($request->all());

        return (new FavoriteResource($favorite))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Favorite $favorite)
    {
        abort_if(Gate::denies('favorite_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $favorite->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
