@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="restaurants_id">{{ trans('cruds.order.fields.restaurants') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurants') ? 'is-invalid' : '' }}" name="restaurants_id" id="restaurants_id" required>
                    @foreach($restaurants as $id => $restaurants)
                        <option value="{{ $id }}" {{ old('restaurants_id') == $id ? 'selected' : '' }}>{{ $restaurants }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurants'))
                    <span class="text-danger">{{ $errors->first('restaurants') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.restaurants_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.order.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="type_id">{{ trans('cruds.order.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    @foreach($types as $id => $type)
                        <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sitting_area_id">{{ trans('cruds.order.fields.sitting_area') }}</label>
                <select class="form-control select2 {{ $errors->has('sitting_area') ? 'is-invalid' : '' }}" name="sitting_area_id" id="sitting_area_id">
                    @foreach($sitting_areas as $id => $sitting_area)
                        <option value="{{ $id }}" {{ old('sitting_area_id') == $id ? 'selected' : '' }}>{{ $sitting_area }}</option>
                    @endforeach
                </select>
                @if($errors->has('sitting_area'))
                    <span class="text-danger">{{ $errors->first('sitting_area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.sitting_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="number_people">{{ trans('cruds.order.fields.number_people') }}</label>
                <input class="form-control {{ $errors->has('number_people') ? 'is-invalid' : '' }}" type="text" name="number_people" id="number_people" value="{{ old('number_people', '') }}">
                @if($errors->has('number_people'))
                    <span class="text-danger">{{ $errors->first('number_people') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.number_people_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.order.fields.schedule_request') }}</label>
                <select class="form-control {{ $errors->has('schedule_request') ? 'is-invalid' : '' }}" name="schedule_request" id="schedule_request">
                    <option value disabled {{ old('schedule_request', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::SCHEDULE_REQUEST_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('schedule_request', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('schedule_request'))
                    <span class="text-danger">{{ $errors->first('schedule_request') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.schedule_request_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="schedule_date">{{ trans('cruds.order.fields.schedule_date') }}</label>
                <input class="form-control datetime {{ $errors->has('schedule_date') ? 'is-invalid' : '' }}" type="text" name="schedule_date" id="schedule_date" value="{{ old('schedule_date') }}">
                @if($errors->has('schedule_date'))
                    <span class="text-danger">{{ $errors->first('schedule_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.schedule_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.order.fields.car_number_yes') }}</label>
                <select class="form-control {{ $errors->has('car_number_yes') ? 'is-invalid' : '' }}" name="car_number_yes" id="car_number_yes">
                    <option value disabled {{ old('car_number_yes', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::CAR_NUMBER_YES_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('car_number_yes', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('car_number_yes'))
                    <span class="text-danger">{{ $errors->first('car_number_yes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.car_number_yes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="car_number">{{ trans('cruds.order.fields.car_number') }}</label>
                <input class="form-control {{ $errors->has('car_number') ? 'is-invalid' : '' }}" type="text" name="car_number" id="car_number" value="{{ old('car_number', '') }}">
                @if($errors->has('car_number'))
                    <span class="text-danger">{{ $errors->first('car_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.car_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.order.fields.delivery') }}</label>
                <select class="form-control {{ $errors->has('delivery') ? 'is-invalid' : '' }}" name="delivery" id="delivery">
                    <option value disabled {{ old('delivery', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::DELIVERY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('delivery', '0') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('delivery'))
                    <span class="text-danger">{{ $errors->first('delivery') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.delivery_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="delivery_company_id">{{ trans('cruds.order.fields.delivery_company') }}</label>
                <select class="form-control select2 {{ $errors->has('delivery_company') ? 'is-invalid' : '' }}" name="delivery_company_id" id="delivery_company_id">
                    @foreach($delivery_companies as $id => $delivery_company)
                        <option value="{{ $id }}" {{ old('delivery_company_id') == $id ? 'selected' : '' }}>{{ $delivery_company }}</option>
                    @endforeach
                </select>
                @if($errors->has('delivery_company'))
                    <span class="text-danger">{{ $errors->first('delivery_company') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.delivery_company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status_id">{{ trans('cruds.order.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id">
                    @foreach($statuses as $id => $status)
                        <option value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="items">{{ trans('cruds.order.fields.item') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('items') ? 'is-invalid' : '' }}" name="items[]" id="items" multiple>
                    @foreach($items as $id => $item)
                        <option value="{{ $id }}" {{ in_array($id, old('items', [])) ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
                @if($errors->has('items'))
                    <span class="text-danger">{{ $errors->first('items') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.item_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cansel_reason_id">{{ trans('cruds.order.fields.cansel_reason') }}</label>
                <select class="form-control select2 {{ $errors->has('cansel_reason') ? 'is-invalid' : '' }}" name="cansel_reason_id" id="cansel_reason_id">
                    @foreach($cansel_reasons as $id => $cansel_reason)
                        <option value="{{ $id }}" {{ old('cansel_reason_id') == $id ? 'selected' : '' }}>{{ $cansel_reason }}</option>
                    @endforeach
                </select>
                @if($errors->has('cansel_reason'))
                    <span class="text-danger">{{ $errors->first('cansel_reason') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.cansel_reason_helper') }}</span>
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