@extends('layouts.website')
@section('content')

    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')

        <div class="page-content">
            <div class="container pb-5">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <h2 class="title-section font-bold">{{web('Our Profile')}}</h2>
                        <div class="content-text">
                            <div class="row">
                                <div class="col-lg-9">
                                    <p class="mb-4 text_muted">
                                        {!! \Illuminate\Support\Facades\App::getLocale() == 'ar' ? getSetting('our_profile_ar') : getSetting('our_profile') !!}

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
