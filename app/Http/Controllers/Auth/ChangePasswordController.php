<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Image;
use App\Models\Restaurant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       if (Auth::user()['user_type'] == 3)
       {
           $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();

           return view('auth.passwords.edit' , compact('restaurant'));
       }else{

           return view('auth.passwords.edit');
       }

    }

    public function update(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect()->route('profile.password.edit')->with('message', __('global.change_password_success'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->save();

        if (Auth::user()['user_type'] == 3)
        {
            $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();



            if ($request->file('logo')) {
                $image = uploadImage($request->file('logo'),'/public/img/user' , $user->image);
                $user->fill(['image' => $image])->save();
            }
            $restaurant->update($request->all());

            if ($request->file('image')) {
                $image = uploadImage($request->file('image'),'/public/img/'.Restaurant::DIR_UPLOAD , $restaurant->image);
                $restaurant->fill(['image' => $image])->save();
            }
            if ($request->file('photo')) {
                foreach ($request->file('photo') as $file) {
                    $photo_name = uploadImage($file,'/public/img/'.Image::COMPANY_MODEL );
                    Image::create([
                        'name' => $photo_name,
                        'model' => Image::COMPANY_MODEL,
                        'item' => $restaurant->id,
                    ]);
                }
            }
        }





        return redirect()->route('profile.password.edit')->with('message', __('global.update_profile_success'));
    }

    public function destroy()
    {
        $user = auth()->user();

        $user->update([
            'email' => time() . '_' . $user->email,
        ]);

        $user->delete();

        return redirect()->route('login')->with('message', __('global.delete_account_success'));
    }
}
