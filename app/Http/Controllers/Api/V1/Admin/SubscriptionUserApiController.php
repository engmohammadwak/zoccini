<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionUserRequest;
use App\Http\Requests\UpdateSubscriptionUserRequest;
use App\Http\Resources\Admin\SubscriptionUserResource;
use App\Models\SubscriptionUser;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionUserApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionUserResource(SubscriptionUser::with(['user', 'package'])->get());
    }

    public function store(StoreSubscriptionUserRequest $request)
    {
        $subscriptionUser = SubscriptionUser::create($request->all());

        return (new SubscriptionUserResource($subscriptionUser))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SubscriptionUser $subscriptionUser)
    {
        abort_if(Gate::denies('subscription_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubscriptionUserResource($subscriptionUser->load(['user', 'package']));
    }

    public function update(UpdateSubscriptionUserRequest $request, SubscriptionUser $subscriptionUser)
    {
        $subscriptionUser->update($request->all());

        return (new SubscriptionUserResource($subscriptionUser))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubscriptionUser $subscriptionUser)
    {
        abort_if(Gate::denies('subscription_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionUser->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
