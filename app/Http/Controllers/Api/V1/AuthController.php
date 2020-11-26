<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\AdResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validation = Validator::make($request->only(['phone', 'password']), [
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {

            if ($request->phone == '') {
                return errorResponse(trans('cruds.api.phone'));
            } elseif ($request->password == '') {
                return errorResponse(trans('cruds.api.password'));
            }

        } else {
            $user_count_phone = User::where('phone', $request->phone)->count();
            if ($user_count_phone == 0) {
                return errorResponse(trans('cruds.api.no_account'));
            } else {
                $credentials = $request->only(['phone', 'password']);
                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    if ($user->status_id == 2) {
                        return errorResponse(trans('cruds.api.not_active'));
                    } elseif ($user->status_id == 3) {
                        return errorResponse(trans('cruds.api.ban'));
                    } else {
                        if ($request->fcm_token !== '') {
                            $user->fill(['fcm_token' => $request->fcm_token])->save();
                        }
                        $token = $user->createToken('user')->accessToken;
                        $data = new UserResource($user);

                        return successResponse(trans('cruds.api.success'), $data, $token);
                    }
                } else {
                    return errorResponse(trans('cruds.api.Unauthorized'));
                }
            }
        }
    }

    public function register(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            if ($request->first_name == '') {
                return errorResponse(trans('cruds.api.first_name'));
            } elseif ($request->last_name == '') {
                return errorResponse(trans('cruds.api.last_name'));
            } elseif ($request->email == '') {
                return errorResponse(trans('cruds.api.email'));
            } elseif ($request->phone == '') {
                return errorResponse(trans('cruds.api.phone'));
            } elseif ($request->password == '') {
                return errorResponse(trans('cruds.api.password'));
            }
        } else {
            $user_count_phone = User::where('phone', $request->phone)->count();
            $user_count_email = User::where('email', $request->email)->count();
            if ($user_count_phone > 0) {
                return errorResponse(trans('cruds.api.phone_exist'));
            }
            if ($user_count_email > 0) {
                return errorResponse(trans('cruds.api.email_exist'));
            }
            $code = rand(10000, 99999);
            $user = User::create([
                'name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => '2',
                'code' => $code,
                'status_id' => '2',
                'password' => bcrypt($request->password),
            ]);
            $user->roles()->sync('2');

            $data = [
                'code' => $code,
                'name' => $request->first_name .' '.$request->last_name,
                'phone' => $request->phone,
            ];

            send_pin($code, $request->phone);
            return successResponse(trans('cruds.api.message_sent'), $data);
        }
    }

    public function logout(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);


        $id = Auth::id();
        $user = User::find($id);
        $user->fill(['fcm_token' => ' '])->save();
        $request->user()->token()->revoke();

        return response()->json([
            'message' => trans('cruds.api.logout'),
            'status' => 1,
        ]);

    }

    public function user(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $data = new UserResource($request->user());
        return successResponse(trans('cruds.api.success'), $data);

    }

    public function update_profile(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $id = Auth::id();
        $user = User::find($id);
        $user->fill(array_except($request->all(), ['password', 'phone', 'email']))->save();
        $data = new UserResource($user);

        return successResponse(trans('cruds.api.success'), $data);
    }

    public function update_passwprd(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $validation = Validator::make($request->all(), [
            'new_password' => 'required',
            'confirmed_password' => 'required|same:new_password',
        ]);
        if ($validation->fails()) {
            if ($request->new_password == '') {
                return errorResponse(trans('cruds.api.new_password'));
            } elseif ($request->confirmed_password == '') {
                return errorResponse(trans('cruds.api.confirmed_password'));
            } else {
                return errorResponse(trans('cruds.api.confirmed_password_same'));
            }
        } else {
            if ($request->old_password == '') {
                $id = Auth::id();
                $user = User::find($id);
                $user->fill([
                    'password' => Hash::make($request->new_password)
                ])->save();
                return successResponse(trans('cruds.api.success'), null);
            } else {
                $id = Auth::id();
                $user = User::find($id);

                if (Hash::check($request->old_password, $user->password)) {
                    $user->fill([
                        'password' => Hash::make($request->new_password)
                    ])->save();
                    return successResponse(trans('cruds.api.success'), null);

                } else {
                    return errorResponse(trans('cruds.api.similarity'));
                }

            }

        }
    }

    public function reset_code(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validation = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validation->fails()) {
            if ($request->phone == '') {
                return errorResponse(trans('cruds.api.phone'));
            }
        } else {
            $code = rand(10000, 99999);
            $users = User::where('phone', $request->phone)->first();
            if ($users) {
                $users->update(['code' => $code]);

                $data = [
                    'code' => $code,
                    'name' => $users->name .' '.$users->last_name,
                    'phone' => $request->phone,
                ];
                send_pin($code, $request->phone);

                return successResponse(trans('cruds.api.message_sent'), $data);


            } else {
                return errorResponse(trans('cruds.api.phone_not_found'));
            }
        }
    }

    public function activate_code(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $validation = Validator::make($request->all(), [
            'phone' => 'required',
            'code' => 'required',
        ]);

        if ($validation->fails()) {
            if ($request->phone == '') {
                return errorResponse(trans('cruds.api.phone'));
            } elseif ($request->code == '') {
                return errorResponse(trans('cruds.api.code'));
            }
        } else {
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                if ($user->code == $request->code) {
                    $user->update(['status_id' => '1']);
                    if ($request->fcm_token !== '') {
                        $user->fill(['fcm_token' => $request->fcm_token])->save();
                    }
                    $token = $user->createToken('user')->accessToken;
                    $data = new UserResource($user);
                    return successResponse(trans('cruds.api.success'), $data, $token);
                } else {
                    return errorResponse(trans('cruds.api.phone_error'));
                }
            } else {
                return errorResponse(trans('cruds.api.phone_not_found'));
            }
        }
    }

}
