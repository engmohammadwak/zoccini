@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.loopuser.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loopusers.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="country_id">{{ trans('cruds.loopuser.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                    @foreach($countries as $id => $entry)
                        <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.loopuser.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $entry)
                        <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.loopuser.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.loopuser.fields.verification_type') }}</label>
                <select class="form-control {{ $errors->has('verification_type') ? 'is-invalid' : '' }}" name="verification_type" id="verification_type">
                    <option value disabled {{ old('verification_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Loopuser::VERIFICATION_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('verification_type', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('verification_type'))
                    <span class="text-danger">{{ $errors->first('verification_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.verification_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="national">{{ trans('cruds.loopuser.fields.national') }}</label>
                <input class="form-control {{ $errors->has('national') ? 'is-invalid' : '' }}" type="text" name="national" id="national" value="{{ old('national', '') }}">
                @if($errors->has('national'))
                    <span class="text-danger">{{ $errors->first('national') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.national_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="expire_date">{{ trans('cruds.loopuser.fields.expire_date') }}</label>
                <input class="form-control {{ $errors->has('expire_date') ? 'is-invalid' : '' }}" type="text" name="expire_date" id="expire_date" value="{{ old('expire_date', '') }}">
                @if($errors->has('expire_date'))
                    <span class="text-danger">{{ $errors->first('expire_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.expire_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attach_national">{{ trans('cruds.loopuser.fields.attach_national') }}</label>
                <input class="form-control {{ $errors->has('attach_national') ? 'is-invalid' : '' }}" type="text" name="attach_national" id="attach_national" value="{{ old('attach_national', '') }}">
                @if($errors->has('attach_national'))
                    <span class="text-danger">{{ $errors->first('attach_national') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.attach_national_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="invoice_image">{{ trans('cruds.loopuser.fields.invoice_image') }}</label>
                <input class="form-control {{ $errors->has('invoice_image') ? 'is-invalid' : '' }}" type="text" name="invoice_image" id="invoice_image" value="{{ old('invoice_image', '') }}">
                @if($errors->has('invoice_image'))
                    <span class="text-danger">{{ $errors->first('invoice_image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.invoice_image_helper') }}</span>
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