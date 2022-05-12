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
                    <select onclick="select()" class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}"
                            name="type" id="type">
                        <option value
                                disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
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
                    <input type="file" name="image"
                           class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                    @if($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.slideShow.fields.image_helper') }}</span>
                </div>
                <div class="form-group" id="video" style="display: none">
                    <label for="video_url">{{ trans('cruds.slideShow.fields.video_url') }}</label>
                    <input class="form-control {{ $errors->has('video_url') ? 'is-invalid' : '' }}" type="text"
                           name="video_url" id="video_url" value="{{ old('video_url', '') }}">
                    @if($errors->has('video_url'))
                        <span class="text-danger">{{ $errors->first('video_url') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.slideShow.fields.video_url_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="product_restaurant">{{ trans('cruds.slideShow.fields.product_restaurant') }}</label>
                    <select onchange="select_type()" required
                            class="form-control {{ $errors->has('product_restaurant') ? 'is-invalid' : '' }}"
                            name="product_restaurant" id="product_restaurant" required>
                        <option value="0" {{ old('product_restaurant') == '0' ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        <option value="1" {{ old('product_restaurant') == '1' ? 'selected' : '' }}>{{ trans('cruds.slideShow.fields.product') }}</option>
                        <option value="2" {{ old('product_restaurant') == '2' ? 'selected' : '' }}>{{ trans('cruds.slideShow.fields.restaurant') }}</option>
                    </select>
                    @if($errors->has('product_restaurant'))
                        <span class="text-danger">{{ $errors->first('product_restaurant') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.slideShow.fields.product_restaurant_helper') }}</span>
                </div>

                <div class="form-group" id="restaurants" style="display:none">
                    <label class="required" for="restaurants_id">{{ trans('cruds.order.fields.restaurants') }}</label>
                    <select class="form-control select2 {{ $errors->has('restaurants') ? 'is-invalid' : '' }}"
                            name="product_restaurant_id" id="restaurants_id">
                        @foreach($restaurants as $id => $restaurants)
                            <option value="{{ $id }}" {{ old('restaurants_id') == $id ? 'selected' : '' }}>{{ $restaurants }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('restaurants'))
                        <span class="text-danger">{{ $errors->first('restaurants') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.restaurants_helper') }}</span>
                </div>
                <div class="form-group" id="item" style="display:none">
                    <label for="items">{{ trans('cruds.order.fields.item') }}</label>
                    <select class="form-control select2 {{ $errors->has('items') ? 'is-invalid' : '' }}" name="product_restaurant_id"
                            id="items">
                        @foreach($items as $id => $item)
                            <option value="{{ $id }}" {{ old('items') == $id ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('items'))
                        <span class="text-danger">{{ $errors->first('items') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.item_helper') }}</span>
                </div>


                <div class="form-group">
                    <label>{{ trans('cruds.slideShow.fields.status') }}</label>
                    @foreach(App\Models\SlideShow::STATUS_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status"
                                   value="{{ $key }}" {{ old('status', '1') === (string) $key ? 'checked' : '' }}>
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
        function select() {
            var video = document.getElementById('video');
            var select = document.getElementById('type').value;
            var image = document.getElementById('images');

            if (select == 'image') {
                video.style.display = 'none';
                image.style.display = 'block';
            } else {
                video.style.display = 'block';
                image.style.display = 'none';
            }
        }


        function select_type() {
            var product_restaurant = document.getElementById('product_restaurant').value;
            var restaurants = document.getElementById('restaurants');
            var item = document.getElementById('item');

            if (product_restaurant == '1') {
                item.style.display = 'grid';
                restaurants.style.display = 'none';
            } else if (product_restaurant == '2') {
                item.style.display = 'none';
                restaurants.style.display = 'grid';
            } else {
                item.style.display = 'none';
                restaurants.style.display = 'none';
            }
        }


    </script>
@endsection