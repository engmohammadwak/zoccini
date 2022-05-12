@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.referralSubscription.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.referral-subscriptions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.referralSubscription.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.referralSubscription.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_loop_id">{{ trans('cruds.referralSubscription.fields.user_loop') }}</label>
                <select class="form-control select2 {{ $errors->has('user_loop') ? 'is-invalid' : '' }}" name="user_loop_id" id="user_loop_id">
                    @foreach($user_loops as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_loop_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_loop'))
                    <span class="text-danger">{{ $errors->first('user_loop') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.referralSubscription.fields.user_loop_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="plan_id">{{ trans('cruds.referralSubscription.fields.plan') }}</label>
                <select class="form-control select2 {{ $errors->has('plan') ? 'is-invalid' : '' }}" name="plan_id" id="plan_id">
                    @foreach($plans as $id => $entry)
                        <option value="{{ $id }}" {{ old('plan_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('plan'))
                    <span class="text-danger">{{ $errors->first('plan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.referralSubscription.fields.plan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="price">{{ trans('cruds.referralSubscription.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text" name="price" id="price" value="{{ old('price', '') }}">
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.referralSubscription.fields.price_helper') }}</span>
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