@extends('layouts.website')
@section('content')
<style>
    body > div > div.page-content > div > section > div > div > div.col-lg-6.ml-auto > div.text_muted.wow.fadeInDown.mb-4 > p > span > span{
        font-family: Baloo2-Regular!important;
    }
</style>
    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')
        <div class="page-content">
            <div class="container">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-5">
                                <div class="image bg-primary mb-4 mb-lg-0 wow fadeInDown text-center rounded_lg pt-5"
                                     data-wow-delay="0.3s"><img src="{{url('local/public')}}/assets/images/iPhone.png"
                                                                alt=""/></div>
                            </div>
                            <div class="col-lg-6 ml-auto">
                                <h2 class="title-section font-bold wow fadeInDown"
                                    data-wow-delay="0.2s">{{web('About Zoccinii')}}</h2>
                                <div class="text_muted wow fadeInDown mb-4" data-wow-delay="0.3s">
                                    {!! \Illuminate\Support\Facades\App::getLocale() == 'ar' ? getSetting('about_app_ar') : getSetting('about_app') !!}
                                </div>
                                <div class="d-flex align-items-center wow fadeInDown" data-wow-delay="0.4s">
                                    <a class="hover-scale" href="{{getSetting('app_store')}}"><img
                                            src="{{url('local/public')}}/assets/images/App-Store.png" alt=""/></a><a
                                        class="mx-3 hover-scale" href="{{getSetting('google_paly')}}"><img
                                            src="{{url('local/public')}}/assets/images/Google-Play.png" alt=""/></a>
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
