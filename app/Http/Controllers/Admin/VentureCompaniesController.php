<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyVentureCompanyRequest;
use App\Http\Requests\StoreVentureCompanyRequest;
use App\Http\Requests\UpdateVentureCompanyRequest;
use App\Models\TopRestaurant;
use App\Models\VentureCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VentureCompaniesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('venture_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ventureCompanies = VentureCompany::all();

        return view('admin.ventureCompanies.index', compact('ventureCompanies'));
    }

    public function create()
    {
        abort_if(Gate::denies('venture_company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ventureCompanies.create');
    }

    public function store(StoreVentureCompanyRequest $request)
    {
        $ventureCompany = VentureCompany::create($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/venture_companies' , $ventureCompany->image);
            $ventureCompany->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.venture-companies.index');
    }

    public function edit(VentureCompany $ventureCompany)
    {
        abort_if(Gate::denies('venture_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ventureCompanies.edit', compact('ventureCompany'));
    }

    public function update(UpdateVentureCompanyRequest $request, VentureCompany $ventureCompany)
    {
        $ventureCompany->update($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/venture_companies' , $ventureCompany->image);
            $ventureCompany->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.venture-companies.index');
    }

    public function show(VentureCompany $ventureCompany)
    {
        abort_if(Gate::denies('venture_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ventureCompanies.show', compact('ventureCompany'));
    }

    public function destroy(VentureCompany $ventureCompany)
    {
        abort_if(Gate::denies('venture_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ventureCompany->delete();

        return back();
    }

    public function massDestroy(MassDestroyVentureCompanyRequest $request)
    {
        VentureCompany::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
