@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.topRestaurant.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.top-restaurants.update", [$topRestaurant->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.topRestaurant.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $topRestaurant->title) }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.topRestaurant.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="body">{{ trans('cruds.topRestaurant.fields.body') }}</label>
                <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" id="body" required>{{ old('body', $topRestaurant->body) }}</textarea>
                @if($errors->has('body'))
                    <span class="text-danger">{{ $errors->first('body') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.topRestaurant.fields.body_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="category_id">{{ trans('cruds.topRestaurant.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id">
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $topRestaurant->category->id ?? '') == $id ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.topRestaurant.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.topRestaurant.fields.image') }}</label>
                @if($topRestaurant->image)
                    <br>
                    <a href="{{ $topRestaurant->image_url }}" target="_blank">
                        <img src="{{ $topRestaurant->image_url }}" width="50px" height="50px">
                    </a>
                @endif

                <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">

                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.topRestaurant.fields.image_helper') }}</span>
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