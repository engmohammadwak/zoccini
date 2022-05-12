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
                <label class="required" for="name_en">{{ trans('cruds.subscriptionPackage.fields.name_en') }}</label>
                <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text" name="name_en" id="name_en" value="{{ old('name_en', $subscriptionPackage->name_en) }}" required>
                @if($errors->has('name_en'))
                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.name_en_helper') }}</span>
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
                <label class="required" for="description_en">{{ trans('cruds.subscriptionPackage.fields.description_en') }}</label>
                <textarea class="form-control {{ $errors->has('description_en') ? 'is-invalid' : '' }}" name="description_en" id="description_en" required>{{ old('description_en', $subscriptionPackage->description_en) }}</textarea>
                @if($errors->has('description_en'))
                    <span class="text-danger">{{ $errors->first('description_en') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.description_en_helper') }}</span>
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
                <label  for="number_branches">{{ trans('cruds.subscriptionPackage.fields.number_branches') }}</label>
                <input class="form-control {{ $errors->has('number_branches') ? 'is-invalid' : '' }}" type="text" name="number_branches" id="number_branches" value="{{ old('number_branches', $subscriptionPackage->number_branches) }}" required>
                @if($errors->has('number_branches'))
                    <span class="text-danger">{{ $errors->first('number_branches') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.number_branches_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="offer">{{ trans('cruds.subscriptionPackage.fields.offer') }}</label>
                <input class="form-control {{ $errors->has('offer') ? 'is-invalid' : '' }}" type="text" name="offer" id="offer" value="{{ old('offer', $subscriptionPackage->offer) }}">
                @if($errors->has('offer'))
                    <span class="text-danger">{{ $errors->first('offer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.offer_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('have_map') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="have_map" value="0">
                    <input class="form-check-input" type="checkbox" name="have_map" id="have_map" value="1" {{ $subscriptionPackage->have_map || old('have_map', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="have_map">{{ trans('cruds.subscriptionPackage.fields.have_map') }}</label>
                </div>
                @if($errors->has('have_map'))
                    <span class="text-danger">{{ $errors->first('have_map') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.have_map_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="currency_id">{{ trans('cruds.subscriptionPackage.fields.currency') }}</label>
                <select class="form-control select2 {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency_id" id="currency_id">
                    @foreach($currencies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('currency_id') ? old('currency_id') : $subscriptionPackage->currency->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('currency'))
                    <span class="text-danger">{{ $errors->first('currency') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.currency_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="referral_price">{{ trans('cruds.subscriptionPackage.fields.referral_price') }}</label>
                <input class="form-control {{ $errors->has('referral_price') ? 'is-invalid' : '' }}" type="text" name="referral_price" id="referral_price" value="{{ old('referral_price', $subscriptionPackage->referral_price) }}">
                @if($errors->has('referral_price'))
                    <span class="text-danger">{{ $errors->first('referral_price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.subscriptionPackage.fields.referral_price_helper') }}</span>
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
