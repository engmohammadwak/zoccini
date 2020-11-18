@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.subscriptionVip.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.subscription-vips.update", [$subscriptionVip->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.subscriptionVip.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $subscriptionVip->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionVip.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_day">{{ trans('cruds.subscriptionVip.fields.start_day') }}</label>
                <input class="form-control date {{ $errors->has('start_day') ? 'is-invalid' : '' }}" type="text" name="start_day" id="start_day" value="{{ old('start_day', $subscriptionVip->start_day) }}">
                @if($errors->has('start_day'))
                    <span class="text-danger">{{ $errors->first('start_day') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionVip.fields.start_day_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_day">{{ trans('cruds.subscriptionVip.fields.end_day') }}</label>
                <input class="form-control date {{ $errors->has('end_day') ? 'is-invalid' : '' }}" type="text" name="end_day" id="end_day" value="{{ old('end_day', $subscriptionVip->end_day) }}">
                @if($errors->has('end_day'))
                    <span class="text-danger">{{ $errors->first('end_day') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionVip.fields.end_day_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.subscriptionVip.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SubscriptionVip::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $subscriptionVip->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionVip.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.subscriptionVip.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', $subscriptionVip->price) }}">
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionVip.fields.price_helper') }}</span>
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