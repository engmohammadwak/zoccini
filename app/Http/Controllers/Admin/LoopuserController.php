<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoopuserRequest;
use App\Http\Requests\StoreLoopuserRequest;
use App\Http\Requests\UpdateLoopuserRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Loopuser;
use App\Models\ReferralSubscription;
use App\Models\Restaurant;
use App\Models\SubscriptionPackage;
use App\Models\User;
use App\Models\UserStatus;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class LoopuserController extends Controller
{
    public function index(Request  $request)
    {
        abort_if(Gate::denies('loopuser_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($request->type))
        {
            $loopusers = Loopuser::with(['country', 'city', 'user'])->whereHas('user' , function ($q) {
                $q->where('status_id' , '!=' , 1);
            })->get();
        }else{
            $loopusers = Loopuser::with(['country', 'city', 'user'])->get();
        }

        return view('admin.loopusers.index', compact('loopusers'));
    }

    public function create()
    {
        abort_if(Gate::denies('loopuser_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.loopusers.create', compact('countries', 'cities', 'users'));
    }

    public function store(StoreLoopuserRequest $request)
    {
        $loopuser = Loopuser::create($request->all());

        return redirect()->route('admin.loopusers.index');
    }

    public function edit(Loopuser $loopuser)
    {
        abort_if(Gate::denies('loopuser_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = UserStatus::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loopuser->load('country', 'city', 'user');

        return view('admin.loopusers.edit', compact('countries', 'cities','statuses', 'users', 'loopuser'));
    }

    public function update(Request $request, Loopuser $loopuser)
    {
        $user = User::find($loopuser->user_id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->status_id = $request->status_id;
        $user->save();

        $loopuser->update($request->all());

        return redirect()->route('admin.loopusers.index');
    }

    public function show(Loopuser $loopuser)
    {
        abort_if(Gate::denies('loopuser_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loopuser->load('country', 'city', 'user' , 'bank' ,'referral_subscription');
        $restaurant = Restaurant::get();

        $subscription_packages = SubscriptionPackage::get();
        $referralSubscriptions = ReferralSubscription::with(['user', 'user_loop', 'plan'])->where('user_loop_id' , $loopuser->id)->get();

        return view('admin.loopusers.show', compact('loopuser' ,'restaurant' , 'subscription_packages' , 'referralSubscriptions'));
    }

    public function destroy(Loopuser $loopuser)
    {
        abort_if(Gate::denies('loopuser_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loopuser->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoopuserRequest $request)
    {
        Loopuser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function active($id)
    {
        $res = Loopuser::find($id);
        $user = User::find($res->user_id);
        $user->status_id = 1;
        $user->save();

        return Redirect::back();
    }
}
