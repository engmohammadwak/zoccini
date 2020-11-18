@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.notification.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.notifications.update", [$notification->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.notification.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $notification->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title">{{ trans('cruds.notification.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $notification->title) }}">
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="body">{{ trans('cruds.notification.fields.body') }}</label>
                <input class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" type="text" name="body" id="body" value="{{ old('body', $notification->body) }}">
                @if($errors->has('body'))
                    <span class="text-danger">{{ $errors->first('body') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.body_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="type">{{ trans('cruds.notification.fields.type') }}</label>
                <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type" id="type" value="{{ old('type', $notification->type) }}">
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="seen">{{ trans('cruds.notification.fields.seen') }}</label>
                <input class="form-control {{ $errors->has('seen') ? 'is-invalid' : '' }}" type="text" name="seen" id="seen" value="{{ old('seen', $notification->seen) }}">
                @if($errors->has('seen'))
                    <span class="text-danger">{{ $errors->first('seen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.seen_helper') }}</span>
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