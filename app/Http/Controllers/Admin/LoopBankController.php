<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoopBankRequest;
use App\Http\Requests\StoreLoopBankRequest;
use App\Http\Requests\UpdateLoopBankRequest;
use App\Models\LoopBank;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoopBankController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loop_bank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loopBanks = LoopBank::all();

        return view('admin.loopBanks.index', compact('loopBanks'));
    }

    public function create()
    {
        abort_if(Gate::denies('loop_bank_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loopBanks.create');
    }

    public function store(StoreLoopBankRequest $request)
    {
        $loopBank = LoopBank::create($request->all());

        return redirect()->route('admin.loop-banks.index');
    }

    public function edit(LoopBank $loopBank)
    {
        abort_if(Gate::denies('loop_bank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loopBanks.edit', compact('loopBank'));
    }

    public function update(UpdateLoopBankRequest $request, LoopBank $loopBank)
    {
        $loopBank->update($request->all());

        return redirect()->route('admin.loop-banks.index');
    }

    public function show(LoopBank $loopBank)
    {
        abort_if(Gate::denies('loop_bank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loopBanks.show', compact('loopBank'));
    }

    public function destroy(LoopBank $loopBank)
    {
        abort_if(Gate::denies('loop_bank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loopBank->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoopBankRequest $request)
    {
        LoopBank::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
