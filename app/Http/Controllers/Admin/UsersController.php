<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all();

        $roles = Role::get();

        $user_statuses = UserStatus::get();

        return view('admin.users.index', compact('users', 'roles', 'user_statuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $statuses = UserStatus::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('roles', 'statuses'));
    }

    public function store(StoreUserRequest $request)
    {
        $request->request->add(['user_type' => $request->input('roles')[0]]);
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/user' , $user->image);
            $user->fill(['image' => $image])->save();
        }

        if ($request->input('roles')[0] == 3){
            $restaurant   = new Restaurant();
            $restaurant->restaurant_id = $user->id;
            $restaurant->name_ar = $user->name .' '.$user->last_name;
            $restaurant->name_en = $user->name .' '.$user->last_name;
            $restaurant->save();
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $statuses = UserStatus::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user->load('roles', 'status');

        return view('admin.users.edit', compact('roles', 'statuses', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->request->add(['user_type' => $request->input('roles')[0]]);
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'local/public/img/user' , $user->image);
            $user->fill(['image' => $image])->save();
        }

        if ($request->input('roles')[0] == 3){
            $restaurant   = new Restaurant();
            $restaurant->restaurant_id = $user->id;
            $restaurant->name_ar = $user->name .' '.$user->last_name;
            $restaurant->name_en = $user->name .' '.$user->last_name;
            $restaurant->save();
        }

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles', 'status', 'userUserAlerts');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
