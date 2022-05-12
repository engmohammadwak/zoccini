@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.becomePartner.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.become-partners.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.becomePartner.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.becomePartner.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="body">{{ trans('cruds.becomePartner.fields.body') }}</label>
                <textarea class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" id="body" required>{{ old('body') }}</textarea>
                @if($errors->has('body'))
                    <span class="text-danger">{{ $errors->first('body') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.becomePartner.fields.body_helper') }}</span>
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