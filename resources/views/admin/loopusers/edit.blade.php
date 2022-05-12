@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.loopuser.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loopusers.update", [$loopuser->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6"><div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', optional($loopuser->user)->name) }}" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                    </div></div>
                <div class="col-md-6"><div class="form-group">
                        <label class="required" for="last_name">{{ trans('cruds.user.fields.last_name') }}</label>
                        <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" id="last_name" value="{{ old('last_name', optional($loopuser->user)->last_name) }}" required>
                        @if($errors->has('last_name'))
                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.last_name_helper') }}</span>
                    </div></div>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', optional($loopuser->user)->phone) }}" required>
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', optional($loopuser->user)->email) }}" required>
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
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : optional($loopuser->user)->status->id ?? '') == $id ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country_id">{{ trans('cruds.loopuser.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                    @foreach($countries as $id => $entry)
                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $loopuser->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $loopuser->city->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <span class="text-danger">{{ $errors->first('city') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.city_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="national">{{ trans('cruds.loopuser.fields.national') }}</label>
                <input class="form-control {{ $errors->has('national') ? 'is-invalid' : '' }}" type="text" name="national" id="national" value="{{ old('national', $loopuser->national) }}">
                @if($errors->has('national'))
                    <span class="text-danger">{{ $errors->first('national') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.national_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="expire_date">{{ trans('cruds.loopuser.fields.expire_date') }}</label>
                <input class="form-control {{ $errors->has('expire_date') ? 'is-invalid' : '' }}" type="text" name="expire_date" id="expire_date" value="{{ old('expire_date', $loopuser->expire_date) }}">
                @if($errors->has('expire_date'))
                    <span class="text-danger">{{ $errors->first('expire_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopuser.fields.expire_date_helper') }}</span>
            </div>
{{--            <div class="form-group">--}}
{{--                <label for="attach_national">{{ trans('cruds.loopuser.fields.attach_national') }}</label>--}}
{{--                <input class="form-control {{ $errors->has('attach_national') ? 'is-invalid' : '' }}" type="text" name="attach_national" id="attach_national" value="{{ old('attach_national', $loopuser->attach_national) }}">--}}
{{--                @if($errors->has('attach_national'))--}}
{{--                    <span class="text-danger">{{ $errors->first('attach_national') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.loopuser.fields.attach_national_helper') }}</span>--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label for="invoice_image">{{ trans('cruds.loopuser.fields.invoice_image') }}</label>--}}
{{--                <input class="form-control {{ $errors->has('invoice_image') ? 'is-invalid' : '' }}" type="text" name="invoice_image" id="invoice_image" value="{{ old('invoice_image', $loopuser->invoice_image) }}">--}}
{{--                @if($errors->has('invoice_image'))--}}
{{--                    <span class="text-danger">{{ $errors->first('invoice_image') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.loopuser.fields.invoice_image_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
