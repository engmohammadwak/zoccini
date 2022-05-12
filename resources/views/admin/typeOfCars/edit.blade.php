@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.typeOfCar.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.type-of-cars.update", [$typeOfCar->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name_ar">{{ trans('cruds.typeOfCar.fields.name_ar') }}</label>
                    <input class="form-control {{ $errors->has('name_ar') ? 'is-invalid' : '' }}" type="text" name="name_ar" id="name_ar" value="{{ old('name_ar', $typeOfCar->name_ar) }}" required>
                    @if($errors->has('name_ar'))
                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.typeOfCar.fields.name_ar_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name_en">{{ trans('cruds.typeOfCar.fields.name_en') }}</label>
                    <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text" name="name_en" id="name_en" value="{{ old('name_en', $typeOfCar->name_en) }}" required>
                    @if($errors->has('name_en'))
                        <span class="text-danger">{{ $errors->first('name_en') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.typeOfCar.fields.name_en_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="car_type_id">{{ trans('cruds.typeOfCar.fields.car_type') }}</label>
                    <select class="form-control select2 {{ $errors->has('car_type') ? 'is-invalid' : '' }}" name="car_type_id" id="car_type_id" required>
                        @foreach($car_types as $id => $car_type)
                            <option value="{{ $id }}" {{ (old('car_type_id') ? old('car_type_id') : $typeOfCar->car_type->id ?? '') == $id ? 'selected' : '' }}>{{ $car_type }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('car_type'))
                        <span class="text-danger">{{ $errors->first('car_type') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.typeOfCar.fields.car_type_helper') }}</span>
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