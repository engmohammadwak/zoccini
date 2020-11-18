@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.subscriptionUser.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.subscription-users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.subscriptionUser.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionUser.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="package_id">{{ trans('cruds.subscriptionUser.fields.package') }}</label>
                <select class="form-control select2 {{ $errors->has('package') ? 'is-invalid' : '' }}" name="package_id" id="package_id" required>
                    @foreach($packages as $id => $package)
                        <option value="{{ $id }}" {{ old('package_id') == $id ? 'selected' : '' }}>{{ $package }}</option>
                    @endforeach
                </select>
                @if($errors->has('package'))
                    <span class="text-danger">{{ $errors->first('package') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionUser.fields.package_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.subscriptionUser.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                @if($errors->has('start_date'))
                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionUser.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="end_day">{{ trans('cruds.subscriptionUser.fields.end_day') }}</label>
                <input class="form-control date {{ $errors->has('end_day') ? 'is-invalid' : '' }}" type="text" name="end_day" id="end_day" value="{{ old('end_day') }}" required>
                @if($errors->has('end_day'))
                    <span class="text-danger">{{ $errors->first('end_day') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionUser.fields.end_day_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.subscriptionUser.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', '') }}">
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionUser.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.subscriptionUser.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SubscriptionUser::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionUser.fields.status_helper') }}</span>
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