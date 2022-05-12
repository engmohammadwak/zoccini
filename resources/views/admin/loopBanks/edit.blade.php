@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.loopBank.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loop-banks.update", [$loopBank->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="bank_name">{{ trans('cruds.loopBank.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', $loopBank->bank_name) }}">
                @if($errors->has('bank_name'))
                    <span class="text-danger">{{ $errors->first('bank_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopBank.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="swift_code">{{ trans('cruds.loopBank.fields.swift_code') }}</label>
                <input class="form-control {{ $errors->has('swift_code') ? 'is-invalid' : '' }}" type="text" name="swift_code" id="swift_code" value="{{ old('swift_code', $loopBank->swift_code) }}">
                @if($errors->has('swift_code'))
                    <span class="text-danger">{{ $errors->first('swift_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopBank.fields.swift_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="iban">{{ trans('cruds.loopBank.fields.iban') }}</label>
                <input class="form-control {{ $errors->has('iban') ? 'is-invalid' : '' }}" type="text" name="iban" id="iban" value="{{ old('iban', $loopBank->iban) }}">
                @if($errors->has('iban'))
                    <span class="text-danger">{{ $errors->first('iban') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopBank.fields.iban_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="branch_no">{{ trans('cruds.loopBank.fields.branch_no') }}</label>
                <input class="form-control {{ $errors->has('branch_no') ? 'is-invalid' : '' }}" type="text" name="branch_no" id="branch_no" value="{{ old('branch_no', $loopBank->branch_no) }}">
                @if($errors->has('branch_no'))
                    <span class="text-danger">{{ $errors->first('branch_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.loopBank.fields.branch_no_helper') }}</span>
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