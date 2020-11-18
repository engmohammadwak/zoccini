<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDeliveryCompanyRequest;
use App\Http\Requests\StoreDeliveryCompanyRequest;
use App\Http\Requests\UpdateDeliveryCompanyRequest;
use App\Models\DeliveryCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryCompanyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('delivery_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryCompanies = DeliveryCompany::all();

        return view('admin.deliveryCompanies.index', compact('deliveryCompanies'));
    }

    public function create()
    {
        abort_if(Gate::denies('delivery_company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.deliveryCompanies.create');
    }

    public function store(StoreDeliveryCompanyRequest $request)
    {
        $deliveryCompany = DeliveryCompany::create($request->all());

        return redirect()->route('admin.delivery-companies.index');
    }

    public function edit(DeliveryCompany $deliveryCompany)
    {
        abort_if(Gate::denies('delivery_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.deliveryCompanies.edit', compact('deliveryCompany'));
    }

    public function update(UpdateDeliveryCompanyRequest $request, DeliveryCompany $deliveryCompany)
    {
        $deliveryCompany->update($request->all());

        return redirect()->route('admin.delivery-companies.index');
    }

    public function show(DeliveryCompany $deliveryCompany)
    {
        abort_if(Gate::denies('delivery_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.deliveryCompanies.show', compact('deliveryCompany'));
    }

    public function destroy(DeliveryCompany $deliveryCompany)
    {
        abort_if(Gate::denies('delivery_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryCompany->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeliveryCompanyRequest $request)
    {
        DeliveryCompany::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
