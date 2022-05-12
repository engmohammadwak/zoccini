@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.carList.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.car-lists.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="car_brand_id">{{ trans('cruds.carList.fields.car_brand') }}</label>
                <select class="form-control select2 {{ $errors->has('car_brand') ? 'is-invalid' : '' }}" name="car_brand_id" id="car_brand_id">
                    @foreach($car_brands as $id => $car_brand)
                        <option value="{{ $id }}" {{ old('car_brand_id') == $id ? 'selected' : '' }}>{{ $car_brand }}</option>
                    @endforeach
                </select>
                @if($errors->has('car_brand'))
                    <span class="text-danger">{{ $errors->first('car_brand') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.carList.fields.car_brand_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="car_type_id">{{ trans('cruds.carList.fields.car_type') }}</label>
                <select class="form-control select2 {{ $errors->has('car_type') ? 'is-invalid' : '' }}" name="car_type_id" id="car_type_id">
                    @foreach($car_types as $id => $car_type)
                        <option value="{{ $id }}" {{ old('car_type_id') == $id ? 'selected' : '' }}>{{ $car_type }}</option>
                    @endforeach
                </select>
                @if($errors->has('car_type'))
                    <span class="text-danger">{{ $errors->first('car_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.carList.fields.car_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="car_color_id">{{ trans('cruds.carList.fields.car_color') }}</label>
                <select class="form-control select2 {{ $errors->has('car_color') ? 'is-invalid' : '' }}" name="car_color_id" id="car_color_id">
                    @foreach($car_colors as $id => $car_color)
                        <option value="{{ $id }}" {{ old('car_color_id') == $id ? 'selected' : '' }}>{{ $car_color }}</option>
                    @endforeach
                </select>
                @if($errors->has('car_color'))
                    <span class="text-danger">{{ $errors->first('car_color') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.carList.fields.car_color_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pate_number">{{ trans('cruds.carList.fields.pate_number') }}</label>
                <input class="form-control {{ $errors->has('pate_number') ? 'is-invalid' : '' }}" type="text" name="pate_number" id="pate_number" value="{{ old('pate_number', '') }}">
                @if($errors->has('pate_number'))
                    <span class="text-danger">{{ $errors->first('pate_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.carList.fields.pate_number_helper') }}</span>
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