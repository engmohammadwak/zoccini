<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySaveCreditCardRequest;
use App\Http\Requests\StoreSaveCreditCardRequest;
use App\Http\Requests\UpdateSaveCreditCardRequest;
use App\Models\SaveCreditCard;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveCreditCardController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('save_credit_card_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saveCreditCards = SaveCreditCard::all();

        return view('admin.saveCreditCards.index', compact('saveCreditCards'));
    }

    public function create()
    {
        abort_if(Gate::denies('save_credit_card_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.saveCreditCards.create', compact('users'));
    }

    public function store(StoreSaveCreditCardRequest $request)
    {
        $saveCreditCard = SaveCreditCard::create($request->all());

        return redirect()->route('admin.save-credit-cards.index');
    }

    public function edit(SaveCreditCard $saveCreditCard)
    {
        abort_if(Gate::denies('save_credit_card_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $saveCreditCard->load('user');

        return view('admin.saveCreditCards.edit', compact('users', 'saveCreditCard'));
    }

    public function update(UpdateSaveCreditCardRequest $request, SaveCreditCard $saveCreditCard)
    {
        $saveCreditCard->update($request->all());

        return redirect()->route('admin.save-credit-cards.index');
    }

    public function show(SaveCreditCard $saveCreditCard)
    {
        abort_if(Gate::denies('save_credit_card_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saveCreditCard->load('user');

        return view('admin.saveCreditCards.show', compact('saveCreditCard'));
    }

    public function destroy(SaveCreditCard $saveCreditCard)
    {
        abort_if(Gate::denies('save_credit_card_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saveCreditCard->delete();

        return back();
    }

    public function massDestroy(MassDestroySaveCreditCardRequest $request)
    {
        SaveCreditCard::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
