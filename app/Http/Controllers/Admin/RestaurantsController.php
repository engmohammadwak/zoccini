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
use App\Models\PaymentMethod;
use App\Models\Restaurant;
use App\Models\SittingArea;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RestaurantsController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('restaurant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurants = Restaurant::all();

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

        return view('admin.restaurants.create', compact('restaurants', 'deliveries', 'payment_methods', 'sitting_areas', 'countries', 'cities'));
    }

    public function store(StoreRestaurantRequest $request)
    {
        $restaurant = Restaurant::create($request->all());
        $restaurant->payment_methods()->sync($request->input('payment_methods', []));
        $restaurant->sitting_areas()->sync($request->input('sitting_areas', []));

        if ($request->input('image', false)) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($request->input('commercial_registration_image', false)) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . $request->input('commercial_registration_image')))->toMediaCollection('commercial_registration_image');
        }

        if ($request->input('identity_card_image', false)) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . $request->input('identity_card_image')))->toMediaCollection('identity_card_image');
        }

        if ($request->input('company_seal', false)) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . $request->input('company_seal')))->toMediaCollection('company_seal');
        }

        foreach ($request->input('other_image', []) as $file) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('other_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $restaurant->id]);
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

        return view('admin.restaurants.edit', compact('restaurants', 'deliveries', 'payment_methods', 'sitting_areas', 'countries', 'cities', 'restaurant'));
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $restaurant->update($request->all());
        $restaurant->payment_methods()->sync($request->input('payment_methods', []));
        $restaurant->sitting_areas()->sync($request->input('sitting_areas', []));

//        if ($request->input('image', false)) {
//            if (!$restaurant->image || $request->input('image') !== $restaurant->image->file_name) {
//                if ($restaurant->image) {
//                    $restaurant->image->delete();
//                }
//
//                $restaurant->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
//            }
//        } elseif ($restaurant->image) {
//            $restaurant->image->delete();
//        }
//
//        if ($request->input('commercial_registration_image', false)) {
//            if (!$restaurant->commercial_registration_image || $request->input('commercial_registration_image') !== $restaurant->commercial_registration_image->file_name) {
//                if ($restaurant->commercial_registration_image) {
//                    $restaurant->commercial_registration_image->delete();
//                }
//
//                $restaurant->addMedia(storage_path('tmp/uploads/' . $request->input('commercial_registration_image')))->toMediaCollection('commercial_registration_image');
//            }
//        } elseif ($restaurant->commercial_registration_image) {
//            $restaurant->commercial_registration_image->delete();
//        }
//
//        if ($request->input('identity_card_image', false)) {
//            if (!$restaurant->identity_card_image || $request->input('identity_card_image') !== $restaurant->identity_card_image->file_name) {
//                if ($restaurant->identity_card_image) {
//                    $restaurant->identity_card_image->delete();
//                }
//
//                $restaurant->addMedia(storage_path('tmp/uploads/' . $request->input('identity_card_image')))->toMediaCollection('identity_card_image');
//            }
//        } elseif ($restaurant->identity_card_image) {
//            $restaurant->identity_card_image->delete();
//        }
//
//        if ($request->input('company_seal', false)) {
//            if (!$restaurant->company_seal || $request->input('company_seal') !== $restaurant->company_seal->file_name) {
//                if ($restaurant->company_seal) {
//                    $restaurant->company_seal->delete();
//                }
//
//                $restaurant->addMedia(storage_path('tmp/uploads/' . $request->input('company_seal')))->toMediaCollection('company_seal');
//            }
//        } elseif ($restaurant->company_seal) {
//            $restaurant->company_seal->delete();
//        }
//
//        if (count($restaurant->other_image) > 0) {
//            foreach ($restaurant->other_image as $media) {
//                if (!in_array($media->file_name, $request->input('other_image', []))) {
//                    $media->delete();
//                }
//            }
//        }
//
//        $media = $restaurant->other_image->pluck('file_name')->toArray();
//
//        foreach ($request->input('other_image', []) as $file) {
//            if (count($media) === 0 || !in_array($file, $media)) {
//                $restaurant->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('other_image');
//            }
//        }

        return redirect()->route('admin.restaurants.index');
    }

    public function show(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $restaurant->load('restaurant', 'delivery', 'payment_methods', 'sitting_areas', 'country', 'city');

        return view('admin.restaurants.show', compact('restaurant'));
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

        $model         = new Restaurant();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
