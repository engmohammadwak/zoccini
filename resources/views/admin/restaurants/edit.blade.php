@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.restaurant.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.restaurants.update", [$restaurant->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6"><div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', optional($restaurant->restaurant)->name) }}" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                    </div></div>
                <div class="col-md-6"><div class="form-group">
                        <label class="required" for="last_name">{{ trans('cruds.user.fields.last_name') }}</label>
                        <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" id="last_name" value="{{ old('last_name', optional($restaurant->restaurant)->last_name) }}" required>
                        @if($errors->has('last_name'))
                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.last_name_helper') }}</span>
                    </div></div>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', optional($restaurant->restaurant)->phone) }}" required>
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', optional($restaurant->restaurant)->email) }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.user.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id">
                    @foreach($statuses as $id => $status)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : optional($restaurant->restaurant)->status->id ?? '') == $id ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.user.fields.image') }}</label>
                <br>
                @if(optional($restaurant->restaurant)->image)
                    <a href="{{ url('local/public/img/user/' . optional($restaurant->restaurant)->image) }}" target="_blank">
                        <img src="{{ url('local/public/img/user/' . optional($restaurant->restaurant)->image) }}" width="50px" height="50px">
                    </a>
                @else
                    <a href="{{ url('local/public/img/setting/' . getSetting('user_image')) }}" target="_blank">
                        <img src="{{ url('local/public/img/setting/' . getSetting('user_image')) }}" width="50px" height="50px">
                    </a>
                @endif

                <input type="file" name="logo" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">

                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.image_helper') }}</span>
            </div>
            <div class="row">
                <div class="col-md-6"><div class="form-group">
                        <label class="required" for="name_ar">{{ trans('cruds.restaurant.fields.name_ar') }}</label>
                        <input class="form-control {{ $errors->has('name_ar') ? 'is-invalid' : '' }}" type="text" name="name_ar" id="name_ar" value="{{ old('name_ar', $restaurant->name_ar) }}" required>
                        @if($errors->has('name_ar'))
                            <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.restaurant.fields.name_ar_helper') }}</span>
                    </div></div>
                <div class="col-md-6"><div class="form-group">
                        <label class="required" for="name_en">{{ trans('cruds.restaurant.fields.name_en') }}</label>
                        <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text" name="name_en" id="name_en" value="{{ old('name_en', $restaurant->name_en) }}" required>
                        @if($errors->has('name_en'))
                            <span class="text-danger">{{ $errors->first('name_en') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.restaurant.fields.name_en_helper') }}</span>
                    </div></div>
            </div>
            <div class="form-group">
                <label for="description_ar">{{ trans('cruds.restaurant.fields.description_ar') }}</label>
                <textarea class="form-control {{ $errors->has('description_ar') ? 'is-invalid' : '' }}" name="description_ar" id="description_ar">{{ old('description_ar', $restaurant->description_ar) }}</textarea>
                @if($errors->has('description_ar'))
                    <span class="text-danger">{{ $errors->first('description_ar') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.description_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description_en">{{ trans('cruds.restaurant.fields.description_en') }}</label>
                <textarea class="form-control {{ $errors->has('description_en') ? 'is-invalid' : '' }}" name="description_en" id="description_en">{{ old('description_en', $restaurant->description_en) }}</textarea>
                @if($errors->has('description_en'))
                    <span class="text-danger">{{ $errors->first('description_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.description_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.restaurant.fields.image') }}</label>
                @if($restaurant->image)
                    <a href="{{ $restaurant->image_url }}" target="_blank">
                        <img src="{{ $restaurant->image_url }}" width="50px" height="50px">
                    </a>
                @endif

                <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">

                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.restaurant.fields.photo') }}</label>
                @if(isset($restaurant->media))
                    <div class="container">
                        <div class="row">
                        @foreach($restaurant->media as $value)
                            <!-- TH1 -->
                                <div class="col-sm-1" style="float: right ; width: 140px;margin-top: 3%;">
                                    <div class="thumbnail">
                                        <a href="{{ route('admin.deleteImage', $value->id) }}" style="margin-top: -18%;margin-right: 34px;">&#10006;</a>
                                        <img class="img-fluid" src="{{$value->image_url}}" height="100" width="100">

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif
                <input type="file" name="photo[]" multiple>

                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="delivery_id">{{ trans('cruds.restaurant.fields.delivery') }}</label>
                <select class="form-control select2 {{ $errors->has('delivery') ? 'is-invalid' : '' }}" name="delivery_id" id="delivery_id">
                    @foreach($deliveries as $id => $delivery)
                        <option value="{{ $id }}" {{ (old('delivery_id') ? old('delivery_id') : $restaurant->delivery->id ?? '') == $id ? 'selected' : '' }}>{{ $delivery }}</option>
                    @endforeach
                </select>
                @if($errors->has('delivery'))
                    <span class="text-danger">{{ $errors->first('delivery') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.delivery_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="payment_methods">{{ trans('cruds.restaurant.fields.payment_methods') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('payment_methods') ? 'is-invalid' : '' }}" name="payment_methods[]" id="payment_methods" multiple>
                    @foreach($payment_methods as $id => $payment_methods)
                        <option value="{{ $id }}" {{ (in_array($id, old('payment_methods', [])) || $restaurant->payment_methods->contains($id)) ? 'selected' : '' }}>{{ $payment_methods }}</option>
                    @endforeach
                </select>
                @if($errors->has('payment_methods'))
                    <span class="text-danger">{{ $errors->first('payment_methods') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.payment_methods_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tag">{{ trans('cruds.restaurant.fields.tag') }}</label>
                <input class="form-control {{ $errors->has('tag') ? 'is-invalid' : '' }}" type="text" name="tag" id="tag" value="{{ old('tag', $restaurant->tag) }}">
                @if($errors->has('tag'))
                    <span class="text-danger">{{ $errors->first('tag') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.tag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sitting_areas">{{ trans('cruds.restaurant.fields.sitting_area') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('sitting_areas') ? 'is-invalid' : '' }}" name="sitting_areas[]" id="sitting_areas" multiple>
                    @foreach($sitting_areas as $id => $sitting_area)
                        <option value="{{ $id }}" {{ (in_array($id, old('sitting_areas', [])) || $restaurant->sitting_areas->contains($id)) ? 'selected' : '' }}>{{ $sitting_area }}</option>
                    @endforeach
                </select>
                @if($errors->has('sitting_areas'))
                    <span class="text-danger">{{ $errors->first('sitting_areas') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.sitting_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.restaurant.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $restaurant->address) }}">
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number_of_employees">{{ trans('cruds.restaurant.fields.number_of_employees') }}</label>
                <input class="form-control {{ $errors->has('number_of_employees') ? 'is-invalid' : '' }}" type="text" name="number_of_employees" id="number_of_employees" value="{{ old('number_of_employees', $restaurant->number_of_employees) }}">
                @if($errors->has('number_of_employees'))
                    <span class="text-danger">{{ $errors->first('number_of_employees') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.number_of_employees_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number_branches">{{ trans('cruds.restaurant.fields.number_branches') }}</label>
                <input class="form-control {{ $errors->has('number_branches') ? 'is-invalid' : '' }}" type="text" name="number_branches" id="number_branches" value="{{ old('number_branches', $restaurant->number_branches) }}">
                @if($errors->has('number_branches'))
                    <span class="text-danger">{{ $errors->first('number_branches') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.number_branches_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country_id">{{ trans('cruds.restaurant.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                    @foreach($countries as $id => $country)
                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $restaurant->country->id ?? '') == $id ? 'selected' : '' }}>{{ $country }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.restaurant.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $city)
                        <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $restaurant->city->id ?? '') == $id ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="commercial_registration_image">{{ trans('cruds.restaurant.fields.commercial_registration_image') }}</label>
                <br>
                @if($restaurant->commercial_registration_image)
                    <a href="{{ $restaurant->commercial_registration_image_url }}" target="_blank">
                        <img src="{{ $restaurant->commercial_registration_image_url }}" width="50px" height="50px">
                    </a>
                @endif

                <input type="file" name="commercial_registration_image" class="form-control {{ $errors->has('commercial_registration_image') ? 'is-invalid' : '' }}">

            @if($errors->has('commercial_registration_image'))
                    <span class="text-danger">{{ $errors->first('commercial_registration_image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.commercial_registration_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="identity_card_image">{{ trans('cruds.restaurant.fields.identity_card_image') }}</label>
                <br>
                @if($restaurant->identity_card_image)
                    <a href="{{ $restaurant->identity_card_image_url }}" target="_blank">
                        <img src="{{ $restaurant->identity_card_image_url }}" width="50px" height="50px">
                    </a>
                @endif

                <input type="file" name="identity_card_image" class="form-control {{ $errors->has('identity_card_image') ? 'is-invalid' : '' }}">

            @if($errors->has('identity_card_image'))
                    <span class="text-danger">{{ $errors->first('identity_card_image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.identity_card_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="company_seal">{{ trans('cruds.restaurant.fields.company_seal') }}</label>
               <br>
                @if($restaurant->company_seal)
                    <a href="{{ $restaurant->company_seal_url }}" target="_blank">
                        <img src="{{ $restaurant->company_seal_url }}" width="50px" height="50px">
                    </a>
                @endif

                <input type="file" name="company_seal" class="form-control {{ $errors->has('company_seal') ? 'is-invalid' : '' }}">

            @if($errors->has('company_seal'))
                    <span class="text-danger">{{ $errors->first('company_seal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.company_seal_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="open_time">{{ trans('cruds.restaurant.fields.open_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('open_time') ? 'is-invalid' : '' }}" type="text" name="open_time" id="open_time" value="{{ old('open_time', $restaurant->open_time) }}">
                @if($errors->has('open_time'))
                    <span class="text-danger">{{ $errors->first('open_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.open_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="close_time">{{ trans('cruds.restaurant.fields.close_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('close_time') ? 'is-invalid' : '' }}" type="text" name="close_time" id="close_time" value="{{ old('close_time', $restaurant->close_time) }}">
                @if($errors->has('close_time'))
                    <span class="text-danger">{{ $errors->first('close_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.close_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="min_waiting">{{ trans('cruds.restaurant.fields.min_waiting') }}</label>
                <input class="form-control {{ $errors->has('min_waiting') ? 'is-invalid' : '' }}" type="text" name="min_waiting" id="min_waiting" value="{{ old('min_waiting', $restaurant->min_waiting) }}">
                @if($errors->has('min_waiting'))
                    <span class="text-danger">{{ $errors->first('min_waiting') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.min_waiting_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="max_waiting">{{ trans('cruds.restaurant.fields.max_waiting') }}</label>
                <input class="form-control {{ $errors->has('max_waiting') ? 'is-invalid' : '' }}" type="text" name="max_waiting" id="max_waiting" value="{{ old('max_waiting', $restaurant->max_waiting) }}">
                @if($errors->has('max_waiting'))
                    <span class="text-danger">{{ $errors->first('max_waiting') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.max_waiting_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="max_waiting">{{ trans('cruds.restaurant.fields.number_order_automatically') }}</label>
                <input class="form-control {{ $errors->has('number_order_automatically') ? 'is-invalid' : '' }}" type="number" name="number_order_automatically" id="number_order_automatically" value="{{ old('number_order_automatically', $restaurant->number_order_automatically) }}">
                @if($errors->has('number_order_automatically'))
                    <span class="text-danger">{{ $errors->first('number_order_automatically') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.restaurant.fields.number_order_automatically_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')

@endsection
