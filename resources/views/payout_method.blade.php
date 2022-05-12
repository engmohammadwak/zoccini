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
                        <h2 class="title-section font-bold">{{web('Payout method')}}</h2>
                        <div class="row">
                            <div class="col-lg-3 mb-3 mb-lg-0">
                                <div class="bg-white rounded_md p-2">
                                    <ul class="widget__links">
                                        <li><a href="{{url('profile')}}">{{web('Personal Information')}}</a></li>
                                        <li><a href="{{url('id_verification')}}">{{web('ID Verification')}} </a></li>
                                        <li><a href="{{url('payout_method')}}"
                                               class="active">{{web('Payout method')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="bg-white rounded_md p-3 p-lg-5">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <form action="{{url('update_profile')}}" method="post">
                                                @csrf
                                                <h3 class="font-medium mb-3"{{web('>Payout method')}}</h3>
                                                <h5>{{$user->bank ? web('Bank') : web('Cash')}}</h5>
                                                {{--                                                @if ($user->bank)--}}
                                                <div class="form-group mb-0 mt-5">
                                                    <button type="button"
                                                            class="btn btn-primary toggle-card">{{web('Edit')}}</button>
                                                </div>
                                                {{--                                                @endif--}}

                                                <div class="card-bank">
                                                    <div
                                                        class="d-flex align-items-center justify-content-between mt-5 mb-3">
                                                        <div class="form-group mb-0 d-flex">
                                                            <label class="m-radio radio-card mb-1 font-medium"> <input
                                                                    type="radio" class="radio_1"
                                                                    name="radio_1" {{$user->bank ? 'checked' : ''}} /><span
                                                                    class="checkmark"></span>{{web('Bank Account')}}
                                                            </label>
                                                            <label
                                                                class="m-radio radio-card mb-0 font-medium ml-4 ml-lg-5">
                                                                <input type="radio" class="radio_2"
                                                                       name="radio_1" {{!$user->bank ? 'checked' : ''}} /><span
                                                                    class="checkmark"></span>{{web('Cash')}} </label>
                                                        </div>
                                                    </div>
                                                    <div id="tet">
                                                        <div class="form-group text-center mb-0">
                                                            <a href="{{url('/update_profile_payment')}}" class="btn btn-primary" type="submit">{{web('Save')}}</a>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4 widget-list-add-method">
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input
                                                                    class="bank-name form-control @error('bank_name') is-invalid @enderror"
                                                                    name="bank_name"
                                                                    type="text"
                                                                    value="{{ optional($user->bank)->bank_name }}"/>
                                                                <label>{{web('bank name')}}</label>
                                                                @error('bank_name')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input
                                                                    class="swift-code form-control @error('swift_code') is-invalid @enderror"
                                                                    name="swift_code"
                                                                    type="text"
                                                                    value="{{ optional($user->bank)->swift_code }}"/>
                                                                <label>{{web('swift code')}} </label>
                                                                @error('swift_code')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input
                                                                    class="iban form-control @error('iban') is-invalid @enderror"
                                                                    name="iban"
                                                                    type="text"
                                                                    value="{{ optional($user->bank)->iban }}"/>
                                                                <label>{{web('IBAN')}}</label>
                                                                @error('iban')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input
                                                                    class="branch-no form-control @error('branch_no') is-invalid @enderror"
                                                                    name="branch_no"
                                                                    type="text"
                                                                    value="{{ optional($user->bank)->branch_no }}"/>
                                                                <label>{{web('Branch no.')}}</label>
                                                                @error('branch_no')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group text-center mb-0">
                                                            <button class="btn btn-primary" type="submit">{{web('Add')}}</button>
                                                        </div>
                                                    </div>
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

    <script>
        $('#tet').hide()
        @if(!$user->bank)
        $('.widget-list-add-method').fadeOut()
        @endif
        $('.toggle-card').click(function () {
            $('.card-bank').fadeToggle();
        });
        $('.radio-card').change(function () {
            if ($('.radio_1').is(':checked')) {
                $('.widget-list-add-method').fadeIn()
                $('#tet').hide()

            } else {
                $('.widget-list-add-method').fadeOut()
                $('#tet').show()
            }
        });
    </script>
@endsection
