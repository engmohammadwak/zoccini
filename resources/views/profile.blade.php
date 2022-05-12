@extends('layouts.website')
@section('content')
    <style>
        .hide{
            display:none;
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
                        <h2 class="title-section font-bold">{{web('Personal Information')}}</h2>
                        <div class="row">
                            <div class="col-lg-3 mb-3 mb-lg-0">
                                <div class="bg-white rounded_md p-2">
                                    <ul class="widget__links">
                                        <li><a href="{{url('profile')}}" class="active">{{web('Personal Information')}}</a></li>
                                        <li><a href="{{url('id_verification')}}">{{web('ID Verification')}} </a></li>
                                        <li><a href="{{url('payout_method')}}">{{web('Payout method')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="bg-white rounded_md p-3 p-lg-5">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <form action="{{url('update_profile')}}" method="post">
                                                @csrf
                                                <h3 class="font-medium mb-4">{{web('Personal Information')}}</h3>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control" type="text" name="name" value="{{ \Illuminate\Support\Facades\Auth::user()['name'] }}">
                                                        <label>{{web('First name')}}</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('phone') is-invalid @enderror" type="text" style="width: 414px" id="phone" name="phone" value="{{ \Illuminate\Support\Facades\Auth::user()['phone'] }}"/>
                                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                                        <span id="error-msg" class="hide"></span>
                                                        {{--                                                        <label>{{web('Mobile No')}} </label>--}}
                                                        @error('phone')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
{{--                                                <div class="form-group form-phone">--}}
{{--                                                    <div class="input-group row no-gutters">--}}
{{--                                                        <div class="input-group-prepend mr-1 col-auto">--}}
{{--                                                            <select class="selectpicker select-country" data-size="4" data-style="btn_white" data-width="110px">--}}
{{--                                                                <option--}}
{{--                                                                    data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+970</span>"></option>--}}
{{--                                                                <option--}}
{{--                                                                    data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+972</span>"></option>--}}
{{--                                                                <option--}}
{{--                                                                    data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+966</span>"></option>--}}
{{--                                                                <option--}}
{{--                                                                    data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+973</span>"></option>--}}

{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="input-wrapper col">--}}
{{--                                                            <input class="form-control" type="text" name="phone" value="{{ \Illuminate\Support\Facades\Auth::user()['phone'] }}" />--}}
{{--                                                            <label>{{web('Mobile No.')}}</label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control" type="text" name="email" value="{{ \Illuminate\Support\Facades\Auth::user()['email'] }}">
                                                        <label>{{web('Email')}}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 mt-4">
                                                    <button type="submit" class="btn btn-primary">{{web('Save')}}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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

@endsection
