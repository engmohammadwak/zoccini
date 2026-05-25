<!-- begin:: Header -->
<style>
.dropdown-user > a {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    text-decoration: none;
}
.dropdown-user .username {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #27BA4D;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    flex-shrink: 0;
    letter-spacing: 0.5px;
    line-height: 1;
}
.dropdown-user > a i {
    font-size: 12px;
    color: #444;
    margin-top: 1px;
}
.dropdown-user .dropdown-menu {
    min-width: 160px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.10);
    padding: 6px 0;
    margin-top: 8px !important;
}
.dropdown-user .dropdown-menu .dropdown-item {
    padding: 9px 18px;
    font-size: 14px;
    color: #18191F;
    border-radius: 0;
    transition: background .15s ease;
}
.dropdown-user .dropdown-menu .dropdown-item:hover {
    background-color: #f0fdf4;
    color: #27BA4D;
}
</style>
<header class="main-header">
    <div class="container px-lg-0">
        <div class="d-flex align-items-center">
            <div class="logo mr-lg-4">
                <a href="{{url('/')}}"><img src="{{asset('assets/images/logo.svg')}}" alt=""/></a>
            </div>
            <div class="menu--mobile mx-lg-auto">
                <div class="menu-container d-lg-none">
                    <div class="btn-close-header-mobile justify-content-end"><i class="fas fa-times"></i></div>
                </div>
                <div class="menu-container">
                    <ul class="main-menu list-main-menu">
                        <li class="menu_item"><a class="menu_link active" href="{{url('/')}}#section-about"
                                                 data-scroll="section-about">{{web('About')}}</a></li>
                        <li class="menu_item"><a class="menu_link" href="{{url('/')}}#section-works"
                                                 data-scroll="section-works">{{web('How it works')}}</a></li>
                        <li class="menu_item"><a class="menu_link" href="{{url('/')}}#section-restaurants"
                                                 data-scroll="section-restaurants">{{web('Top Restaurants')}}</a></li>
                        <li class="menu_item"><a class="menu_link" href="{{url('/')}}#section-become"
                                                 data-scroll="section-become">{{web('Become a partner')}}</a></li>
                        <li class="menu_item"><a class="menu_link" href="{{url('/')}}#section-partners"
                                                 data-scroll="section-partners">{{web('Our Partners')}}</a></li>
                        <li class="menu_item"><a class="menu_link" href="{{url('/map')}}">{{web('Map')}}</a></li>

                    </ul>
                </div>
                @if(\Illuminate\Support\Facades\Auth::user())
                    <div class="menu-container ml-lg-auto mt-4 mt-lg-0">
                        <ul class="main-menu d-lg-flex align-items-lg-center">
                            <li class="menu_item dropdown dropdown-user pl-4 pl-lg-0">
                                <a class="d-flex align-items-center" data-toggle="dropdown" href="">
                                    <span class="username font-medium">{{substr(\Illuminate\Support\Facades\Auth::user()['name'], 0, 2)}}</span><i class="far fa-chevron-down fa-md text-dark ml-2"></i>
                                </a>
                                <div class="dropdown-menu mt-3 border-0" aria-labelledby="dropdownMenuButton">

                                    @if (\Illuminate\Support\Facades\Auth::user()['user_type'] == 12)
                                        <a class="dropdown-item" href="{{url('lhome')}}">{{web('HOME')}}</a>
                                        <a class="dropdown-item" href="{{url('history')}}">{{web('History')}}</a>
                                        <a class="dropdown-item" href="{{url('profile')}}">{{web('My Profile')}}</a>
                                    @else
                                        <a class="dropdown-item" href="{{url('/home')}}">{{web('HOME')}}</a>
                                    @endif
                                    <a class="dropdown-item" href=""  onclick="event.preventDefault(); document.getElementById('logoutform').submit();">{{web('Log out')}}</a>
                                </div>
                            </li>
                        </ul>
                    </div>

                @else
                    <div class="menu-container ml-lg-auto mt-5 mt-lg-0">
                        <ul class="main-menu d-lg-flex align-items-lg-center">
                            <li class="menu_item"><a class="btn btn-outline-primary btn-sm" href="{{url('login')}}">{{web('Login')}}</a></li>
                            <li class="menu_item mx-lg-3"><a class="btn btn-primary btn-sm"
                                                             href="{{url('plan')}}">{{web('Sign up')}}</a></li>
                        </ul>
                    </div>

                @endif

                <li class="menu_item" style="list-style: none;">
                    <button class="btn-lang btn btn-sm" type="button" data-toggle="dropdown" style="color: #6c6d71;"
                            aria-haspopup="true" aria-expanded="false">
                        {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'Ar' : 'En' }}
                        <svg class="ml-2" width="9" height="6" viewBox="0 0 9 6" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.57164 1.75458L4.79346 5.00195L8 1.73927" stroke="#333333"
                                  stroke-width="1.5" stroke-linecap="round"
                                  stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <div class="dropdown-menu box_shadow border-0 dropdown-lang"><a
                            class="dropdown-item" href="{{\Illuminate\Support\Facades\App::getLocale() == 'ar' ?  url()->current().'?change_language=en' : url()->current().'?change_language=ar'  }}">
                            {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'En' : 'Ar' }}

                        </a></div>
                </li>
            </div>
            <div class="header-mobile__toolbar ml-auto d-lg-none">
                <svg width="25" height="16" viewBox="0 0 33 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="33" y1="0.5" x2="-4.37115e-08" y2="0.499997" stroke="#0D3334"></line>
                    <line x1="33" y1="8.5" x2="-4.37115e-08" y2="8.5" stroke="#0D3334"></line>
                    <line x1="33" y1="15.5" x2="16" y2="15.5" stroke="#0D3334"></line>
                </svg>
            </div>
        </div>
    </div>
</header>
<!-- end:: Header -->

<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
