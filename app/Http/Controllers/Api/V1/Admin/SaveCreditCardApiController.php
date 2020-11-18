<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaveCreditCardRequest;
use App\Http\Requests\UpdateSaveCreditCardRequest;
use App\Http\Resources\Admin\SaveCreditCardResource;
use App\Models\SaveCreditCard;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveCreditCardApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('save_credit_card_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SaveCreditCardResource(SaveCreditCard::with(['user'])->get());
    }

    public function store(StoreSaveCreditCardRequest $request)
    {
        $saveCreditCard = SaveCreditCard::create($request->all());

        return (new SaveCreditCardResource($saveCreditCard))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SaveCreditCard $saveCreditCard)
    {
        abort_if(Gate::denies('save_credit_card_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SaveCreditCardResource($saveCreditCard->load(['user']));
    }

    public function update(UpdateSaveCreditCardRequest $request, SaveCreditCard $saveCreditCard)
    {
        $saveCreditCard->update($request->all());

        return (new SaveCreditCardResource($saveCreditCard))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SaveCreditCard $saveCreditCard)
    {
        abort_if(Gate::denies('save_credit_card_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saveCreditCard->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
