@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.table.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tables.update", [$table->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="number">{{ trans('cruds.table.fields.number') }}</label>
                <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="text" name="number" id="number" value="{{ old('number', $table->number) }}" required>
                @if($errors->has('number'))
                    <span class="text-danger">{{ $errors->first('number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.table.fields.number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sitting_area_id">{{ trans('cruds.table.fields.sitting_area') }}</label>
                <select class="form-control select2 {{ $errors->has('sitting_area') ? 'is-invalid' : '' }}" name="sitting_area_id" id="sitting_area_id" required>
                    @foreach($sitting_areas as $sitting_area)
                        <option value="{{$sitting_area->id }}" {{

                                                (old('sitting_area_id') ? old('sitting_area_id') : $table->sitting_area_id ?? '') == $sitting_area->id ? 'selected' : '' }}>{{ \Illuminate\Support\Facades\App::getLocale() == 'ar' ? $sitting_area->name_ar : $sitting_area->name_en}}</option>
                    @endforeach
                </select>
                @if($errors->has('sitting_area'))
                    <span class="text-danger">{{ $errors->first('sitting_area') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.table.fields.sitting_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="chares">{{ trans('cruds.table.fields.chares') }}</label>
                <input class="form-control {{ $errors->has('chares') ? 'is-invalid' : '' }}" type="text" name="chares" id="chares" value="{{ old('chares', $table->chares) }}" required>
                @if($errors->has('chares'))
                    <span class="text-danger">{{ $errors->first('chares') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.table.fields.chares_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status_id">{{ trans('cruds.table.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                    @foreach($statuses as $id => $status)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $table->status->id ?? '') == $id ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.table.fields.status_helper') }}</span>
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