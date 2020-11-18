@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.slideShow.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.slide-shows.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>{{ trans('cruds.slideShow.fields.type') }}</label>
                <select onclick="select()" class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SlideShow::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', 'image') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.slideShow.fields.type_helper') }}</span>
            </div>
            <div class="form-group" id="images" style="display: block">
                <label for="image">{{ trans('cruds.slideShow.fields.image') }}</label>
                <input type="file" name="image"  class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
            @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.slideShow.fields.image_helper') }}</span>
            </div>
            <div class="form-group" id="video" style="display: none">
                <label for="video_url">{{ trans('cruds.slideShow.fields.video_url') }}</label>
                <input class="form-control {{ $errors->has('video_url') ? 'is-invalid' : '' }}" type="text" name="video_url" id="video_url" value="{{ old('video_url', '') }}">
                @if($errors->has('video_url'))
                    <span class="text-danger">{{ $errors->first('video_url') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.slideShow.fields.video_url_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.slideShow.fields.status') }}</label>
                @foreach(App\Models\SlideShow::STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', '1') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.slideShow.fields.status_helper') }}</span>
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

@section('scripts')
<script>
    function select()
    {
        var video = document.getElementById('video');
        var select = document.getElementById('type').value;
        var image = document.getElementById('images');

        if (select == 'image'){
            video.style.display = 'none';
            image.style.display = 'block';
        } else{
            video.style.display = 'block';
            image.style.display = 'none';
        }
    }
</script>
@endsection