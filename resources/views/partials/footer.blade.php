<!-- begin:: footer -->
<footer class="main-footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <h3 class="title-footer font-bold">{{web('Quick links')}}</h3>
                    <ul class="link-footer menu">
                        <li><a href="{{url('/')}}#section-about" data-scroll="section-about">{{web('About us')}}</a>
                        </li>
                        <li><a href="{{url('/')}}#section-works" data-scroll="section-works">{{web('How it works')}}</a>
                        </li>
                        <li><a href="{{url('/')}}#section-restaurants"
                               data-scroll="section-restaurants">{{web('Top Restaurants')}}</a></li>
                        <li><a href="{{url('/')}}#section-become"
                               data-scroll="section-become">{{web('Become a Partner')}}</a></li>
                        <li><a href="{{url('/')}}#section-partners"
                               data-scroll="section-partners">{{web('Our Partners')}}</a></li>
                        <li><a href="{{url('/map')}}">{{web('Map')}}</a></li>
                        <!--<li><a href="{{url('/login?type=join')}}"><img class="mb-3"-->
                        <!--                                               src="{{url('local/public')}}/assets/images/logo_2.svg"-->
                        <!--                                               alt="" width="45%"></a></li>-->

                    </ul>
                </div>
                <div class="col-lg-3">
                    <h3 class="title-footer font-bold">{{web('Legal')}}</h3>
                    <ul class="link-footer menu">
                        <li><a href="{{url('privacy_policy')}}">{{web('Privacy Policy')}}</a></li>
                        <li><a href="{{url('terms_of_use')}}">{{web('Terms of Use')}}</a></li>
                        <li><a href="{{url('client_terms')}}">{{web('Client Terms')}}</a></li>
                        <li><a href="{{url('our_profile')}}">{{web('Our Profile')}}</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h3 class="title-footer font-bold">{{web('Top Countries')}}</h3>
                    <ul class="link-footer menu">
                        <!--<li><a href="">{{web('Palestine')}}</a></li>-->
                        <!--<li><a href="">{{web('Egypt')}}</a></li>-->
                        <li><a href="">{{web('United Arab Emirates')}}</a></li>
                        <!--<li><a href="">{{web('Saudi Arabia')}}</a></li>-->
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h3 class="title-footer font-bold">{{web('Install App')}}</h3>
                    <div class="d-flex flex-lg-column flex-row">
                        <a class="mb-lg-3 mr-lg-0 mr-3 hover-scale" href="{{getSetting('app_store')}}"><img
                                src="{{asset('assets/images/App-Store.png')}}" alt=""/></a><a
                            class="hover-scale"
                            href="{{getSetting('google_paly')}}"><img
                                src="{{asset('assets/images/Google-Play.png')}}" alt=""/></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center text-lg-right">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-auto">
                    <p>{{getSetting('email')}}</p>
                </div>
                <div class="col-lg-auto my-3 my-lg-0">
                    <p><a href="{{getSetting('Copyright_link')}}">{{getSetting('copyrights')}}</a></p>
                </div>
                <div class="col-lg-auto">
                    <ul class="social-media justify-content-center justify-content-lg-end">
                        @if (getSetting('facebook'))
                            <li>
                                <a class="fa" href="{{getSetting('facebook')}}"><i class="fab fa-facebook-f"></i></a>
                            </li>
                        @endif
                        @if (getSetting('instagram'))
                            <li>
                                <a class="in" href="{{getSetting('instagram')}}"> <i class="fab fa-instagram"></i></a>
                            </li>
                        @endif
                        @if (getSetting('tiktok'))
                            <li>
                                <a class="ti" href="{{getSetting('tiktok')}}"><i class="fab fa-tiktok"></i></a>
                            </li>
                        @endif
                        @if (getSetting('linkedin'))
                            <li>
                                <a class="li" href="{{getSetting('linkedin')}}"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                        @endif
                        @if (getSetting('whatsapp'))
                            <li>
                                <a class="wh" href="{{getSetting('whatsapp')}}"><i class="fab fa-whatsapp"></i></a>
                            </li>
                        @endif
                        @if (getSetting('twitter'))
                            <li>
                                <a class="tw" href="{{getSetting('twitter')}}"><i class="fab fa-twitter"></i></a>
                            </li>
                        @endif
                        @if (getSetting('youtube'))
                            <li style=" margin-right: 11px;">
                                <a class="yo" href="{{getSetting('youtube')}}"><i class="fab fa-youtube"></i></a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end:: main-footer -->
