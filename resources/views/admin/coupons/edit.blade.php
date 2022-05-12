@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.coupon.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.coupons.update", [$coupon->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="code">{{ trans('cruds.coupon.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" required>
                @if($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="value">{{ trans('cruds.coupon.fields.value') }}</label>
                <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="text" name="value" id="value" value="{{ old('value', $coupon->value) }}" required>
                @if($errors->has('value'))
                    <span class="text-danger">{{ $errors->first('value') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.value_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.coupon.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Coupon::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $coupon->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="maximum_usage">{{ trans('cruds.coupon.fields.maximum_usage') }}</label>
                <input class="form-control {{ $errors->has('maximum_usage') ? 'is-invalid' : '' }}" type="text" name="maximum_usage" id="maximum_usage" value="{{ old('maximum_usage', $coupon->maximum_usage) }}" required>
                @if($errors->has('maximum_usage'))
                    <span class="text-danger">{{ $errors->first('maximum_usage') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.maximum_usage_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_day">{{ trans('cruds.coupon.fields.start_day') }}</label>
                <input class="form-control date {{ $errors->has('start_day') ? 'is-invalid' : '' }}" type="text" name="start_day" id="start_day" value="{{ old('start_day', $coupon->start_day) }}" required>
                @if($errors->has('start_day'))
                    <span class="text-danger">{{ $errors->first('start_day') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.start_day_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_day">{{ trans('cruds.coupon.fields.end_day') }}</label>
                <input class="form-control date {{ $errors->has('end_day') ? 'is-invalid' : '' }}" type="text" name="end_day" id="end_day" value="{{ old('end_day', $coupon->end_day) }}" required>
                @if($errors->has('end_day'))
                    <span class="text-danger">{{ $errors->first('end_day') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.coupon.fields.end_day_helper') }}</span>
            </div>
{{--            <div class="form-group">--}}
{{--                <label class="required">{{ trans('cruds.coupon.fields.type') }}</label>--}}
{{--                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>--}}
{{--                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>--}}
{{--                    @foreach(App\Models\Coupon::TYPE_SELECT as $key => $label)--}}
{{--                        <option value="{{ $key }}" {{ old('type', $coupon->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                @if($errors->has('type'))--}}
{{--                    <span class="text-danger">{{ $errors->first('type') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.coupon.fields.type_helper') }}</span>--}}
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
