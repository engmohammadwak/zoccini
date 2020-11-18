<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubscriptionPackageRequest;
use App\Http\Requests\StoreSubscriptionPackageRequest;
use App\Http\Requests\UpdateSubscriptionPackageRequest;
use App\Models\SubscriptionPackage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionPackagesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscription_package_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionPackages = SubscriptionPackage::all();

        return view('admin.subscriptionPackages.index', compact('subscriptionPackages'));
    }

    public function create()
    {
        abort_if(Gate::denies('subscription_package_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.subscriptionPackages.create');
    }

    public function store(StoreSubscriptionPackageRequest $request)
    {
        $subscriptionPackage = SubscriptionPackage::create($request->all());

        return redirect()->route('admin.subscription-packages.index');
    }

    public function edit(SubscriptionPackage $subscriptionPackage)
    {
        abort_if(Gate::denies('subscription_package_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.subscriptionPackages.edit', compact('subscriptionPackage'));
    }

    public function update(UpdateSubscriptionPackageRequest $request, SubscriptionPackage $subscriptionPackage)
    {
        $subscriptionPackage->update($request->all());

        return redirect()->route('admin.subscription-packages.index');
    }

    public function show(SubscriptionPackage $subscriptionPackage)
    {
        abort_if(Gate::denies('subscription_package_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.subscriptionPackages.show', compact('subscriptionPackage'));
    }

    public function destroy(SubscriptionPackage $subscriptionPackage)
    {
        abort_if(Gate::denies('subscription_package_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscriptionPackage->delete();

        return back();
    }

    public function massDestroy(MassDestroySubscriptionPackageRequest $request)
    {
        SubscriptionPackage::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
