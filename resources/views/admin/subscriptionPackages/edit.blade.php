@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.subscriptionPackage.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.subscription-packages.update", [$subscriptionPackage->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.subscriptionPackage.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $subscriptionPackage->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.subscriptionPackage.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description', $subscriptionPackage->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.subscriptionPackage.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', $subscriptionPackage->price) }}" required>
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.price_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="duration">{{ trans('cruds.subscriptionPackage.fields.duration') }}</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', $subscriptionPackage->duration) }}" required>
                @if($errors->has('duration'))
                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.duration_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="number_branches">{{ trans('cruds.subscriptionPackage.fields.number_branches') }}</label>
                <input class="form-control {{ $errors->has('number_branches') ? 'is-invalid' : '' }}" type="text" name="number_branches" id="number_branches" value="{{ old('number_branches', $subscriptionPackage->number_branches) }}" required>
                @if($errors->has('number_branches'))
                    <span class="text-danger">{{ $errors->first('number_branches') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.number_branches_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="file_size">{{ trans('cruds.subscriptionPackage.fields.file_size') }}</label>
                <input class="form-control {{ $errors->has('file_size') ? 'is-invalid' : '' }}" type="text" name="file_size" id="file_size" value="{{ old('file_size', $subscriptionPackage->file_size) }}" required>
                @if($errors->has('file_size'))
                    <span class="text-danger">{{ $errors->first('file_size') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.file_size_helper') }}</span>
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