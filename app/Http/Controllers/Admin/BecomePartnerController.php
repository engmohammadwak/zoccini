<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBecomePartnerRequest;
use App\Http\Requests\StoreBecomePartnerRequest;
use App\Http\Requests\UpdateBecomePartnerRequest;
use App\Models\BecomePartner;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BecomePartnerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('become_partner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $becomePartners = BecomePartner::all();

        return view('admin.becomePartners.index', compact('becomePartners'));
    }

    public function create()
    {
        abort_if(Gate::denies('become_partner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.becomePartners.create');
    }

    public function store(StoreBecomePartnerRequest $request)
    {
        $becomePartner = BecomePartner::create($request->all());

        return redirect()->route('admin.become-partners.index');
    }

    public function edit(BecomePartner $becomePartner)
    {
        abort_if(Gate::denies('become_partner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.becomePartners.edit', compact('becomePartner'));
    }

    public function update(UpdateBecomePartnerRequest $request, BecomePartner $becomePartner)
    {
        $becomePartner->update($request->all());

        return redirect()->route('admin.become-partners.index');
    }

    public function show(BecomePartner $becomePartner)
    {
        abort_if(Gate::denies('become_partner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.becomePartners.show', compact('becomePartner'));
    }

    public function destroy(BecomePartner $becomePartner)
    {
        abort_if(Gate::denies('become_partner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $becomePartner->delete();

        return back();
    }

    public function massDestroy(MassDestroyBecomePartnerRequest $request)
    {
        BecomePartner::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
