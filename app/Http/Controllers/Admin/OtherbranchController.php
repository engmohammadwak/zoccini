<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOtherbranchRequest;
use App\Http\Requests\StoreOtherbranchRequest;
use App\Http\Requests\UpdateOtherbranchRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Otherbranch;
use App\Models\Restaurant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class OtherbranchController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('otherbranch_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurant = Restaurant::where('restaurant_id' , Auth::id())->first();
        if (Auth::user()['user_type'] == 3) {
            $otherbranches = Otherbranch::where('restaurants_id' , $restaurant->id)->get();
        } else {
            $otherbranches = Otherbranch::all();
        }

        return view('admin.otherbranches.index', compact('otherbranches'));
    }

    public function create()
    {
        abort_if(Gate::denies('otherbranch_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.otherbranches.create', compact('restaurants'));
    }

    public function store(StoreOtherbranchRequest $request)
    {
        $restaurant = Restaurant::where('restaurant_id', Auth::id())->first();

        $request->request->add(['restaurants_id' => $restaurant->id , 'payment_status' => true]);

        $otherbranch = Otherbranch::create($request->all());


        if ($otherbranch)
        {
            $user = new User();
            $user->name = $request->branch_name_ar;
            $user->last_name = $request->branch_name_ar;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 3;
            $user->status_id = 1;
            $user->restaurant_id = $restaurant->id;
            $user->save();
            $user->roles()->sync(3);
            $request->request->add(['restaurant_id' => $user->id]);

            $restaurant = new Restaurant();
            $restaurant->name_ar = $request->branch_name_ar;
            $restaurant->name_en = $request->branch_name_en;
            $restaurant->address = $request->branch_address_ar;
            $restaurant->main_restaurant = $restaurant->id;
            $restaurant->restaurant_id = $user->id;
            $restaurant->save();


        }
        return redirect()->route('admin.otherbranches.index');
    }

    public function edit(Otherbranch $otherbranch)
    {
        abort_if(Gate::denies('otherbranch_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all()->pluck('name_en', 'id')->prepend(trans('global.pleaseSelect'), '');

        $otherbranch->load('restaurants');

        return view('admin.otherbranches.edit', compact('restaurants', 'otherbranch'));
    }

    public function update(UpdateOtherbranchRequest $request, Otherbranch $otherbranch)
    {
        $otherbranch->update($request->all());

        return redirect()->route('admin.otherbranches.index');
    }

    public function show(Otherbranch $otherbranch)
    {
        abort_if(Gate::denies('otherbranch_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherbranch->load('restaurants');

        return view('admin.otherbranches.show', compact('otherbranch'));
    }

    public function destroy(Otherbranch $otherbranch)
    {
        abort_if(Gate::denies('otherbranch_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otherbranch->delete();

        return back();
    }

    public function massDestroy(MassDestroyOtherbranchRequest $request)
    {
        Otherbranch::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
