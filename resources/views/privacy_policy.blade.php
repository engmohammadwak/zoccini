@extends('layouts.website')
@section('content')
<style>
    body > div > div.page-content > div > section > div > div > div > div > p:nth-child(3) > span > span{
        font-family: Cairo-Regular!important;
    }
</style>
    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')

        <div class="page-content">
            <div class="container pb-5">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <h2 class="title-section font-bold">{{web('Privacy App')}}</h2>
                        <div class="content-text">
                            <div class="row">
                                <div class="col-lg-9">
                                    <p  class="mb-4 text_muted">
                                        {!! \Illuminate\Support\Facades\App::getLocale() == 'ar' ? getSetting('privacy_app_ar') : getSetting('privacy_app') !!}
                                    </p>

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
