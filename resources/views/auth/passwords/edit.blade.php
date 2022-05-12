@extends('layouts.admin')
@section('content')

<div class="row">
    @if (\Illuminate\Support\Facades\Auth::user()['user_type'] == 3)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.my_profile') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("profile.password.updateProfile") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6"><div class="form-group">
                                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', optional($restaurant->restaurant)->name) }}" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                                </div></div>
                            <div class="col-md-6"><div class="form-group">
                                    <label class="required" for="last_name">{{ trans('cruds.user.fields.last_name') }}</label>
                                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" id="last_name" value="{{ old('last_name', optional($restaurant->restaurant)->last_name) }}" required>
                                    @if($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.last_name_helper') }}</span>
                                </div></div>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                            <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', optional($restaurant->restaurant)->phone) }}" required>
                            @if($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="image">{{ trans('cruds.user.fields.image') }}</label>
                            <br>
                            @if(optional($restaurant->restaurant)->image)
                                <a href="{{ url('local/public/img/user/' . optional($restaurant->restaurant)->image) }}" target="_blank">
                                    <img src="{{ url('local/public/img/user/' . optional($restaurant->restaurant)->image) }}" width="50px" height="50px">
                                </a>
                            @else
                                <a href="{{ url('local/public/img/setting/' . getSetting('user_image')) }}" target="_blank">
                                    <img src="{{ url('local/public/img/setting/' . getSetting('user_image')) }}" width="50px" height="50px">
                                </a>
                            @endif

                            <input type="file" name="logo" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">

                            @if($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.image_helper') }}</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><div class="form-group">
                                    <label class="required" for="name_ar">{{ trans('cruds.restaurant.fields.name_ar') }}</label>
                                    <input class="form-control {{ $errors->has('name_ar') ? 'is-invalid' : '' }}" type="text" name="name_ar" id="name_ar" value="{{ old('name_ar', $restaurant->name_ar) }}" required>
                                    @if($errors->has('name_ar'))
                                        <span class="text-danger">{{ $errors->first('name_ar') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.restaurant.fields.name_ar_helper') }}</span>
                                </div></div>
                            <div class="col-md-6"><div class="form-group">
                                    <label class="required" for="name_en">{{ trans('cruds.restaurant.fields.name_en') }}</label>
                                    <input class="form-control {{ $errors->has('name_en') ? 'is-invalid' : '' }}" type="text" name="name_en" id="name_en" value="{{ old('name_en', $restaurant->name_en) }}" required>
                                    @if($errors->has('name_en'))
                                        <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.restaurant.fields.name_en_helper') }}</span>
                                </div></div>
                        </div>
                        <div class="form-group">
                            <label for="description_ar">{{ trans('cruds.restaurant.fields.description_ar') }}</label>
                            <textarea class="form-control {{ $errors->has('description_ar') ? 'is-invalid' : '' }}" name="description_ar" id="description_ar">{{ old('description_ar', $restaurant->description_ar) }}</textarea>
                            @if($errors->has('description_ar'))
                                <span class="text-danger">{{ $errors->first('description_ar') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.description_ar_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description_en">{{ trans('cruds.restaurant.fields.description_en') }}</label>
                            <textarea class="form-control {{ $errors->has('description_en') ? 'is-invalid' : '' }}" name="description_en" id="description_en">{{ old('description_en', $restaurant->description_en) }}</textarea>
                            @if($errors->has('description_en'))
                                <span class="text-danger">{{ $errors->first('description_en') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.description_en_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="image">{{ trans('cruds.restaurant.fields.image') }}</label>
                            @if($restaurant->image)
                                <a href="{{ $restaurant->image_url }}" target="_blank">
                                    <img src="{{ $restaurant->image_url }}" width="50px" height="50px">
                                </a>
                            @endif

                            <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">

                            @if($errors->has('image'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('image') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.image_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="photo">{{ trans('cruds.restaurant.fields.photo') }}</label>
                            @if(isset($restaurant->media))
                                <div class="container">
                                    <div class="row">
                                    @foreach($restaurant->media as $value)
                                        <!-- TH1 -->
                                            <div class="col-sm-1" style="float: right ; width: 140px;margin-top: 3%;">
                                                <div class="thumbnail">
                                                    <a href="{{ route('admin.deleteImage', $value->id) }}" style="margin-top: -18%;margin-right: 34px;">&#10006;</a>
                                                    <img class="img-fluid" src="{{$value->image_url}}" height="100" width="100">

                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endif
                            <input type="file" name="photo[]" multiple>

                            @if($errors->has('photo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('photo') }}
                                </div>
                            @endif
                        </div>


                        <div class="form-group">
                            <label for="tag">{{ trans('cruds.restaurant.fields.tag') }}</label>
                            <input class="form-control {{ $errors->has('tag') ? 'is-invalid' : '' }}" type="text" name="tag" id="tag" value="{{ old('tag', $restaurant->tag) }}">
                            @if($errors->has('tag'))
                                <span class="text-danger">{{ $errors->first('tag') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.tag_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="address">{{ trans('cruds.restaurant.fields.address') }}</label>
                            <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $restaurant->address) }}">
                            @if($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.address_helper') }}</span>
                        </div>


                        <div class="form-group">
                            <label for="open_time">{{ trans('cruds.restaurant.fields.open_time') }}</label>
                            <input class="form-control timepicker {{ $errors->has('open_time') ? 'is-invalid' : '' }}" type="text" name="open_time" id="open_time" value="{{ old('open_time', $restaurant->open_time) }}">
                            @if($errors->has('open_time'))
                                <span class="text-danger">{{ $errors->first('open_time') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.open_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="close_time">{{ trans('cruds.restaurant.fields.close_time') }}</label>
                            <input class="form-control timepicker {{ $errors->has('close_time') ? 'is-invalid' : '' }}" type="text" name="close_time" id="close_time" value="{{ old('close_time', $restaurant->close_time) }}">
                            @if($errors->has('close_time'))
                                <span class="text-danger">{{ $errors->first('close_time') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.close_time_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="min_waiting">{{ trans('cruds.restaurant.fields.min_waiting') }}</label>
                            <input class="form-control {{ $errors->has('min_waiting') ? 'is-invalid' : '' }}" type="text" name="min_waiting" id="min_waiting" value="{{ old('min_waiting', $restaurant->min_waiting) }}">
                            @if($errors->has('min_waiting'))
                                <span class="text-danger">{{ $errors->first('min_waiting') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.min_waiting_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="max_waiting">{{ trans('cruds.restaurant.fields.max_waiting') }}</label>
                            <input class="form-control {{ $errors->has('max_waiting') ? 'is-invalid' : '' }}" type="text" name="max_waiting" id="max_waiting" value="{{ old('max_waiting', $restaurant->max_waiting) }}">
                            @if($errors->has('max_waiting'))
                                <span class="text-danger">{{ $errors->first('max_waiting') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.max_waiting_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.restaurant.fields.delivery_support') }}</label>
                                <div class="form-check {{ $errors->has('delivery_support') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="yes" name="delivery_support" value="1" {{ old('delivery_support', $restaurant->delivery_support) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="1">{{trans('cruds.Yes')}}</label>
                                </div>

                            <div class="form-check {{ $errors->has('delivery_support') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="no" name="delivery_support" value="0" {{ old('delivery_support', $restaurant->delivery_support) == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="0">{{trans('cruds.No')}}</label>
                                </div>
                            @if($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('delivery_support') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.delivery_support_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label class="required">{{ trans('cruds.restaurant.fields.car_delivery_support') }}</label>
                                <div class="form-check {{ $errors->has('car_delivery_support') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="yes" name="car_delivery_support" value="1" {{ old('car_delivery_support', $restaurant->car_delivery_support) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="1">{{trans('cruds.Yes')}}</label>
                                </div>

                            <div class="form-check {{ $errors->has('car_delivery_support') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="radio" id="no" name="car_delivery_support" value="0" {{ old('car_delivery_support', $restaurant->car_delivery_support) == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="0">{{trans('cruds.No')}}</label>
                                </div>
                            @if($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('car_delivery_support') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.restaurant.fields.car_delivery_support_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <label for="address_address">{{trans('cruds.location')}}</label>
                            <input type="hidden" name="lat" id="lat" value="{{$restaurant->lat}}"/>
                            <input type="hidden" name="lang" id="lang" value="{{$restaurant->lang}}"/>
                            <div id="address-map-container" style="width:100%;height:400px; ">
                                <div style="width: 100%; height: 100%" id="map"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.my_profile') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("profile.password.updateProfile") }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6"><div class="form-group">
                                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', \Illuminate\Support\Facades\Auth::user()['name']) }}" required>
                                    @if($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                                </div></div>
                            <div class="col-md-6"><div class="form-group">
                                    <label class="required" for="last_name">{{ trans('cruds.user.fields.last_name') }}</label>
                                    <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" id="last_name" value="{{ old('last_name', \Illuminate\Support\Facades\Auth::user()['last_name']) }}" required>
                                    @if($errors->has('last_name'))
                                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.user.fields.last_name_helper') }}</span>
                                </div></div>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                            <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', \Illuminate\Support\Facades\Auth::user()['phone']) }}" required>
                            @if($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ trans('global.change_password') }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route("profile.password.update") }}">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="password">New {{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                        @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="password_confirmation">Repeat New {{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" type="password" name="password_confirmation" id="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if (\Illuminate\Support\Facades\Auth::id() != 1)
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ trans('global.delete_account') }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("profile.password.destroyProfile") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                    @csrf
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.delete') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endif
@endsection

@if (\Illuminate\Support\Facades\Auth::user()['user_type'] == 3)

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap&libraries=places"
        defer></script>
<script>
    let marker;

    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: {lat: 21.513513513513512, lng: 39.18008375438145},
        });

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            icon : '{{url('local/public')}}/assets/images/zoccini.svg',
            @if($restaurant->lat)
            position: {lat: {{$restaurant->lat}}, lng: {{$restaurant->lang}} },
            @else
            position: {lat: 21.513513513513512, lng: 39.18008375438145},
            @endif
        });
        @if($restaurant->lat)
        var home = {
            lat: {{$restaurant->lat}},
            lng: {{$restaurant->lang}}
        };

        map.setCenter(home);
        marker.setPosition(home);
        @endif
            @if(!$restaurant->lat)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                map.setCenter(pos);
                marker.setPosition(pos);
                document.getElementById('lat').value = position.coords.latitude;
                document.getElementById('lang').value = position.coords.longitude;
            }, function() {
                //    handleLocationError(true, infoWindow, map.getCenter());
            });
        }
        @endif
        marker.addListener("dragend", toggleBounce);
    }

    /* google.maps.event.addListener(marker, 'dragend', function(event) {
          alert(event.latLng);
      }); */

    function toggleBounce(event) {
        var lat = document.getElementById('lat');
        var lang = document.getElementById('lang');
        lat.value = event.latLng.lat();
        lang.value = event.latLng.lng();
    }


</script>

@endif
