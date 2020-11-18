@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.saveCreditCard.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.save-credit-cards.update", [$saveCreditCard->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.saveCreditCard.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $saveCreditCard->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saveCreditCard.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.saveCreditCard.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $saveCreditCard->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saveCreditCard.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="card_number">{{ trans('cruds.saveCreditCard.fields.card_number') }}</label>
                <input class="form-control {{ $errors->has('card_number') ? 'is-invalid' : '' }}" type="text" name="card_number" id="card_number" value="{{ old('card_number', $saveCreditCard->card_number) }}">
                @if($errors->has('card_number'))
                    <span class="text-danger">{{ $errors->first('card_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saveCreditCard.fields.card_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="month">{{ trans('cruds.saveCreditCard.fields.month') }}</label>
                <input class="form-control {{ $errors->has('month') ? 'is-invalid' : '' }}" type="text" name="month" id="month" value="{{ old('month', $saveCreditCard->month) }}">
                @if($errors->has('month'))
                    <span class="text-danger">{{ $errors->first('month') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saveCreditCard.fields.month_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="year">{{ trans('cruds.saveCreditCard.fields.year') }}</label>
                <input class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" type="text" name="year" id="year" value="{{ old('year', $saveCreditCard->year) }}">
                @if($errors->has('year'))
                    <span class="text-danger">{{ $errors->first('year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saveCreditCard.fields.year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cvc">{{ trans('cruds.saveCreditCard.fields.cvc') }}</label>
                <input class="form-control {{ $errors->has('cvc') ? 'is-invalid' : '' }}" type="text" name="cvc" id="cvc" value="{{ old('cvc', $saveCreditCard->cvc) }}">
                @if($errors->has('cvc'))
                    <span class="text-danger">{{ $errors->first('cvc') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.saveCreditCard.fields.cvc_helper') }}</span>
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