<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReferralSubscriptionRequest;
use App\Http\Requests\StoreReferralSubscriptionRequest;
use App\Http\Requests\UpdateReferralSubscriptionRequest;
use App\Models\ReferralSubscription;
use App\Models\Restaurant;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReferralSubscriptionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('referral_subscription_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referralSubscriptions = ReferralSubscription::with(['user', 'user_loop', 'plan'])->get();

        $users = User::where('user_type' , 12)->get();
        $restaurant = Restaurant::get();

        $subscription_packages = SubscriptionPackage::get();

        return view('admin.referralSubscriptions.index', compact('referralSubscriptions', 'users','restaurant', 'subscription_packages'));
    }

    public function create()
    {
        abort_if(Gate::denies('referral_subscription_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_loops = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plans = SubscriptionPackage::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.referralSubscriptions.create', compact('users', 'user_loops', 'plans'));
    }

    public function store(StoreReferralSubscriptionRequest $request)
    {
        $referralSubscription = ReferralSubscription::create($request->all());

        return redirect()->route('admin.referral-subscriptions.index');
    }

    public function edit(ReferralSubscription $referralSubscription)
    {
        abort_if(Gate::denies('referral_subscription_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user_loops = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $plans = SubscriptionPackage::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $referralSubscription->load('user', 'user_loop', 'plan');

        return view('admin.referralSubscriptions.edit', compact('users', 'user_loops', 'plans', 'referralSubscription'));
    }

    public function update(UpdateReferralSubscriptionRequest $request, ReferralSubscription $referralSubscription)
    {
        $referralSubscription->update($request->all());

        return redirect()->route('admin.referral-subscriptions.index');
    }

    public function show(ReferralSubscription $referralSubscription)
    {
        abort_if(Gate::denies('referral_subscription_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referralSubscription->load('user', 'user_loop', 'plan');

        return view('admin.referralSubscriptions.show', compact('referralSubscription'));
    }

    public function destroy(ReferralSubscription $referralSubscription)
    {
        abort_if(Gate::denies('referral_subscription_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referralSubscription->delete();

        return back();
    }

    public function massDestroy(MassDestroyReferralSubscriptionRequest $request)
    {
        ReferralSubscription::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
