<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionVipRequest;
use App\Http\Requests\UpdateSubscriptionVipRequest;
use App\Http\Resources\Admin\SubscriptionVipResource;
use App\Models\SubscriptionVip;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionVipApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_vip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionVipResource(SubscriptionVip::with(['user'])->get());
    }

    public function store(StoreSubscriptionVipRequest $request)
    {
        $subscriptionVip = SubscriptionVip::create($request->all());

        return (new SubscriptionVipResource($subscriptionVip))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SubscriptionVip $subscriptionVip)
    {
        abort_if(Gate::denies('subscription_vip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionVipResource($subscriptionVip->load(['user']));
    }

    public function update(UpdateSubscriptionVipRequest $request, SubscriptionVip $subscriptionVip)
    {
        $subscriptionVip->update($request->all());

        return (new SubscriptionVipResource($subscriptionVip))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubscriptionVip $subscriptionVip)
    {
        abort_if(Gate::denies('subscription_vip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionVip->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
