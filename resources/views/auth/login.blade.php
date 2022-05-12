@extends('layouts.website')

@section('content')

    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')

        <div class="page-content">
            <section class="section-login full-height">
                <div class="row no-gutters h-100 full-height">
                    <div class="col-lg-6 d-none d-lg-block">
                        <div
                            class="login-aside bg-login-1 h-100 d-flex flex-column justify-content-center align-items-center"></div>
                    </div>
                    <div class="col-lg-6 pb-10 pt-14 py-lg-0">
                        <div class="login-container h-100">
                            <div class="login-form h-100 d-flex flex-column justify-content-center">
                                <div class="row">
                                    <div class="col-lg-8 mx-auto">
                                        <div class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
                                            @if (request()->type)
                                                <img class="mb-3" src="{{url('local/public')}}/assets/images/logo_2.svg"
                                                     alt="">
                                            @endif
                                            <h2 class="mb-2 h1 font-bold">{{web('Login')}} </h2>
                                            <h3 class="text_muted mb-7">{{web('Login Lorem ipsum dolor sit amet, consectetur.')}}</h3>
                                        </div>
                                        @if(session()->has('message'))
                                            <p class="alert alert-info">
                                                {{ session()->get('message') }}
                                            </p>
                                        @endif

                                        <form action="{{ route('login') }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-4 wow fadeInUp" data-wow-delay="0.3s">
                                                <div class="input-wrapper">
                                                    <input
                                                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                        type="email" name="email" value="{{ old('email', null) }}">
                                                    @if($errors->has('email'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('email') }}
                                                        </div>
                                                    @endif
                                                    <label>{{ trans('global.login_email') }}</label>
                                                </div>
                                            </div>


                                            <div class="form-group wow fadeInUp" data-wow-delay="0.4s">
                                                <div class="input-wrapper">
                                                    <input
                                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                        name="password" type="password">
                                                    @if($errors->has('password'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('password') }}
                                                        </div>
                                                    @endif
                                                    <label>{{ trans('global.login_password') }}</label>
                                                </div>
                                            </div>
                                            <div class="form-group wow fadeInUp" data-wow-delay="0.5s">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label class="m-checkbox mb-0"> <input type="checkbox"
                                                                                           name="remember"><span
                                                            class="checkmark"></span>{{ trans('global.remember_me') }}
                                                    </label>
                                                    <h5><a href="{{url('/password/reset')}}"
                                                           class="text_dark">{{web('Forgot Password?')}}</a></h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group my-4 wow fadeInUp" data-wow-delay="0.6s">
                                                        <button class="btn btn-block btn-primary font-medium rounded_sm"
                                                                type="submit">{{ trans('global.login') }}</button>
                                                    </div>
                                                </div>
                                                @if (request()->type)
                                                    <div class="col-lg-6">
                                                        <div class="form-group my-4 wow fadeInUp" data-wow-delay="0.6s">
                                                            <a href="{{url('loop_join')}}"
                                                               class="btn btn-block btn-outline-primary font-medium rounded_sm">{{web('Join Us')}}</a>
                                                        </div>
                                                    </div>
                                                @endif

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


        @include('partials.footer')

    </div>
    <!-- end:: Page -->
@endsection


