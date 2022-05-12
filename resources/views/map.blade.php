@extends('layouts.website')
@section('content')
    <style>
        .bootstrap-select.custom_select .dropdown-toggle .filter-option-inner-inner {
            text-align: left;
            color: black;
        }
    </style>
    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')

        <div class="page-content bg-gray-2">
            <div class="container pb-5">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5">
                                <form action="{{url('/map')}}" method="get">
                                    <div class="input-filter mb-4">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="key" id="key"
                                                   value="{{request()->get('key') ? request()->get('key') : '' }}"
                                                   placeholder="{{web('Search resturantr name, location')}}">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.385 16.3744L13.175 12.168C14.2297 10.8813 14.808 9.27109 14.808 7.6082C14.808 3.63731 11.5771 0.408203 7.60801 0.408203C6.6377 0.408203 5.69551 0.598047 4.80781 0.974219C3.95 1.33809 3.18008 1.85664 2.51914 2.51758C1.8582 3.17852 1.33789 3.94844 0.974024 4.80625C0.597852 5.69395 0.40625 6.63613 0.40625 7.60645C0.40625 11.5773 3.63711 14.8064 7.60625 14.8064C9.2709 14.8064 10.8793 14.2281 12.166 13.1734L16.3725 17.3799C16.5078 17.5152 16.6871 17.5891 16.877 17.5891C17.0686 17.5891 17.2479 17.5152 17.3814 17.3799C17.6627 17.1039 17.6627 16.6521 17.385 16.3744ZM13.3824 7.60645C13.3824 10.7916 10.7914 13.3809 7.60801 13.3809C4.42285 13.3809 1.83359 10.7898 1.83359 7.60645C1.83359 4.42305 4.42461 1.83203 7.60801 1.83203C10.7914 1.83203 13.3824 4.42305 13.3824 7.60645Z"
                                                        fill="#4C4C4C"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="input-group-filter toggle-filter">
                                            <svg class="mr-2" width="18" height="17" viewBox="0 0 18 17" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.33001 13.593H1.0293" stroke="#27BA4D" stroke-width="1.5"
                                                      stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10.1406 3.90066H16.4413" stroke="#27BA4D" stroke-width="1.5"
                                                      stroke-linecap="round" stroke-linejoin="round"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M5.72629 3.84625C5.72629 2.5506 4.66813 1.5 3.36314 1.5C2.05816 1.5 1 2.5506 1 3.84625C1 5.14191 2.05816 6.19251 3.36314 6.19251C4.66813 6.19251 5.72629 5.14191 5.72629 3.84625Z"
                                                      stroke="#27BA4D" stroke-width="1.5" stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M16.9997 13.5533C16.9997 12.2576 15.9424 11.207 14.6374 11.207C13.3316 11.207 12.2734 12.2576 12.2734 13.5533C12.2734 14.8489 13.3316 15.8995 14.6374 15.8995C15.9424 15.8995 16.9997 14.8489 16.9997 13.5533Z"
                                                      stroke="#27BA4D" stroke-width="1.5" stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                            </svg>
                                            Filters
                                        </div>
                                    </div>
                                    <div class="widget-filter">
                                        <div class="row row-md">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="lable-form">City:</label>
                                                    <select id="city_id" class="selectpicker custom_select"
                                                            name="city_id" data-style="btn_white"
                                                            title="Select" data-width="100%">
                                                        @foreach($city as $value)
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="lable-form">Food type::</label>
                                                    <select id="tag" class="selectpicker custom_select" data-style="btn_white"
                                                            title="Select" data-width="100%">
                                                        @foreach($tag_all as $tag)
                                                            @if ($tag == '')
                                                                @php continue; @endphp
                                                            @endif
                                                        <option value="{{$tag}}">{{$tag}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="scroll pr-2">
                                    @foreach($restaurant as $value)
                                        <a href="{{url('/map?id='.$value->id.'&lat='.$value->lat.'&long='.$value->lang)}}">
                                            <div
                                                class="widget__item-search mb-3 {{$value->id == request()->get('id') ? 'active' : ''}}">
                                                <div class="d-flex align-items-start mb-2 justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="widget__item-image mr-2">
                                                            <img class="rounded-circle"
                                                                 src="{{url('local/public/img/user/'.optional($value->restaurant)->image)}}"
                                                                 alt=""
                                                                 style="width: 69px;height: 64px;">
                                                        </div>
                                                        <div class="widget__item-content">
                                                            <h4 class="widget__item-title font-medium">{{$value->name}}</h4>
                                                            <h6 class="widget__item-text">{{optional($value->country)->names}}
                                                                , {{optional($value->city)->name}}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="widget__item-rating font-medium"><i
                                                            class="fas fa-star mr-1"></i>{{number_format($value->rating , '1' ,'.' ,',')}}
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a target="_blank"
                                                       href="http://www.google.com/maps/place/{{$value->lat}},{{$value->lang}}"
                                                       class="btn btn-white px-1 py-1 d-flex align-items-center color-primary">
                                                        <svg class="mr-1" width="16" height="16" viewBox="0 0 16 16"
                                                             fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M0.275879 8.82764H1.71033C2.08728 11.6735 4.32654 13.9127 7.17236 14.2897V15.7241C7.17285 15.8763 7.29614 15.9995 7.44824 16H8.55176C8.70386 15.9995 8.82715 15.8763 8.82764 15.7241V14.2897C11.6735 13.9127 13.9127 11.6735 14.2897 8.82764H15.7241C15.8763 8.82715 15.9995 8.70386 16 8.55176V7.44824C15.9995 7.29614 15.8763 7.17285 15.7241 7.17236H14.2897C13.9127 4.32654 11.6735 2.08728 8.82764 1.71033V0.275879C8.82715 0.123657 8.70386 0.000488281 8.55176 0H7.44824C7.29614 0.000488281 7.17285 0.123657 7.17236 0.275879V1.71033C4.32654 2.08728 2.08728 4.32654 1.71033 7.17236H0.275879C0.123657 7.17285 0.000488281 7.29614 0 7.44824V8.55176C0.000488281 8.70386 0.123657 8.82715 0.275879 8.82764ZM8 3.3103C10.59 3.3103 12.6897 5.41003 12.6897 8C12.6897 10.59 10.59 12.6897 8 12.6897C5.41003 12.6897 3.3103 10.59 3.3103 8C3.31396 5.4115 5.4115 3.31396 8 3.3103Z"
                                                                fill="#27BA4D"/>
                                                            <path
                                                                d="M10.2068 7.99988C10.2068 9.21875 9.21875 10.2068 7.99988 10.2068C6.78101 10.2068 5.79297 9.21875 5.79297 7.99988C5.79297 6.78101 6.78101 5.79297 7.99988 5.79297C9.21875 5.79297 10.2068 6.78101 10.2068 7.99988Z"
                                                                fill="#27BA4D"/>
                                                        </svg>
                                                        {{web('View on Google Map')}}
                                                    </a>
                                                    <div class="widget__item-text">
                                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M12.8333 7C12.8333 10.2216 10.2216 12.8333 7 12.8333C3.77834 12.8333 1.16667 10.2216 1.16667 7C1.16667 3.77834 3.77834 1.16667 7 1.16667C10.2216 1.16667 12.8333 3.77834 12.8333 7ZM14 7C14 10.866 10.866 14 7 14C3.134 14 0 10.866 0 7C0 3.134 3.134 0 7 0C10.866 0 14 3.134 14 7ZM10.5 7.58333C10.8221 7.58333 11.0833 7.32216 11.0833 7C11.0833 6.67784 10.8221 6.41667 10.5 6.41667H7.58333V3.5C7.58333 3.17784 7.32216 2.91667 7 2.91667C6.67784 2.91667 6.41667 3.17784 6.41667 3.5V7C6.41667 7.32216 6.67784 7.58333 7 7.58333H10.5Z"
                                                                  fill="#C5C5C5"/>
                                                        </svg>
                                                        {{date('h a', strtotime($value->open_time)) . ' - ' . date('h a', strtotime($value->close_time))}}
                                                    </div>
                                                    <div class="widget__item-text">
                                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M12.2916 10.6267C12.4208 10.4972 12.4103 10.2843 12.2688 10.1684L10.2082 8.4798C10.0853 8.37912 9.90628 8.38809 9.79407 8.50047L8.85873 9.43728C8.57605 9.7204 8.13674 9.79484 7.77702 9.5983C6.98737 9.1669 6.37753 8.7378 5.84851 8.20498C5.32017 7.67283 4.88346 7.04836 4.42795 6.23923C4.22422 5.8773 4.29471 5.42931 4.58215 5.14142L5.51121 4.21092C5.62341 4.09851 5.63237 3.91921 5.53184 3.79618L3.84585 1.73233C3.73011 1.59066 3.51754 1.58004 3.38829 1.70948L2.24471 2.85486C1.64422 3.4563 1.44782 4.34856 1.77627 5.1116C2.56598 6.94619 3.4154 8.30288 4.52163 9.40689C5.62842 10.5114 7.00795 11.3786 8.88042 12.212C9.65115 12.5551 10.5586 12.3624 11.1676 11.7524L12.2916 10.6267ZM12.6601 9.68945C13.0844 10.0372 13.1163 10.676 12.7285 11.0643L11.6045 12.19C10.8275 12.9682 9.64998 13.2317 8.6295 12.7775C6.71495 11.9255 5.26324 11.0206 4.08552 9.84528C2.90725 8.66942 2.01897 7.23853 1.20888 5.35661C0.772565 4.34299 1.04237 3.18392 1.80781 2.41728L2.95139 1.2719C3.33911 0.883561 3.97684 0.915419 4.32406 1.34046L6.01008 3.40431C6.3116 3.7734 6.28479 4.31129 5.94811 4.64851L5.01905 5.57901C4.92179 5.67642 4.90271 5.82253 4.96617 5.93528C5.40566 6.71598 5.81082 7.2894 6.28664 7.76863C6.76179 8.24718 7.31843 8.64281 8.07285 9.05502C8.18327 9.11529 8.32587 9.0958 8.42183 8.99969L9.35717 8.06289C9.69385 7.72568 10.2309 7.69883 10.5994 8.00082L12.6601 9.68945Z"
                                                                  fill="#C5C5C5" stroke="#C5C5C5" stroke-width="0.4"/>
                                                        </svg>
                                                        {{optional($value->restaurant)->phone}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>


                                {{--                                <div class="widget__item-search mb-3 active">--}}
                                {{--                                    <div class="d-flex align-items-start mb-2 justify-content-between">--}}
                                {{--                                        <div class="d-flex align-items-center">--}}
                                {{--                                            <div class="widget__item-image mr-2">--}}
                                {{--                                                <img src="{{url('local/public')}}/assets/images/avatar.png" alt="">--}}
                                {{--                                            </div>--}}
                                {{--                                            <div class="widget__item-content">--}}
                                {{--                                                <h4 class="widget__item-title font-medium">kentucky restaurant</h4>--}}
                                {{--                                                <h6 class="widget__item-text">UAE, Abu Dhabi</h6>--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="widget__item-rating font-medium"><i class="fas fa-star mr-1"></i>4.5</div>--}}
                                {{--                                    </div>--}}
                                {{--                                    <div class="d-flex align-items-center justify-content-between">--}}
                                {{--                                        <button class="btn btn-white px-1 py-1 d-flex align-items-center color-primary">--}}
                                {{--                                            <svg class="mr-1" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                                {{--                                                <path d="M0.275879 8.82764H1.71033C2.08728 11.6735 4.32654 13.9127 7.17236 14.2897V15.7241C7.17285 15.8763 7.29614 15.9995 7.44824 16H8.55176C8.70386 15.9995 8.82715 15.8763 8.82764 15.7241V14.2897C11.6735 13.9127 13.9127 11.6735 14.2897 8.82764H15.7241C15.8763 8.82715 15.9995 8.70386 16 8.55176V7.44824C15.9995 7.29614 15.8763 7.17285 15.7241 7.17236H14.2897C13.9127 4.32654 11.6735 2.08728 8.82764 1.71033V0.275879C8.82715 0.123657 8.70386 0.000488281 8.55176 0H7.44824C7.29614 0.000488281 7.17285 0.123657 7.17236 0.275879V1.71033C4.32654 2.08728 2.08728 4.32654 1.71033 7.17236H0.275879C0.123657 7.17285 0.000488281 7.29614 0 7.44824V8.55176C0.000488281 8.70386 0.123657 8.82715 0.275879 8.82764ZM8 3.3103C10.59 3.3103 12.6897 5.41003 12.6897 8C12.6897 10.59 10.59 12.6897 8 12.6897C5.41003 12.6897 3.3103 10.59 3.3103 8C3.31396 5.4115 5.4115 3.31396 8 3.3103Z" fill="#27BA4D"/>--}}
                                {{--                                                <path d="M10.2068 7.99988C10.2068 9.21875 9.21875 10.2068 7.99988 10.2068C6.78101 10.2068 5.79297 9.21875 5.79297 7.99988C5.79297 6.78101 6.78101 5.79297 7.99988 5.79297C9.21875 5.79297 10.2068 6.78101 10.2068 7.99988Z" fill="#27BA4D"/>--}}
                                {{--                                            </svg>--}}
                                {{--                                            View on Google Map--}}
                                {{--                                        </button>--}}
                                {{--                                        <div class="widget__item-text">--}}
                                {{--                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                                {{--                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8333 7C12.8333 10.2216 10.2216 12.8333 7 12.8333C3.77834 12.8333 1.16667 10.2216 1.16667 7C1.16667 3.77834 3.77834 1.16667 7 1.16667C10.2216 1.16667 12.8333 3.77834 12.8333 7ZM14 7C14 10.866 10.866 14 7 14C3.134 14 0 10.866 0 7C0 3.134 3.134 0 7 0C10.866 0 14 3.134 14 7ZM10.5 7.58333C10.8221 7.58333 11.0833 7.32216 11.0833 7C11.0833 6.67784 10.8221 6.41667 10.5 6.41667H7.58333V3.5C7.58333 3.17784 7.32216 2.91667 7 2.91667C6.67784 2.91667 6.41667 3.17784 6.41667 3.5V7C6.41667 7.32216 6.67784 7.58333 7 7.58333H10.5Z" fill="#C5C5C5"/>--}}
                                {{--                                            </svg>--}}
                                {{--                                            8 AM - 9 PM--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="widget__item-text">--}}
                                {{--                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                                {{--                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2916 10.6267C12.4208 10.4972 12.4103 10.2843 12.2688 10.1684L10.2082 8.4798C10.0853 8.37912 9.90628 8.38809 9.79407 8.50047L8.85873 9.43728C8.57605 9.7204 8.13674 9.79484 7.77702 9.5983C6.98737 9.1669 6.37753 8.7378 5.84851 8.20498C5.32017 7.67283 4.88346 7.04836 4.42795 6.23923C4.22422 5.8773 4.29471 5.42931 4.58215 5.14142L5.51121 4.21092C5.62341 4.09851 5.63237 3.91921 5.53184 3.79618L3.84585 1.73233C3.73011 1.59066 3.51754 1.58004 3.38829 1.70948L2.24471 2.85486C1.64422 3.4563 1.44782 4.34856 1.77627 5.1116C2.56598 6.94619 3.4154 8.30288 4.52163 9.40689C5.62842 10.5114 7.00795 11.3786 8.88042 12.212C9.65115 12.5551 10.5586 12.3624 11.1676 11.7524L12.2916 10.6267ZM12.6601 9.68945C13.0844 10.0372 13.1163 10.676 12.7285 11.0643L11.6045 12.19C10.8275 12.9682 9.64998 13.2317 8.6295 12.7775C6.71495 11.9255 5.26324 11.0206 4.08552 9.84528C2.90725 8.66942 2.01897 7.23853 1.20888 5.35661C0.772565 4.34299 1.04237 3.18392 1.80781 2.41728L2.95139 1.2719C3.33911 0.883561 3.97684 0.915419 4.32406 1.34046L6.01008 3.40431C6.3116 3.7734 6.28479 4.31129 5.94811 4.64851L5.01905 5.57901C4.92179 5.67642 4.90271 5.82253 4.96617 5.93528C5.40566 6.71598 5.81082 7.2894 6.28664 7.76863C6.76179 8.24718 7.31843 8.64281 8.07285 9.05502C8.18327 9.11529 8.32587 9.0958 8.42183 8.99969L9.35717 8.06289C9.69385 7.72568 10.2309 7.69883 10.5994 8.00082L12.6601 9.68945Z" fill="#C5C5C5" stroke="#C5C5C5" stroke-width="0.4"/>--}}
                                {{--                                            </svg>--}}
                                {{--                                            +971 59 1552 1452--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                            <div class="col-lg-7">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        @include('partials.footer')

    </div>
    <!-- end:: Page -->

@endsection
@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap&libraries=places&language={{\Illuminate\Support\Facades\App::getLocale()}}"
        async defer></script>
    <script>


        function initMap() {

            var pos = {lat: 42.7601, lng: -71.0589};

            //Map options
            var options = {
                zoom: 12,
                center: pos
            }
            // new map
            var map = new google.maps.Map(document.getElementById('map'), options);
            @if(request()->get('lat') && request()->get('long'))

                latlng = new google.maps.LatLng({{request()->get('lat')}}, {{request()->get('long')}})
            map.setCenter(latlng)

            @else

            // if (navigator.geolocation) {
            //     navigator.geolocation.getCurrentPosition(showPosition);
            // }
            //
            // function showPosition(position) {
            //     lat = position.coords.latitude;
            //     lon = position.coords.longitude;
            //     pos = {lat: lat, lng: lon};
            //     latlng = new google.maps.LatLng(lat, lon)
            //     map.setCenter(latlng)
            // }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    console.log(pos);
                    map.setCenter(pos);
                    marker.setPosition(pos);

                }, function () {
                    //    handleLocationError(true, infoWindow, map.getCenter());
                });
            }


            @endif
            // customer marker
            {{--var iconBase_1 = '{{url('local/public')}}/assets/images/marker_1.svg';--}}
            {{--var iconBase_2 = '{{url('local/public')}}/assets/images/marker_2.svg';--}}
            {{--var iconBase_3 = '{{url('local/public')}}/assets/images/marker_3.svg';--}}

            var iconBase_1 = '{{url('local/public')}}/assets/images/zoccini.svg';
            var iconBase_2 = '{{url('local/public')}}/assets/images/zoccini.svg';
            var iconBase_3 = '{{url('local/public')}}/assets/images/zoccini.svg';
            //array of Marrkeers
            @php
                $numItems = count($restaurant);
                $i = 0;
            @endphp
            var markers = [
                    @foreach($restaurant as $value)
                {
                    coords: {lat: {{$value->lat}}, lng: {{$value->lang}}},
                    img: {{$value->id == request()->get('id') ? 'iconBase_3' : 'iconBase_1'}},
                    con: "{{$value->name}}"
                }
                @if(++$i !== $numItems)
                ,
                @endif

                @endforeach

            ];

            //loopthrough markers
            for (var i = 0; i < markers.length; i++) {
                //add markeers
                addMarker(markers[i]);
            }

            //function for the plotting markers on the map
            function addMarker(props) {
                var marker = new google.maps.Marker({
                    position: props.coords,
                    map: map,
                    icon: props.img
                });
                var infoWindow = new google.maps.InfoWindow({
                    content: props.con,
                });
                marker.addListener("click", () => {
                    infoWindow.open(map, marker);
                });
            }
        }
    </script>
    <script>
        $('.toggle-filter').click(function () {
            $('.widget-filter').slideToggle()
        })

        $('#city_id').on('change', function () {

            window.location.replace("{{url('/map?city_id=')}}" + this.value + "&key=" + $('#key').val());

        });

        $('#tag').on('change', function () {

            window.location.replace("{{url('/map?tag=')}}" + this.value + "&key=" + $('#key').val());

        });
    </script>
@endsection
