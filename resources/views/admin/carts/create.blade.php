@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.cart.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.carts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="restaurant_id">{{ trans('cruds.cart.fields.restaurant') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id">
                    @foreach($restaurants as $id => $restaurant)
                        <option value="{{ $id }}" {{ old('restaurant_id') == $id ? 'selected' : '' }}>{{ $restaurant }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurant'))
                    <span class="text-danger">{{ $errors->first('restaurant') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cart.fields.restaurant_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.cart.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cart.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="item_id">{{ trans('cruds.cart.fields.item') }}</label>
                <select class="form-control select2 {{ $errors->has('item') ? 'is-invalid' : '' }}" name="item_id" id="item_id">
                    @foreach($items as $id => $item)
                        <option value="{{ $id }}" {{ old('item_id') == $id ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
                @if($errors->has('item'))
                    <span class="text-danger">{{ $errors->first('item') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cart.fields.item_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="quantity">{{ trans('cruds.cart.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="text" name="quantity" id="quantity" value="{{ old('quantity', '') }}">
                @if($errors->has('quantity'))
                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.cart.fields.quantity_helper') }}</span>
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