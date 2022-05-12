<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Auth::user()['user_type'] == 3)
        {
            return [
                'name'  => ['required', 'string', 'max:255'],
                'last_name'  => ['required', 'string', 'max:255'],
                'phone'  => ['required', 'string', 'max:255'],
                'name_ar'  => ['required', 'string', 'max:255'],
                'name_en'  => ['required', 'string', 'max:255'],
                'description_en'  => ['required', 'string', 'max:1000'],
                'description_ar'  => ['required', 'string', 'max:1000'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            ];
        }else{
            return [
                'name'  => ['required', 'string', 'max:255'],
                'last_name'  => ['required', 'string', 'max:255'],
                'phone'  => ['required', 'string', 'max:255'],
                ];
        }

    }
}
