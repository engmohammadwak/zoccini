<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class EmployeesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employees_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();

        $users = User::where('restaurant_id' , $restaurant->id)->get();

        $user_statuses = UserStatus::get();

        return view('admin.employees.index', compact('users', 'user_statuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('employees_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = UserStatus::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.employees.create', compact('statuses'));
    }

    public function store(StoreUserRequest $request)
    {
        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        $request->request->add(['restaurant_id'=> $restaurant->id , 'user_type' => 10]);
        $user = User::create($request->all());
        $user->roles()->sync(10);
        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/user' , $user->image);
            $user->fill(['image' => $image])->save();
        }

        return redirect()->route('admin.employees.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('employees_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::find($id);
        $statuses = UserStatus::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user->load( 'status');

        return view('admin.employees.edit', compact( 'statuses', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'),'/public/img/user' , $user->image);
            $user->image = $image;
            $user->save();
        }

        return redirect()->route('admin.employees.index');
    }

    public function show($id)
    {
        abort_if(Gate::denies('employees_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::find($id);
        $user->load( 'status', 'userUserAlerts');

        return view('admin.employees.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('employees_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
