<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsHistory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SmsHistoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sms_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $smsHistories = SmsHistory::all();

        return view('admin.smsHistories.index', compact('smsHistories'));
    }

    public function destroy(SmsHistory $smsHistory)
    {

        $smsHistory->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        SmsHistory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
