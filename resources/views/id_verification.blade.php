@extends('layouts.website')
@section('content')

    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')

        <div class="page-content bg-gray-2">
            <div class="container pb-5">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <h2 class="title-section font-bold">{{web('ID Verification')}}</h2>
                        <div class="row">
                            <div class="col-lg-3 mb-3 mb-lg-0">
                                <div class="bg-white rounded_md p-2">
                                    <ul class="widget__links">
                                        <li><a href="{{url('profile')}}">{{web('Personal Information')}}</a></li>
                                        <li><a href="{{url('id_verification')}}" class="active">{{web('ID Verification')}} </a></li>
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
                                                <h3 class="font-medium mb-4">{{web('ID Verification')}}</h3>
{{--                                                <div class="form-group d-flex">--}}
{{--                                                    <label class="m-radio mb-1 font-medium">--}}
{{--                                                        <input type="radio" name="verification_type"--}}
{{--                                                               value="national"--}}
{{--                                                              {{$user->verification_type ==  'national' ? 'checked' : ''}} /><span--}}
{{--                                                            class="checkmark"></span>{{web('National ID')}} </label>--}}
{{--                                                    <label class="m-radio mb-0 font-medium ml-5">--}}
{{--                                                        <input type="radio" {{$user->verification_type ==  'passboard' ? 'checked' : ''}}--}}
{{--                                                                                                         name="verification_type"--}}
{{--                                                                                                         value="passboard"/><span--}}
{{--                                                            class="checkmark"></span>{{web('Passboard ID')}} </label>--}}
{{--                                                </div>--}}
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control" name="national" value="{{$user->national ?? ''}}" type="text">
                                                        <label>{{web('National ID')}}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control" name="expire_date" type="text" value="{{$user->expire_date ?? ''}}">
                                                        <label>{{web('Expire Date')}}</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group row no-gutters">
                                                        <div class="input-group-prepend mr-1 col-auto input-upload">
                                                            <label class="input-group-label mb-0" for="upload_1">
                                                                {{web('Upload')}}
                                                                <input class="form-control uploadeImage" name="attach_national" accept="image/x-png,image/gif,image/jpeg" type="file" id="upload_1" />
                                                            </label>
                                                        </div>
                                                        <div class="col">
                                                            <span class="form-control"></span>
                                                            <label class="name-image"> {{web('Attach your National ID')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0 mt-4">
                                                    <button type="submit" class="btn btn-primary">{{web('Edit')}}</button>
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
