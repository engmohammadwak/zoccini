<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRestaurantRequest;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Delivery;
use App\Models\Image;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Restaurant;
use App\Models\SittingArea;
use App\Models\User;
use App\Models\UserStatus;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RestaurantsController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('restaurant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->type) {
            $restaurants = Restaurant::whereHas('restaurant', function ($query) {
                return $query->where('status_id', 4);
            })->get();
        } else {
            $restaurants = Restaurant::whereHas('restaurant', function ($query) {
                return $query->where('status_id', '!=', 4);
            })->get();
        }


        $users = User::get();

        $deliveries = Delivery::get();

        $payment_methods = PaymentMethod::get();

        $sitting_areas = SittingArea::get();

        $countries = Country::get();

        $cities = City::get();

        return view('admin.restaurants.index', compact('restaurants', 'users', 'deliveries', 'payment_methods', 'sitting_areas', 'countries', 'cities'));
    }

    public function create()
    {
        abort_if(Gate::denies('restaurant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deliveries = Delivery::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payment_methods = PaymentMethod::all()->pluck('name_ar', 'id');

        $sitting_areas = SittingArea::all()->pluck('name_ar', 'id');

        $countries = Country::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = UserStatus::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.restaurants.create', compact('restaurants', 'statuses', 'deliveries', 'payment_methods', 'sitting_areas', 'countries', 'cities'));
    }

    public function store(StoreRestaurantRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 3;
        $user->status_id = $request->status_id;
        $user->save();
        $user->roles()->sync(3);
        if ($request->file('logo')) {
            $image = uploadImage($request->file('logo'), '/public/img/user', $user->image);
            $user->fill(['image' => $image])->save();
        }

        $request->request->add(['restaurant_id' => $user->id]);

        $restaurant = Restaurant::create($request->all());
        $restaurant->payment_methods()->sync($request->input('payment_methods', []));
        $restaurant->sitting_areas()->sync($request->input('sitting_areas', []));

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'), '/public/img/' . Restaurant::DIR_UPLOAD, $restaurant->image);
            $restaurant->fill(['image' => $image])->save();
        }
        if ($request->file('photo')) {
            foreach ($request->file('photo') as $file) {
                $photo_name = uploadImage($file, '/public/img/' . Image::DIR_UPLOAD);

                Image::create([
                    'name' => $photo_name,
                    'model' => Image::COMPANY_MODEL,
                    'item' => $restaurant->id,
                ]);
            }
        }

        return redirect()->route('admin.restaurants.index');
    }

    public function edit(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $deliveries = Delivery::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payment_methods = PaymentMethod::all()->pluck('name_ar', 'id');

        $sitting_areas = SittingArea::all()->pluck('name_ar', 'id');

        $countries = Country::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurant->load('restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city');
        $statuses = UserStatus::all()->pluck('name_ar', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.restaurants.edit', compact('restaurants', 'statuses', 'deliveries', 'payment_methods', 'sitting_areas', 'countries', 'cities', 'restaurant'));
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {

        $user = User::find($restaurant->restaurant_id);
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->status_id = $request->status_id;
        $user->save();

        if ($request->file('logo')) {
            $image = uploadImage($request->file('logo'), '/public/img/user', $user->image);
            $user->fill(['image' => $image])->save();
        }
        $restaurant->update($request->all());
        $restaurant->payment_methods()->sync($request->input('payment_methods', []));
        $restaurant->sitting_areas()->sync($request->input('sitting_areas', []));

        if ($request->file('image')) {
            $image = uploadImage($request->file('image'), '/public/img/' . Restaurant::DIR_UPLOAD, $restaurant->image);
            $restaurant->fill(['image' => $image])->save();
        }
        if ($request->file('photo')) {
            foreach ($request->file('photo') as $file) {
                $photo_name = uploadImage($file, '/public/img/' . Image::COMPANY_MODEL);
                Image::create([
                    'name' => $photo_name,
                    'model' => Image::COMPANY_MODEL,
                    'item' => $restaurant->id,
                ]);
            }
        }

        if ($request->file('commercial_registration_image')) {
            $commercial_registration_image = uploadImage($request->file('commercial_registration_image'), '/public/img/' . Restaurant::DIR_UPLOAD, $restaurant->commercial_registration_image);
            $restaurant->fill(['commercial_registration_image' => $commercial_registration_image])->save();
        }

        if ($request->file('identity_card_image')) {
            $identity_card_image = uploadImage($request->file('identity_card_image'), '/public/img/' . Restaurant::DIR_UPLOAD, $restaurant->identity_card_image);
            $restaurant->fill(['identity_card_image' => $identity_card_image])->save();
        }

        if ($request->file('company_seal')) {
            $company_seal = uploadImage($request->file('company_seal'), '/public/img/' . Restaurant::DIR_UPLOAD, $restaurant->company_seal);
            $restaurant->fill(['company_seal' => $company_seal])->save();
        }


        return redirect()->route('admin.restaurants.index');
    }

    public function show(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurant->load('restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city');
        //dd($restaurant);

        return view('admin.restaurants.show', compact('restaurant'));
    }


    public function active($id)
    {
        $res = Restaurant::find($id);
        $user = User::find($res->restaurant_id);
        $user->status_id = 1;
        $user->save();

        return Redirect::back();
    }

    public function destroy(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurant->delete();

        return back();
    }

    public function massDestroy(MassDestroyRestaurantRequest $request)
    {
        Restaurant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('restaurant_create') && Gate::denies('restaurant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Restaurant();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }


    public function restaurant_order($id)
    {
        $orders = Order::where('restaurants_id', $id)->get();

        $orders->load('restaurants', 'user', 'type', 'sitting_area', 'delivery_company', 'status', 'items', 'cansel_reason', 'winner', 'car_number');
        $order_statuses = OrderStatus::get();
        return view('admin.restaurants.restaurant_order', compact('orders', 'order_statuses'));

    }
}
