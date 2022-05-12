<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\AdResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Laravel\Socialite\Facades\Socialite;
use Validator;

class AuthController extends Controller
{
    protected $expiresAtAccessToken = 9999; // week


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
                $user_count_email = User::where('email', $request->phone)->count();
                if ($user_count_email > 0) {
                    $phone = User::where('email', $request->phone)->first()->phone;
                    $request->request->add(['phone' => $phone]);
                    return $this->check_login($request);

                } else {
                    return errorResponse(trans('cruds.api.no_account'));
                }

            } else {
                return $this->check_login($request);
            }
        }
    }

    public function check_login($request)
    {
        $credentials = $request->only(['phone', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status_id == 2) {
                $data = [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'phone' => $request->phone,
                    'isActive' => $user->status_id == 1 ? true : false,
                ];
                return successResponse(trans('cruds.api.success'), $data);

            } elseif ($user->status_id == 3) {
                $data = [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'phone' => $request->phone,
                    'isActive' => $user->status_id == 1 ? true : false,
                    'isBan' => true,
                ];
                return successResponse(trans('cruds.api.success'), $data);

            } else {
                if ($request->fcm_token !== '') {
                    $user->fill(['fcm_token' => $request->fcm_token])->save();
                }
                $token = $token = [
                    'token' => $user->createToken('user')->accessToken,
                    'tokenType' => 'Bearer',
                    'expires_at' => Carbon::parse($user->createToken('user')->token->expires_at)->toDateTimeString(),
                    'type' => (int) $user->user_type,
                    'user' => new UserResource($user),
                ];

                $user->online = 1;
                $user->save();
                return successResponse(trans('cruds.api.success'), $token);
            }
        } else {
            return errorResponse(trans('cruds.api.Unauthorized'));
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
            if ($request->fcm_token !== '') {
                $user->fill(['fcm_token' => $request->fcm_token])->save();
            }
            $user->roles()->sync('2');

            $data = [
                'code' => $code,
                'name' => $request->first_name . ' ' . $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
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
        $user->fill(['fcm_token' => ' ' , 'online' => 0])->save();
        $request->user()->token()->revoke();

        return successResponse(trans('cruds.api.success'), null);


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

    public function update_email(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $validation = Validator::make($request->all(), [
            'current_email' => 'required',
            'new_email' => 'required',
            'confirmed_email' => 'required|same:new_email',
        ]);
        if ($validation->fails()) {
            if ($request->new_email == '') {
                return errorResponse(trans('cruds.api.new_email'));
            } elseif ($request->current_email == '') {
                return errorResponse(trans('cruds.api.current_email'));
            } elseif ($request->confirmed_email == '') {
                return errorResponse(trans('cruds.api.confirmed_email'));
            } else {
                return errorResponse(trans('cruds.api.confirmed_email_same'));
            }
        } else {
            $id = Auth::id();
            $user = User::find($id);

            if ($request->current_email == $user->email) {
                $user_count_email = User::where('email', $request->new_email)->count();

                if ($user_count_email > 0) {
                    return errorResponse(trans('cruds.api.email_exist'));
                }

                $user->fill([
                    'email' => $request->new_email])->save();
                return successResponse(trans('cruds.api.success'), null);

            } else {
                return errorResponse(trans('cruds.api.similarity'));
            }
        }
    }


    public function update_phone(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);
        $validation = Validator::make($request->all(), [
            'current_phone' => 'required',
            'new_phone' => 'required',
            'confirmed_phone' => 'required|same:new_phone',
        ]);
        if ($validation->fails()) {
            if ($request->new_phone == '') {
                return errorResponse(trans('cruds.api.new_phone'));
            } elseif ($request->current_phone == '') {
                return errorResponse(trans('cruds.api.current_phone'));
            } elseif ($request->confirmed_phone == '') {
                return errorResponse(trans('cruds.api.confirmed_phone'));
            } else {
                return errorResponse(trans('cruds.api.confirmed_phone_same'));
            }
        } else {
            $id = Auth::id();
            $user = User::find($id);

            if ($request->current_phone == $user->phone) {
                $user_count_phone = User::where('phone', $request->phone)->count();
                if ($user_count_phone > 0) {
                    return errorResponse(trans('cruds.api.phone_exist'));
                }
                $user->fill([
                    'phone' => $request->new_phone])->save();
                return successResponse(trans('cruds.api.success'), null);

            } else {
                return errorResponse(trans('cruds.api.similarity_phone'));
            }
        }
    }

    public function reset_code(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        $code = rand(10000, 99999);
        if ($request->phone) {
            $users = User::where('phone', $request->phone)->first();
            if ($users) {
                $users->update(['code' => $code]);
                if ($request->fcm_token !== '') {
                    $users->fill(['fcm_token' => $request->fcm_token])->save();
                }
                $data = [
                    'code' => $code,
                    'name' => $users->name . ' ' . $users->last_name,
                    'phone' => $request->phone,
                ];
               send_pin($code, $request->phone, 0);

                return successResponse(trans('cruds.api.message_sent'), $data);


            } else {
                return errorResponse(trans('cruds.api.phone_not_found'));
            }
        }

        if ($request->email) {
            $users = User::where('email', $request->email)->first();
            if ($users) {
                $users->update(['code' => $code]);
                if ($request->fcm_token !== '') {
                    $users->fill(['fcm_token' => $request->fcm_token])->save();
                }
                $data = [
                    'code' => $code,
                    'name' => $users->name . ' ' . $users->last_name,
                    'email' => $request->email,
                ];
                send_pin($code, $request->email, 1);

                return successResponse(trans('cruds.api.message_sent'), $data);

            } else {
                return errorResponse(trans('cruds.api.email_not_found'));
            }
        }
    }

    public function activate_code(Request $request)
    {
        $lang = $request->header('lang');
        setLang($lang);

        if ($request->code == '') {
            return errorResponse(trans('cruds.api.code'));
        }
        if ($request->phone != '') {
            $user = User::where('phone', $request->phone)->first();
            }else{
            $user = User::where('email', $request->email)->first();
        }
            if ($user) {
                if ($user->code == $request->code) {
                    $user->update(['status_id' => '1']);
                    if ($request->fcm_token !== '') {
                        $user->fill(['fcm_token' => $request->fcm_token])->save();
                    }
                    $token = [
                        'token' => $user->createToken('user')->accessToken,
                        'tokenType' => 'Bearer',
                        'expires_at' => Carbon::parse($user->createToken('user')->token->expires_at)->toDateTimeString(),
                    ];
                    return successResponse(trans('cruds.api.success'), $token);
                } else {
                    return errorResponse(trans('cruds.api.phone_or_email_error'));
                }
            } else {
                return errorResponse(trans('cruds.api.phone_or_email_not_found'));
            }



    }

    public function social_login(Request $request)
    {
        $phone_user = User::where('phone', '=', $request->phone);
        if ($phone_user->exists()) {
            $get_user = $phone_user->first();
            $token = [
                'token' => $get_user->createToken('user')->accessToken,
                'tokenType' => 'Bearer',
                'expires_at' => Carbon::parse($get_user->createToken('user')->token->expires_at)->toDateTimeString(),
                'type' => (int) $get_user->user_type,
                'user' => new UserResource($get_user),
            ];
            $get_user->fcm_token = $request->filled('fcm_token') ? $request->fcm_token : "";
            $get_user->online = 1;
            $get_user->save();
            return successResponse(trans('cruds.api.success'), $token);
        }

        $social_unique_id_user = User::where('social_unique_id', '=', $request->social_unique_id)
            ->whereNotNull('social_unique_id');

        if ($social_unique_id_user->exists()) {
            $get_user = $social_unique_id_user->first();
            $token = [
                'token' => $get_user->createToken('user')->accessToken,
                'tokenType' => 'Bearer',
                'expires_at' => Carbon::parse($get_user->createToken('user')->token->expires_at)->toDateTimeString(),
                'type' => (int) $get_user->user_type,
                'user' => new UserResource($get_user),
            ];
            $get_user->fcm_token = $request->filled('fcm_token') ? $request->fcm_token : "";
            $get_user->online = 1;
            $get_user->save();
            return successResponse(trans('cruds.api.success'), $token);
        }

        $check_data = $this->check_social_login_user($request->toArray());
        if ($check_data['status']) {
            $social_type = $request->social_type;
            $social_unique_id = $request->social_unique_id;

            $data = [];
            $data['social_type'] = $social_type;
            $data['social_unique_id'] = $social_unique_id;

            $data['status_id'] = 1;
            $data['fcm_token'] = $request->filled('fcm_token') ? $request->fcm_token : "";

            $user = User::create([
                'name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => '2',
                'code' => '0000',
                'status_id' => '2',
                'social_type' => $social_type,
                'social_unique_id' => $social_unique_id,
                'password' => bcrypt('123125'),
            ]);
            $user->roles()->sync('2');

            $token = [
                'token' => $user->createToken('user')->accessToken,
                'tokenType' => 'Bearer',
                'expires_at' => Carbon::parse($user->createToken('user')->token->expires_at)->toDateTimeString(),
                'type' => (int) $user->user_type,
                'user' => new UserResource($user),
            ];
            $user->fcm_token = $request->filled('fcm_token') ? $request->fcm_token : "";
            $user->online = 1;
            $user->save();
            return successResponse(trans('cruds.api.success'), $token);


        } else {
            return errorResponse( $check_data['message']);
        }


    }

    public function check_social_login_user($data)
    {
        $rules = [
            'first_name' => [
                'required',
            ],
            'email' => [
                'required', 'email','unique:users'
            ],
            'social_type' => 'required|in:google,facebook',
            'social_unique_id' => 'required',
        ];
        $validator = $this->check_data($data, $rules);
        return $validator;
    }

    public function check_data($data ,$rules ) {

        $validator_response = \Illuminate\Support\Facades\Validator::make($data , $rules);
        if($validator_response->fails()) {
            $response['status'] = false;
            $response['message'] = $validator_response->errors()->first();
        }else {
            $response['status'] = true;
            $response['message'] = "";
        }

        return $response;
    }




}
