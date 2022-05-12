@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.ventureCompany.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.venture-companies.update", [$ventureCompany->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.ventureCompany.fields.image') }}</label>
                @if($ventureCompany->image)
                    <br>
                    <a href="{{ $ventureCompany->image_url }}" target="_blank">
                        <img src="{{ $ventureCompany->image_url }}" width="50px" height="50px">
                    </a>
                @endif

                <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">

                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ventureCompany.fields.image_helper') }}</span>
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