@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.address.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.addresses.update", [$address->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="nice_name">{{ trans('cruds.address.fields.nice_name') }}</label>
                <input class="form-control {{ $errors->has('nice_name') ? 'is-invalid' : '' }}" type="text" name="nice_name" id="nice_name" value="{{ old('nice_name', $address->nice_name) }}">
                @if($errors->has('nice_name'))
                    <span class="text-danger">{{ $errors->first('nice_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.nice_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="area">{{ trans('cruds.address.fields.area') }}</label>
                <input class="form-control {{ $errors->has('area') ? 'is-invalid' : '' }}" type="text" name="area" id="area" value="{{ old('area', $address->area) }}">
                @if($errors->has('area'))
                    <span class="text-danger">{{ $errors->first('area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="street">{{ trans('cruds.address.fields.street') }}</label>
                <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', $address->street) }}">
                @if($errors->has('street'))
                    <span class="text-danger">{{ $errors->first('street') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.street_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="building">{{ trans('cruds.address.fields.building') }}</label>
                <input class="form-control {{ $errors->has('building') ? 'is-invalid' : '' }}" type="text" name="building" id="building" value="{{ old('building', $address->building) }}">
                @if($errors->has('building'))
                    <span class="text-danger">{{ $errors->first('building') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.building_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="floor">{{ trans('cruds.address.fields.floor') }}</label>
                <input class="form-control {{ $errors->has('floor') ? 'is-invalid' : '' }}" type="text" name="floor" id="floor" value="{{ old('floor', $address->floor) }}">
                @if($errors->has('floor'))
                    <span class="text-danger">{{ $errors->first('floor') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.floor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="apartment_no">{{ trans('cruds.address.fields.apartment_no') }}</label>
                <input class="form-control {{ $errors->has('apartment_no') ? 'is-invalid' : '' }}" type="text" name="apartment_no" id="apartment_no" value="{{ old('apartment_no', $address->apartment_no) }}">
                @if($errors->has('apartment_no'))
                    <span class="text-danger">{{ $errors->first('apartment_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.apartment_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="additional_direction">{{ trans('cruds.address.fields.additional_direction') }}</label>
                <input class="form-control {{ $errors->has('additional_direction') ? 'is-invalid' : '' }}" type="text" name="additional_direction" id="additional_direction" value="{{ old('additional_direction', $address->additional_direction) }}">
                @if($errors->has('additional_direction'))
                    <span class="text-danger">{{ $errors->first('additional_direction') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.additional_direction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="landing_number">{{ trans('cruds.address.fields.landing_number') }}</label>
                <input class="form-control {{ $errors->has('landing_number') ? 'is-invalid' : '' }}" type="text" name="landing_number" id="landing_number" value="{{ old('landing_number', $address->landing_number) }}">
                @if($errors->has('landing_number'))
                    <span class="text-danger">{{ $errors->first('landing_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.landing_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.address.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $address->phone) }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.address.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $address->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lat">{{ trans('cruds.address.fields.lat') }}</label>
                <input class="form-control {{ $errors->has('lat') ? 'is-invalid' : '' }}" type="text" name="lat" id="lat" value="{{ old('lat', $address->lat) }}">
                @if($errors->has('lat'))
                    <span class="text-danger">{{ $errors->first('lat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.lat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lang">{{ trans('cruds.address.fields.lang') }}</label>
                <input class="form-control {{ $errors->has('lang') ? 'is-invalid' : '' }}" type="text" name="lang" id="lang" value="{{ old('lang', $address->lang) }}">
                @if($errors->has('lang'))
                    <span class="text-danger">{{ $errors->first('lang') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.lang_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="main_address">{{ trans('cruds.address.fields.main_address') }}</label>
                <input class="form-control {{ $errors->has('main_address') ? 'is-invalid' : '' }}" type="text" name="main_address" id="main_address" value="{{ old('main_address', $address->main_address) }}">
                @if($errors->has('main_address'))
                    <span class="text-danger">{{ $errors->first('main_address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.address.fields.main_address_helper') }}</span>
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