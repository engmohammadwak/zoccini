@extends('layouts.website')
@section('content')
<style>
    #section-about > div > div > div.col-lg-6.ml-auto > div.wow.fadeInDown.mb-4.desc-about > p > span > span{
        font-family: Baloo2-Regular!important;
    }
</style>
    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
       @include('partials.header')
        <!-- begin:: section -->
        <div class="section p-0 section-hero">
            <div class="swiper-container slider-hero pb-0">
                <div class="swiper-wrapper">
                    @foreach($slider as $value)
                        <div class="swiper-slide slide-item">
                            <div class="slide-inner slide-bg-image main-sider-inner"
                                 data-background="{{$value->image_url}}"
                                 style="background-image: url({{$value->image_url}});">
                                <div class="container">
                                    <div class="row no-gutters">
                                        <div class="col-lg-5">
                                            <div class="hero-content">
                                                <h2 class="hero-title font-bold">{{$value->title}}</h2>
                                                <div class="hero-text">{{$value->body}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- end swiper-wrapper-->
                <div class="swiper-pagination"></div>
                <!-- swipper controls-->
            </div>
        </div>
        <!-- end:: section -->
        <!-- begin:: section -->
        <section class="section" id="section-about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="image bg-primary mb-4 mb-lg-0 wow fadeInDown text-center rounded_lg pt-5"
                             data-wow-delay="0.3s"><img src="{{asset('assets/images/iPhone.png')}}" alt=""/>
                        </div>
                    </div>
                    <div class="col-lg-6 ml-auto">
                        <h2 class="title-section font-bold wow fadeInDown" data-wow-delay="0.2s">{{web('About Zoccinii')}}</h2>
                        <div style="font-family: Baloo2-Regular" class="text_muted wow fadeInDown mb-4 desc-about" data-wow-delay="0.3s">
                            {!! \Illuminate\Support\Facades\App::getLocale() == 'ar' ?  substr(getSetting('about_app_ar'), 0, 175)  : substr(getSetting('about_app'), 0, 175) !!}
                        </div>
                        <div class="d-flex align-items-center wow fadeInDown" data-wow-delay="0.4s">
                            <a class="hover-scale" href="{{getSetting('google_paly')}}"><img
                                        src="{{asset('assets/images/App-Store.png')}}" alt=""/></a>
                            <a
                                    class="mx-3 hover-scale" href="{{getSetting('app_store')}}"><img
                                        src="{{asset('assets/images/Google-Play.png')}}"
                                        alt=""/></a>
                        </div>
                        <h3 class="mt-4 wow fadeInDown" data-wow-delay="0.4s">
                            <a href="{{url('AboutUs')}}" class="bg-white btn-link font-bold color-primary">
                                <span class="readMoreText">{{web('Read more')}}</span>
                                <svg class="ml-2" width="24" height="16" viewBox="0 0 24 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M15.2931 2.70711C14.9026 2.31658 14.9026 1.68342 15.2931 1.29289C15.6837 0.902369 16.3168 0.902369 16.7074 1.29289L22.7073 7.29289C23.0979 7.68342 23.0979 8.31658 22.7073 8.70711L16.7074 14.7071C16.3168 15.0976 15.6837 15.0976 15.2931 14.7071C14.9026 14.3166 14.9026 13.6834 15.2931 13.2929L19.586 8.99998H2.01103C1.45265 8.99998 1 8.55227 1 7.99998C1 7.4477 1.45265 6.99998 2.01103 6.99998H19.586L15.2931 2.70711Z"
                                            fill="#2BA94C"
                                            stroke="#2BA94C"
                                            stroke-width="0.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                    ></path>
                                </svg>
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </section>
        <!-- end:: section -->
        <!-- begin:: section -->
        <section class="section section-app" id="section-works">
            <div class="container py-lg-5">
                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <div class="text-center">
                            <h2 class="mb-0 title-section font-bold wow fadeInDown" data-wow-delay="0.2s">{{web('How it Works')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-lg-12 mx-auto">
                        <div class="cascade-slider_container" id="cascade-slider">
                            <div class="cascade-slider_slides">
                                <div class="cascade-slider_item">
                                    <img src="{{asset('assets/images/phone/img_1.png')}}" alt="">
                                </div>
                                <div class="cascade-slider_item">
                                    <img src="{{asset('assets/images/phone/img_2.png')}}" alt="">
                                </div>
                                <div class="cascade-slider_item">
                                    <img src="{{asset('assets/images/phone/img_3.png')}}" alt="">
                                </div>
                                <div class="cascade-slider_item">
                                    <img src="{{asset('assets/images/phone/img_1.png')}}" alt="">
                                </div>
                                <div class="cascade-slider_item">
                                    <img src="{{asset('assets/images/phone/img_2.png')}}" alt="">
                                </div>
                            </div>
                            <span class="cascade-slider_arrow cascade-slider_arrow-left" data-action="prev">
                  <svg width="22" height="14" viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M7.70711 1.70694C8.09763 1.31641 8.09763 0.68325 7.70711 0.292725C7.31658 -0.0977989 6.68342 -0.0977989 6.29289 0.292725L0.292893 6.29273C-0.097631 6.68325 -0.097631 7.31641 0.292893 7.70694L6.29289 13.7069C6.68342 14.0975 7.31658 14.0975 7.70711 13.7069C8.09763 13.3164 8.09763 12.6832 7.70711 12.2927L3.4142 7.99982H20.9892C21.5476 7.99982 22.0002 7.5521 22.0002 6.99982C22.0002 6.44753 21.5476 5.99982 20.9892 5.99982H3.41423L7.70711 1.70694Z"
                            fill="white"
                    ></path>
                  </svg>
                </span>
                            <span class="cascade-slider_arrow cascade-slider_arrow-right" data-action="next">
                  <svg width="22" height="14" viewBox="0 0 22 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                              d="M14.2931 1.70694C13.9026 1.31641 13.9026 0.68325 14.2931 0.292725C14.6837 -0.0977989 15.3168 -0.0977989 15.7074 0.292725L21.7073 6.29273C22.0979 6.68325 22.0979 7.31641 21.7073 7.70694L15.7074 13.7069C15.3168 14.0975 14.6837 14.0975 14.2931 13.7069C13.9026 13.3164 13.9026 12.6832 14.2931 12.2927L18.586 7.99982H1.01103C0.452653 7.99982 0 7.5521 0 6.99982C0 6.44753 0.452653 5.99982 1.01103 5.99982H18.586L14.2931 1.70694Z"
                              fill="white"
                      ></path>
                    </svg>
                  </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <p class="text-center">{{web('Orders can run smoothly with zoccini app, flexible integration options, and support when you need it.')}}</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- end:: section -->
        <!-- begin:: section -->
        <section class="section bg-gray" id="section-restaurants">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-5">
                        <div class="text-left">
                            <h2 class="mb-3 title-section font-bold wow fadeInDown" data-wow-delay="0.1s">{{web('Top')}}
                                {{web('Restaurants')}}</h2>
                            <p class="text_muted mb-3 wow fadeInDown" data-wow-delay="0.2s">{{web('Customers are ordering online now more than ever - be where they are. Enjoy tons of our meals and cousins.')}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="swiper-container swiper-filter pb-0 wow fadeInDown" data-wow-delay="0.3s">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <button class="btn-filter text_muted swiper-active" data-filter="">{{web('All')}}</button>
                                </div>
                                @foreach($categories as $category)
                                    <div class="swiper-slide">
                                        <div class="swiper-slide">
                                            <button class="btn-filter text_muted"
                                                    data-filter=".filter{{$category->id}}">{{$category->name}}</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="swiper-container slider-rest wow fadeInDown" data-wow-delay="0.3s">
                            <div class="swiper-wrapper">
                                @foreach($top_restaurant as $top)
                                    <div class="swiper-slide filter{{$top->category_id}}">
                                        <div class="widget__item-3 bg-white rounded_md">
                                            <div class="widget__item-image">
                                                <a href=""> <img src="{{$top->image_url}}"
                                                                 alt=""/></a>
                                            </div>
                                            <div class="widget__item-content">
                                                <h4 class="widget__item-title font-semiBold"><a class="text-dark"
                                                                                                href="">{{$top->title}} </a>
                                                </h4>
                                                <p class="widget__item-text text_muted">{{$top->body}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end:: section -->
        <!-- begin:: section -->
        <section class="section bg-primary" id="section-become">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-5 mb-5 mb-lg-0">
                        <div class="text-left">
                            <h2 class="mb-3 text-white title-section font-bold wow fadeInDown" data-wow-delay="0.1s">
                               {{web('Bacome a Partner')}}</h2>
                            <p class="mb-3 text-white wow fadeInDown" data-wow-delay="0.2s">
                                {{web('Thousands of zoccini app users may be searching for food in your area. By partnering
                                with and adding your restaurant to the platform, we can help you reach those users.')}}
                            </p>
                            <a style="{{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'margin-left: 71%;' : ''}}"  class="mb-3 btn btn-outline-white wow fadeInDown" href="{{url('plan')}}"
                               data-wow-delay="0.3s">{{web('Join now')}}</a>
                            <div class="mt-2 wow fadeInDown" data-wow-delay="0.4s">
                                <p class="text-dark"{{web('>Get the App')}}</p>
                                <a class="hover-scale d-inline-block" href="{{getSetting('google_paly_company')}}"><img
                                            src="{{asset('assets/images/Google-Play.png')}}"
                                            alt=""/></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 ml-auto">
                        <div class="text-center wow fadeInDown" data-wow-delay="0.3s"><img
                                    src="{{asset('assets/images/dashboard.png')}}" alt=""/></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end:: section -->
        <!-- begin:: section -->
        <section class="section bg-gray" id="section-partners">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="text-left">
                            <h2 class="mb-2 title-section font-bold wow fadeInDown" data-wow-delay="0.2s">{{web('Venture companies')}}</h2>
                            <h5 class="text_muted wow fadeInDown" data-wow-delay="0.3s">{{web('Partner with us to have a elite business on our platform.')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="swiper-container slider-clients wow fadeInDown" data-wow-delay="0.3s">
                            <div class="swiper-wrapper">
                                @foreach($venture_company as $company)
                                    <div class="swiper-slide">
                                        <div class="widget__item-2 bg-white rounded_md">
                                            <div class="widget__item-image"><img
                                                        src="{{$company->image_url}}"
                                                        alt=""/></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end:: section -->
@include('partials.footer')
    </div>
    <!-- end:: Page -->

@endsection
@section('scripts')
    <script>
        /*------------------------------------
          Fixed Header And Scroll page
        --------------------------------------*/
        $(window).scroll(function () {
            $(".section").each(function () {
                if ($(window).scrollTop() > $(this).offset().top - 80) {
                    var blockID = $(this).attr("id");
                    $(".main-header a").removeClass("active");
                    $('.main-header a[data-scroll="' + blockID + '"]').addClass("active");
                }
            });
        });

        $(".main-header a[data-scroll] ").click(function (e) {
            e.preventDefault();

            $("html, body").animate(
                {
                    scrollTop: $("#" + $(this).data("scroll")).offset().top - 70,
                },
                1400
            );

            if ($(window).width() < 992) {
                $(".menu--mobile").removeClass("menu-mobile-active");
                $(".mobile-menu-overlay").removeClass("mobile-menu-overlay-active");
            }
        });

        $(window).scroll(function () {
            fixedHeader();
        });
        $(window).on("load", function () {
            fixedHeader();
        });

        function fixedHeader() {
            if ($(window).scrollTop() > 50) {
                $(".main-header").addClass("fixed-header");
                $(".menu_top").addClass("height");
            } else {
                $(".main-header").removeClass("fixed-header");
                $(".menu_top").removeClass("height");
            }
        }

        //

        /*------------------------------------
              swiper
          --------------------------------------*/
        var interleaveOffset = 0.5;
        var swiperOptions = {
            // loop: true,
            speed: 2500,
            parallax: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            watchSlidesProgress: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".section-hero .swiper-button-next",
                prevEl: ".section-hero .swiper-button-prev",
            },

            on: {
                progress: function () {
                    var swiper = this;
                    for (var i = 0; i < swiper.slides.length; i++) {
                        var slideProgress = swiper.slides[i].progress;
                        var innerOffset = swiper.width * interleaveOffset;
                        var innerTranslate = slideProgress * innerOffset;
                        swiper.slides[i].querySelector(".slide-inner").style.transform = "translate3d(" + innerTranslate + "px, 0, 0)";
                    }
                },

                touchStart: function () {
                    var swiper = this;
                    for (var i = 0; i < swiper.slides.length; i++) {
                        swiper.slides[i].style.transition = "";
                    }
                },

                setTransition: function (speed) {
                    var swiper = this;
                    for (var i = 0; i < swiper.slides.length; i++) {
                        swiper.slides[i].style.transition = speed + "ms";
                        swiper.slides[i].querySelector(".main-sider-inner").style.transition = speed + "ms";
                    }
                },
            },
        };

        var swiper = new Swiper(".slider-hero", swiperOptions);
    </script>
@endsection
