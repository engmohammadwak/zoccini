@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.otherbranch.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.otherbranches.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="restaurants_id">{{ trans('cruds.otherbranch.fields.restaurants') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurants') ? 'is-invalid' : '' }}" name="restaurants_id" id="restaurants_id" required>
                    @foreach($restaurants as $id => $restaurants)
                        <option value="{{ $id }}" {{ old('restaurants_id') == $id ? 'selected' : '' }}>{{ $restaurants }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurants'))
                    <span class="text-danger">{{ $errors->first('restaurants') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.restaurants_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_name_ar">{{ trans('cruds.otherbranch.fields.branch_name_ar') }}</label>
                <input class="form-control {{ $errors->has('branch_name_ar') ? 'is-invalid' : '' }}" type="text" name="branch_name_ar" id="branch_name_ar" value="{{ old('branch_name_ar', '') }}">
                @if($errors->has('branch_name_ar'))
                    <span class="text-danger">{{ $errors->first('branch_name_ar') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.branch_name_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_name_en">{{ trans('cruds.otherbranch.fields.branch_name_en') }}</label>
                <input class="form-control {{ $errors->has('branch_name_en') ? 'is-invalid' : '' }}" type="text" name="branch_name_en" id="branch_name_en" value="{{ old('branch_name_en', '') }}">
                @if($errors->has('branch_name_en'))
                    <span class="text-danger">{{ $errors->first('branch_name_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.branch_name_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_address_ar">{{ trans('cruds.otherbranch.fields.branch_address_ar') }}</label>
                <input class="form-control {{ $errors->has('branch_address_ar') ? 'is-invalid' : '' }}" type="text" name="branch_address_ar" id="branch_address_ar" value="{{ old('branch_address_ar', '') }}">
                @if($errors->has('branch_address_ar'))
                    <span class="text-danger">{{ $errors->first('branch_address_ar') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.branch_address_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_address_en">{{ trans('cruds.otherbranch.fields.branch_address_en') }}</label>
                <input class="form-control {{ $errors->has('branch_address_en') ? 'is-invalid' : '' }}" type="text" name="branch_address_en" id="branch_address_en" value="{{ old('branch_address_en', '') }}">
                @if($errors->has('branch_address_en'))
                    <span class="text-danger">{{ $errors->first('branch_address_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.branch_address_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.otherbranch.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.otherbranch.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.email_helper') }}</span>
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