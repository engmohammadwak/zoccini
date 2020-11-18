<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubscriptionVipRequest;
use App\Http\Requests\StoreSubscriptionVipRequest;
use App\Http\Requests\UpdateSubscriptionVipRequest;
use App\Models\SubscriptionVip;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionVipController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_vip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionVips = SubscriptionVip::all();

        return view('admin.subscriptionVips.index', compact('subscriptionVips'));
    }

    public function create()
    {
        abort_if(Gate::denies('subscription_vip_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subscriptionVips.create', compact('users'));
    }

    public function store(StoreSubscriptionVipRequest $request)
    {
        $subscriptionVip = SubscriptionVip::create($request->all());

        return redirect()->route('admin.subscription-vips.index');
    }

    public function edit(SubscriptionVip $subscriptionVip)
    {
        abort_if(Gate::denies('subscription_vip_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subscriptionVip->load('user');

        return view('admin.subscriptionVips.edit', compact('users', 'subscriptionVip'));
    }

    public function update(UpdateSubscriptionVipRequest $request, SubscriptionVip $subscriptionVip)
    {
        $subscriptionVip->update($request->all());

        return redirect()->route('admin.subscription-vips.index');
    }

    public function show(SubscriptionVip $subscriptionVip)
    {
        abort_if(Gate::denies('subscription_vip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionVip->load('user');

        return view('admin.subscriptionVips.show', compact('subscriptionVip'));
    }

    public function destroy(SubscriptionVip $subscriptionVip)
    {
        abort_if(Gate::denies('subscription_vip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionVip->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionVipRequest $request)
    {
        SubscriptionVip::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
