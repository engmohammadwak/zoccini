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
                                            <h2 class="mb-2 h1 font-bold">{{web('Forgot Password')}} </h2>
                                            <h3 class="text_muted mb-7">{{web('Forgot Password Lorem')}}</h3>
                                        </div>
                                        @if(session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('password.email') }}">
                                            @csrf
                                            <div class="form-group mb-4 wow fadeInUp" data-wow-delay="0.3s">
                                                <div class="input-wrapper">
                                                    <input  id="email" type="email"
                                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                            name="email" required autocomplete="email" autofocus   value="{{ old('email') }}">
                                                    <label>{{web('Email')}}</label>
                                                    @if($errors->has('email'))
                                                        <span class="text-danger">
                                                             {{ $errors->first('email') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="form-group my-4 wow fadeInUp" data-wow-delay="0.6s">
                                                        <button class="btn btn-block btn-primary font-medium rounded_sm"
                                                                type="submit">{{web('Send')}}</button>
                                                    </div>
                                                </div>
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
