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
                        <div class="row">
                            <div class="col-lg-9 mx-auto">
                                <div class="bg-white rounded_md py-lg-4 mt-5">
                                    <div class="row">
                                        <div class="col-lg-5 mx-auto">
                                            <div class="text-center py-5">
                                                <div class="icon mb-2">
                                                    <svg width="68" height="68" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M34.0001 0.00013866C52.7776 0.00013866 68 15.2225 68 34.0001C68 52.7776 52.7776 68 34.0001 68C15.2225 68 0.000141027 52.7776 0.000141027 34.0001C-0.0532895 15.2757 15.0823 0.0535692 33.8065 0.00013866C33.871 -4.62202e-05 33.9355 -4.62202e-05 34.0001 0.00013866Z" fill="#27BA4D"/>
                                                        <path d="M49 26.3921L29.7693 46L19 35.0981L23.3847 30.7059L29.7693 37.1373L44.6155 22L49 26.3921Z" fill="white"/>
                                                    </svg>
                                                </div>
                                                <h2 class="font-medium mb-2">{{web('Thank You!')}}</h2>
                                                <h5 class="mb-4 px-2">{{web('For most businesses that want to otpimize web queries')}}</h5>
                                                <a href="{{url()->previous()}}" class="btn btn-primary px-lg-5">{{web('Go it')}}</a>
                                            </div>
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
