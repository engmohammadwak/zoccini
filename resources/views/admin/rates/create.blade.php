@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.rate.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.rates.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.rate.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rate.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="restaurant_id">{{ trans('cruds.rate.fields.restaurant') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id">
                    @foreach($restaurants as $id => $restaurant)
                        <option value="{{ $id }}" {{ old('restaurant_id') == $id ? 'selected' : '' }}>{{ $restaurant }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurant'))
                    <span class="text-danger">{{ $errors->first('restaurant') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rate.fields.restaurant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rating">{{ trans('cruds.rate.fields.rating') }}</label>
                <input class="form-control {{ $errors->has('rating') ? 'is-invalid' : '' }}" type="text" name="rating" id="rating" value="{{ old('rating', '') }}">
                @if($errors->has('rating'))
                    <span class="text-danger">{{ $errors->first('rating') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rate.fields.rating_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rate_1">{{ trans('cruds.rate.fields.rate_1') }}</label>
                <input class="form-control {{ $errors->has('rate_1') ? 'is-invalid' : '' }}" type="text" name="rate_1" id="rate_1" value="{{ old('rate_1', '') }}">
                @if($errors->has('rate_1'))
                    <span class="text-danger">{{ $errors->first('rate_1') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rate.fields.rate_1_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rate_2">{{ trans('cruds.rate.fields.rate_2') }}</label>
                <input class="form-control {{ $errors->has('rate_2') ? 'is-invalid' : '' }}" type="text" name="rate_2" id="rate_2" value="{{ old('rate_2', '') }}">
                @if($errors->has('rate_2'))
                    <span class="text-danger">{{ $errors->first('rate_2') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rate.fields.rate_2_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rate_3">{{ trans('cruds.rate.fields.rate_3') }}</label>
                <input class="form-control {{ $errors->has('rate_3') ? 'is-invalid' : '' }}" type="text" name="rate_3" id="rate_3" value="{{ old('rate_3', '') }}">
                @if($errors->has('rate_3'))
                    <span class="text-danger">{{ $errors->first('rate_3') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rate.fields.rate_3_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rate_4">{{ trans('cruds.rate.fields.rate_4') }}</label>
                <input class="form-control {{ $errors->has('rate_4') ? 'is-invalid' : '' }}" type="text" name="rate_4" id="rate_4" value="{{ old('rate_4', '') }}">
                @if($errors->has('rate_4'))
                    <span class="text-danger">{{ $errors->first('rate_4') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rate.fields.rate_4_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comment">{{ trans('cruds.rate.fields.comment') }}</label>
                <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" id="comment">{{ old('comment') }}</textarea>
                @if($errors->has('comment'))
                    <span class="text-danger">{{ $errors->first('comment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.rate.fields.comment_helper') }}</span>
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