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
                        <h2 class="title-section font-bold">{{web('Plans and Pricing')}}</h2>
                        <div class="row justify-content-center">
                            @foreach($plan as $value)
                                <div class="col-lg-4 col-sm-6">
                                    <div class="bg-white widget__item-plan rounded_md p-4 mb-4">
                                        @if ($value->offer && $value->offer > 0)
                                            <div class="widget__item-discount font-medium">
                                                {{$value->offer}}% {{web('off')}}
                                            </div>
                                        @endif
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="widget-item-price font-medium pr-1">{{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? optional($value->currency)->name_ar : optional($value->currency)->name_en}}{{ '  ' .$value->price}}</h2>
                                            <h4 class="widget-item-duration">/{{$value->duration.'  '}} month</h4>
                                        </div>
                                        <h2 class="font-medium mb-2">{{$value->name}}</h2>
                                        {!! $value->description !!}
                                        <div class="text-center mt-4 mb-2">
                                            <a href="{{url('becomePartner_2?id='.$value->id)}}"
                                               class="btn btn-primary">{{web('Choose Plan')}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
