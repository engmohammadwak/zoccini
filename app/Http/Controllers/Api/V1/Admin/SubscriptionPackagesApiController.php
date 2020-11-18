<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionPackageRequest;
use App\Http\Requests\UpdateSubscriptionPackageRequest;
use App\Http\Resources\Admin\SubscriptionPackageResource;
use App\Models\SubscriptionPackage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionPackagesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_package_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionPackageResource(SubscriptionPackage::all());
    }

    public function store(StoreSubscriptionPackageRequest $request)
    {
        $subscriptionPackage = SubscriptionPackage::create($request->all());

        return (new SubscriptionPackageResource($subscriptionPackage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SubscriptionPackage $subscriptionPackage)
    {
        abort_if(Gate::denies('subscription_package_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionPackageResource($subscriptionPackage);
    }

    public function update(UpdateSubscriptionPackageRequest $request, SubscriptionPackage $subscriptionPackage)
    {
        $subscriptionPackage->update($request->all());

        return (new SubscriptionPackageResource($subscriptionPackage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubscriptionPackage $subscriptionPackage)
    {
        abort_if(Gate::denies('subscription_package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionPackage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
