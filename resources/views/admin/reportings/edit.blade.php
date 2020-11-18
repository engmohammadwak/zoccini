@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.reporting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.reportings.update", [$reporting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="restaurant_id">{{ trans('cruds.reporting.fields.restaurant') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id">
                    @foreach($restaurants as $id => $restaurant)
                        <option value="{{ $id }}" {{ (old('restaurant_id') ? old('restaurant_id') : $reporting->restaurant->id ?? '') == $id ? 'selected' : '' }}>{{ $restaurant }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurant'))
                    <span class="text-danger">{{ $errors->first('restaurant') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.reporting.fields.restaurant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="message">{{ trans('cruds.reporting.fields.message') }}</label>
                <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message">{{ old('message', $reporting->message) }}</textarea>
                @if($errors->has('message'))
                    <span class="text-danger">{{ $errors->first('message') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.reporting.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.reporting.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $reporting->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.reporting.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.reporting.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Reporting::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $reporting->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.reporting.fields.type_helper') }}</span>
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