<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserAlertRequest;
use App\Http\Requests\StoreUserAlertRequest;
use App\Models\User;
use App\Models\UserAlert;
use App\Notifications\SendMessageNotification;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class UserAlertsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_alert_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlerts = UserAlert::all();

        return view('admin.userAlerts.index', compact('userAlerts'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_alert_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::whereNotIn('user_type', [3, 10])->get();

        return view('admin.userAlerts.create', compact('users'));
    }

    public function store(StoreUserAlertRequest $request)
    {
        $userAlert = UserAlert::create($request->all());
        $users = [];
        if ($request->user_type == 'user') {
            $users = User::where('user_type', 2)->get();
        } elseif ($request->user_type == 'admin') {
            $users = User::where('user_type', 1)->get();
        } elseif ($request->user_type == 'restaurant') {
            $users = User::where('user_type', 3)->get();
        } else {
            $users = User::whereIn('id', $request->input('users', []))->get();
        }
        $userAlert->users()->sync($users);


        if ($request->user_type == 'user' || $request->user_type == 'one') {
            foreach ($users as $user) {
                if ($user->fcm_token) {
                    // send notification //////////////////////////
                    $notification = new SendMessageNotification($request->alert_text, $request->alert_body, null, null, 'admin');
                    send_notification_fcm($user->fcm_token, $notification->toFCM());
                    Notification::send($user, $notification);
                    //////////////////////////////////////////////////
                }
            }
        }

        return redirect()->route('admin.user-alerts.index');
    }

    public function show(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->load('users');

        return view('admin.userAlerts.show', compact('userAlert'));
    }

    public function destroy(UserAlert $userAlert)
    {
        abort_if(Gate::denies('user_alert_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAlert->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserAlertRequest $request)
    {
        UserAlert::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function read(Request $request)
    {
        $alerts = \Auth::user()->userUserAlerts()->where('read', false)->get();

        foreach ($alerts as $alert) {
            $pivot = $alert->pivot;
            $pivot->read = true;
            $pivot->save();
        }
    }
}
