@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.otherbranch.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.otherbranches.update", [$otherbranch->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="branch_name_en">{{ trans('cruds.otherbranch.fields.branch_name_en') }}</label>
                <input class="form-control {{ $errors->has('branch_name_en') ? 'is-invalid' : '' }}" type="text" name="branch_name_en" id="branch_name_en" value="{{ old('branch_name_en', $otherbranch->branch_name_en) }}">
                @if($errors->has('branch_name_en'))
                    <span class="text-danger">{{ $errors->first('branch_name_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.branch_name_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_address_ar">{{ trans('cruds.otherbranch.fields.branch_address_ar') }}</label>
                <input class="form-control {{ $errors->has('branch_address_ar') ? 'is-invalid' : '' }}" type="text" name="branch_address_ar" id="branch_address_ar" value="{{ old('branch_address_ar', $otherbranch->branch_address_ar) }}">
                @if($errors->has('branch_address_ar'))
                    <span class="text-danger">{{ $errors->first('branch_address_ar') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.branch_address_ar_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_address_en">{{ trans('cruds.otherbranch.fields.branch_address_en') }}</label>
                <input class="form-control {{ $errors->has('branch_address_en') ? 'is-invalid' : '' }}" type="text" name="branch_address_en" id="branch_address_en" value="{{ old('branch_address_en', $otherbranch->branch_address_en) }}">
                @if($errors->has('branch_address_en'))
                    <span class="text-danger">{{ $errors->first('branch_address_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.branch_address_en_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.otherbranch.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $otherbranch->phone) }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.otherbranch.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $otherbranch->email) }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otherbranch.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                @if($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
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