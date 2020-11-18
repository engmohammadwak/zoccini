<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubscriptionUserRequest;
use App\Http\Requests\StoreSubscriptionUserRequest;
use App\Http\Requests\UpdateSubscriptionUserRequest;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionUser;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionUserController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionUsers = SubscriptionUser::all();

        return view('admin.subscriptionUsers.index', compact('subscriptionUsers'));
    }

    public function create()
    {
        abort_if(Gate::denies('subscription_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $packages = SubscriptionPackage::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subscriptionUsers.create', compact('users', 'packages'));
    }

    public function store(StoreSubscriptionUserRequest $request)
    {
        $subscriptionUser = SubscriptionUser::create($request->all());

        return redirect()->route('admin.subscription-users.index');
    }

    public function edit(SubscriptionUser $subscriptionUser)
    {
        abort_if(Gate::denies('subscription_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $packages = SubscriptionPackage::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subscriptionUser->load('user', 'package');

        return view('admin.subscriptionUsers.edit', compact('users', 'packages', 'subscriptionUser'));
    }

    public function update(UpdateSubscriptionUserRequest $request, SubscriptionUser $subscriptionUser)
    {
        $subscriptionUser->update($request->all());

        return redirect()->route('admin.subscription-users.index');
    }

    public function show(SubscriptionUser $subscriptionUser)
    {
        abort_if(Gate::denies('subscription_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionUser->load('user', 'package');

        return view('admin.subscriptionUsers.show', compact('subscriptionUser'));
    }

    public function destroy(SubscriptionUser $subscriptionUser)
    {
        abort_if(Gate::denies('subscription_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionUser->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionUserRequest $request)
    {
        SubscriptionUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
