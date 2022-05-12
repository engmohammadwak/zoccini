@extends('layouts.website')
@section('content')

    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')

        <div class="page-content">
            <div class="container">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <div class="row mb-4 mb-lg-5">
                            <div class="col-12">
                                <h2 class="title-section font-bold mb-2">{{web('A world of customers now within your reach')}}</h2>
                                <h5 class="text_muted">{{web('zoccini’s platform gives you the flexibility, visibility and
                                    customer insights you need to connect with more customers. Partner with us
                                    today.')}}</h5>
                            </div>
                        </div>
                        <div class="row mb-4 mb-lg-5">
                            <div class="col-lg-6">
                                @foreach($become_partner as $value)
                                    <div class="row no-gutters mb-4">
                                        <div class="col-auto">
                                            <div class="symbol symbol symbol-50 mr-3 mt-2"><img class="rounded-circle"
                                                                                                src="{{url('local/public')}}/assets/images/circle.svg"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h3 class="font-medium">{{$value->title}}</h3>
                                            <p class="text_muted font-size-14">{{$value->body}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12"><a class="btn btn-primary font-semiBold"
                                                   href="{{url('becomePartner_2')}}">{{web('Get Started')}} </a></div>
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
