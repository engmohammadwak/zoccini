@extends('layouts.website')
@section('content')
<style>
    .hide{
        display:none;
    }
</style>

{{--<script type="text/javascript">--}}
{{--    var options = {--}}
{{--        "reference_token": "REFERENCE_TOKEN",--}}
{{--        "merchant_key": "test_$2y$10$pzoPoGLc5l6qRhcSUN4-ReP.DLFnxErxTBZOLEwBaSw5kuF0u-eye"--}}
{{--    }--}}
{{--    var fp1 = new Foloosipay(options);--}}
{{--</script>--}}
{{--<script type="text/javascript" src="https://www.foloosi.com/js/foloosipay.v2.js"></script>--}}


    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')
        <div class="progress progress-step">
            <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="page-content">
            <div class="container">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 overflow-hidden">
                                <form action="{{url('/become_partner_store')}}" method="post" class="form-login" id="my_form" enctype="multipart/form-data">
                                    @csrf
                                  <input type="hidden" name="id" value="{{request()->get('id')}}">
                                    <h3>Account</h3>
                                    <section>
                                        <div class="row mb-4 mb-lg-5">
                                            <div class="col-lg-5">
                                                <h2 class="title-section font-bold mb-2">{{web('Become a Partner')}}</h2>
                                                <h5 class="text_muted">{{web('Become a Partner Lorem Personal Information')}}</h5>
                                                <h2 class="sub-title text_muted mt-5">{{web('Personal Information')}}</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('first_name') is-invalid @enderror" name="first_name" type="text" value="{{ old('first_name', '') }}" />
                                                        <label>{{web('first name')}}</label>
                                                        @error('first_name')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('last_name') is-invalid @enderror" name="last_name" type="text" value="{{ old('last_name', '') }}"/>
                                                        <label>{{web('Last name')}}</label>
                                                        @error('last_name')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{ old('email', '') }}"/>
                                                        <label>{{web('Personal email')}} </label>
                                                        @error('email')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input  class="form-control @error('phone') is-invalid @enderror" type="text" style="direction: ltr;width: 446px" id="phone" name="phone" value="{{ old('phone', '') }}"/>
                                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                                        <span id="error-msg" class="hide"></span>
                                                        {{--                                                        <label>{{web('Mobile No')}} </label>--}}
                                                        @error('phone')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
{{--                                                <div class="form-group">--}}
{{--                                                    <div class="input-wrapper">--}}
{{--                                                        <div class="input-group-prepend mr-1 col-auto">--}}
{{--                                                            <select class="selectpicker select-country" name="country_code" data-size="4" data-style="btn_white" data-width="110px">--}}
{{--                                                                <option value="970" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+970</span>"> </option>--}}
{{--                                                                <option value="972" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+972</span>"> </option>--}}
{{--                                                                <option value="966" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+966</span>"> </option>--}}
{{--                                                                <option value="963" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+963</span>"> </option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                            <input class="form-control @error('phone') is-invalid @enderror" id="phone" type="text" name="phone" value="{{ old('phone', '') }}"/>--}}
{{--                                                            <label>{{web('Mobile No')}}</label>--}}
{{--                                                            @error('phone')--}}
{{--                                                            <div--}}
{{--                                                                class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>--}}
{{--                                                            @enderror--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{ old('password', '') }}"/>
                                                        <label>{{web('Password')}} </label>
                                                        @error('password')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>{{web('Account')}}</h3>
                                    <section>
                                        <div class="row mb-4 mb-lg-5">
                                            <div class="col-lg-5">
                                                <h2 class="title-section font-bold mb-2">{{web('Become a Partner')}}</h2>
                                                <h5 class="text_muted">{{web('Become a Partner Lorem Business Information')}}</h5>
                                                <h2 class="sub-title text_muted mt-5 font-semiBold">{{web('Business Information')}}</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('name_ar') is-invalid @enderror" type="text" name="name_ar" value="{{ old('name_ar', '') }}"/>
                                                        <label>{{web('Restaurant name')}}</label>
                                                        @error('name_ar')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address', '') }}"/>
                                                        <label>{{web('Address')}}</label>
                                                        @error('address')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('company_email') is-invalid @enderror" type="text" name="company_email" value="{{ old('company_email', '') }}"/>
                                                        <label>{{web('Company Email')}}</label>
                                                        @error('company_email')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
{{--                                                <div class="form-group form-phone">--}}
{{--                                                    <div class="input-group phone row no-gutters">--}}
{{--                                                        <div class="input-group-prepend mr-1 col-auto">--}}
{{--                                                            <select class="selectpicker select-country" name="country_code_company" data-size="4" data-style="btn_white" data-width="110px">--}}
{{--                                                                <option value="970" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+970</span>"> </option>--}}
{{--                                                                <option value="972" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+972</span>"> </option>--}}
{{--                                                                <option value="966" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+966</span>"> </option>--}}
{{--                                                                <option value="963" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+963</span>"> </option>--}}
{{--                                                            </select>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="col">--}}
{{--                                                            <input class="form-control mb-0 @error('phone_company') is-invalid @enderror" type="text" name="phone_company" value="{{ old('phone_company', '') }}"/>--}}
{{--                                                            <label>{{web('Mobile No.')}}</label>--}}
{{--                                                            @error('phone_company')--}}
{{--                                                            <div--}}
{{--                                                                class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>--}}
{{--                                                            @enderror--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('phone_company') is-invalid @enderror" type="text" style="direction: ltr;width: 446px"  name="phone_company" id="phone_company" value="{{ old('phone_company', '') }}"/>
                                                        <span id="valid-msg_phone" class="hide">✓ Valid</span>
                                                        <span id="error-msg_phone" class="hide"></span>
                                                        @error('phone_company')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group row no-gutters">
                                                        <div class="input-group-prepend mr-1 col-auto input-upload">
                                                            <label class="input-group-label mb-0" for="upload_1">
                                                                {{web('Upload')}}
                                                                <input class="form-control uploadeImage @error('logo') is-invalid @enderror" name="logo" accept="image/x-png,image/gif,image/jpeg , application/pdf" type="file" id="upload_1" value="{{ old('logo', '') }}"/>
                                                            </label>
                                                        </div>
                                                        <div class="col">
                                                            <span class="form-control"></span>
                                                            <label class="name-image"> {{web('Restaurant Logo')}}</label>
                                                        </div>
                                                        @error('logo')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group row no-gutters">
                                                        <div class="input-group-prepend mr-1 col-auto input-upload">
                                                            <label class="input-group-label mb-0" for="upload_2">
                                                                {{web('Upload')}}
                                                                <input class="form-control uploadeImage @error('restaurant_licence') is-invalid @enderror" name="restaurant_licence" accept="image/x-png,image/gif,image/jpeg , application/pdf" type="file" id="upload_2" value="{{ old('restaurant_licence', '') }}"/>
                                                            </label>
                                                        </div>
                                                        <div class="col">
                                                            <span class="form-control"></span>
                                                            <label class="name-image">{{web('Restaurant licence')}}</label>
                                                        </div>
                                                        @error('restaurant_licence')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
{{--                                                <div class="form-group text-right">--}}
{{--                                                    <div class="bg-white btn-link font-bold color-primary my-2 goStepBransh pointer">--}}
{{--                                                        {{web('Add a Branch')}}--}}
{{--                                                        <svg class="mr-1" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                            <path--}}
{{--                                                                    d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"--}}
{{--                                                                    fill="#27BA4D"--}}
{{--                                                            ></path>--}}
{{--                                                        </svg>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Account</h3>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="d-flex align-items-center justify-content-between my-5">
                                                    <h2 class="fnot-size-32 text_muted font-semiBold">Branches</h2>
                                                    <button class="bg-white btn-link font-bold color-primary add-branch" type="button">
                                                        {{web('Add a Branch')}}
                                                        <svg class="mr-1" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"
                                                                fill="#27BA4D"
                                                            ></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <div class="widget-list-add-branch">
                                                    <div class="bg-gray rounded_lg p-3 p-lg-4 mb-4 widget-add-branch">
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input class="branch-name form-control" name="branchName" type="text" />
                                                                <label>{{web('Branch name')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <div class="input-icon right">
                                                                    <input class="branch-address form-control" id="address" name="branchAddress" type="text"/>
                                                                    <label>{{web('Location')}}</label>
                                                                    <div class="icon pointer">
                                                                        <a class="click">
                                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M0.310364 9.93109H1.92412C2.34819 13.1326 4.86736 15.6518 8.06891 16.0759V17.6896C8.06946 17.8609 8.20816 17.9995 8.37927 18H9.62073C9.79184 17.9995 9.93054 17.8609 9.93109 17.6896V16.0759C13.1326 15.6518 15.6518 13.1326 16.0759 9.93109H17.6896C17.8609 9.93054 17.9995 9.79184 18 9.62073V8.37927C17.9995 8.20816 17.8609 8.06946 17.6896 8.06891H16.0759C15.6518 4.86736 13.1326 2.34819 9.93109 1.92412V0.310364C9.93054 0.139114 9.79184 0.000549316 9.62073 0H8.37927C8.20816 0.000549316 8.06946 0.139114 8.06891 0.310364V1.92412C4.86736 2.34819 2.34819 4.86736 1.92412 8.06891H0.310364C0.139114 8.06946 0.000549316 8.20816 0 8.37927V9.62073C0.000549316 9.79184 0.139114 9.93054 0.310364 9.93109ZM9 3.72409C11.9137 3.72409 14.2759 6.08629 14.2759 9C14.2759 11.9137 11.9137 14.2759 9 14.2759C6.08629 14.2759 3.72409 11.9137 3.72409 9C3.72821 6.08794 6.08794 3.72821 9 3.72409Z" fill="#27BA4D"/>
                                                                            <path d="M11.4831 9.00035C11.4831 10.3716 10.3716 11.4831 9.00035 11.4831C7.62912 11.4831 6.51758 10.3716 6.51758 9.00035C6.51758 7.62912 7.62912 6.51758 9.00035 6.51758C10.3716 6.51758 11.4831 7.62912 11.4831 9.00035Z" fill="#27BA4D"/>
                                                                        </svg>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
{{--                                                        <div class="form-group form-phone">--}}
{{--                                                            <div class="input-group row no-gutters">--}}
{{--                                                                <div class="input-group-prepend mr-1 col-auto branch-state">--}}
{{--                                                                    <select class="selectpicker select-country" data-style="btn_white" data-width="110px">--}}
{{--                                                                        <option value="970" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+970</span>"> </option>--}}
{{--                                                                        <option value="972" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+972</span>"> </option>--}}
{{--                                                                        <option value="966" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+966</span>"> </option>--}}
{{--                                                                        <option value="963" data-content="<span><img src='{{url('local/public')}}/assets/images/flag.svg'></span><span class='ml-1 number'>+963</span>"> </option>--}}
{{--                                                                    </select>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col">--}}
{{--                                                                    <input class="branch-mobile form-control" name="branchMobile" type="text" />--}}
{{--                                                                    <label>{{web('Mobile No.')}}</label>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input class="form-control @error('branchMobile') is-invalid @enderror" type="text" style="direction: ltr;width: 397px"  name="branchMobile" id="branch_mobile" value="{{ old('branchMobile', '') }}"/>
                                                                <span id="valid-msg_branch_mobile" class="hide">✓ Valid</span>
                                                                <span id="error-msg_branch_mobile" class="hide"></span>
                                                                @error('branchMobile')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group text-center mb-0">
                                                            <button class="btn btn-primary add-item-branch" type="button">{{web('Add')}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-list-items-branch"></div>
                                            </div>
                                            <div class="col-lg-6 pl-lg-5">
                                                <div id="map_2"></div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Account</h3>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <h2 class="title-section font-bold mb-2">{{web('Become a Partner')}}</h2>
                                                <h5 class="text_muted">{{web('Take advantage of our suitable tablet device as an optional solution.')}}</h5>
                                                <h2 class="sub-title text_muted mt-5 font-semiBold">{{web('Almost Done!')}}</h2>
                                                <h4 class="fnot-size-22 text_muted mt-4 mb-4 font-semiBold">{{web('Do you have a tablet ?')}}</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="form-group d-flex flex-column @error('have_tablet') is-invalid @enderror">
                                                    <label class="m-radio mb-1 font-medium"> <input type="radio" name="have_tablet"  value="yes" {{ old('have_tablet', '') == 'yes' ? 'checked' : '' }}/><span class="checkmark"></span>{{web('yes, I have one ')}}</label>
                                                    <label class="m-radio mb-0 font-medium"> <input type="radio" name="have_tablet" value="no" {{ old('have_tablet', '') == 'no' ? 'checked' : '' }}/><span class="checkmark"></span>{{web('No, I want one ')}}</label>
                                                    @error('have_tablet')
                                                    <div
                                                        class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-5 @error('password') is-invalid @enderror">
                                                    <label class="m-checkbox mb-0 font-medium d-flex"> <input type="checkbox" name="agree" value="yes" {{ old('agree', '') == 'yes' ? 'checked' : '' }}/><span class="checkmark"></span>{{web('I agree to')}} <a href="{{url('/terms_of_use')}}" target="_blank" class="pl-1"> {{web('Terms and Conditions')}} </a> </label>
                                                    @error('branch_no')
                                                    <div
                                                        class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </form>
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

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&sensor=false&libraries=places"></script>

    <script>
        function initialize() {
            var latlng = new google.maps.LatLng('24.713552', '46.675297');
            var map = new google.maps.Map(document.getElementById('map_2'), {
                center: latlng,
                zoom: 10
            });
            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: true,
                anchorPoint: new google.maps.Point(0, -29),
                icon: "{{url('local/public')}}/assets/images/zoccini.svg"
            });
            var input = document.getElementById('searchInput');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            var geocoder = new google.maps.Geocoder();
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            var infowindow = new google.maps.InfoWindow();
            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                bindDataToForm(place.formatted_address, place.geometry.location.lat(), place.geometry.location.lng());
                infowindow.setContent(place.formatted_address);
                infowindow.open(map, marker);

            });
            // this function will work on marker move event into map
            google.maps.event.addListener(marker, 'dragend', function () {
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            bindDataToForm(results[0].formatted_address, marker.getPosition().lat(), marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });
            });
        }

        function bindDataToForm(address, lat, lng) {
            document.getElementById('address').value = address;
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;

        }

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
{{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXFAxSgXP7b5D25WEtjxkYqoWM2PjxaLg&callback=initMap&libraries=places"async defer></script>--}}
{{--    <script>--}}
{{--        var marker;--}}
{{--        var map--}}
{{--        // Initialize and add the map--}}
{{--        function initMap() {--}}
{{--            // The location of Uluru--}}
{{--            var uluru = { lat: 32.5035911, lng: 35.4652862 };--}}
{{--            // The map, centered at Uluru--}}
{{--            map = new google.maps.Map(document.getElementById("map_2"), {--}}
{{--                zoom: 15,--}}
{{--                center: uluru,--}}
{{--            });--}}
{{--            // The marker, positioned at Uluru--}}
{{--            marker = new google.maps.Marker({--}}
{{--                position: uluru,--}}
{{--                map: map,--}}
{{--                draggable: true,--}}
{{--                animation: google.maps.Animation.DROP,--}}
{{--                --}}{{--icon: "{{url('local/public')}}/assets/images/marker_3.svg",--}}
{{--                icon: "{{url('local/public')}}/assets/images/zoccini.svg",--}}
{{--            });--}}
{{--        }--}}


{{--        $(".click").click(function() {--}}
{{--            if (navigator.geolocation) {--}}
{{--                navigator.geolocation.getCurrentPosition(function(position) {--}}
{{--                    var pos = {--}}
{{--                        lat: position.coords.latitude,--}}
{{--                        lng: position.coords.longitude--}}
{{--                    };--}}

{{--                    alert(position.coords.address)--}}
{{--                    map.setCenter(pos);--}}
{{--                    marker.setPosition(pos);--}}
{{--                        currgeocoder.geocode({--}}
{{--                            'location': new google.maps.LatLng(position.coords.latitude, position.coords.longitude)--}}

{{--                        }, function (results, status) {--}}
{{--                            if (status == google.maps.GeocoderStatus.OK) {--}}
{{--                                console.log('map :'+results[0]);--}}
{{--                                console.log('lat :'+results[0]);--}}
{{--                                $("#address").val(results[0].formatted_address);--}}
{{--                            } else {--}}
{{--                                alert('Geocode was not successful for the following reason: ' + status);--}}
{{--                            }--}}
{{--                        });--}}

{{--                }, function() {--}}
{{--                    //    handleLocationError(true, infoWindow, map.getCenter());--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}

    <script>
        /*------------------------------------
            Add Branch On click
        --------------------------------------*/
        $(document).on("click", ".add-payment", function () {
            if ($(".widget-item-payment").length > 0 || $(".widget-item-payment").length == 0) {
                $(".widget-list-add-payment").fadeIn();
                $( ".widget-list-add-payment .form-control" ).prop( "disabled", false );
                animateLable();
            }
        });

        /*------------------------------------
              Add Item Branch On click
          --------------------------------------*/
        $(document).on("click", ".add-item-payment", function () {
            var $cardNumber = $(".card-number").val();
            var $expDate = $(".exp-date").val();
            var $cvv = $(".cvv").val();
            if ($(".card-number").val() == "" || $(".exp-date").val() == "" || $(".cvv").val() == "") {
                $(".widget-add-payment .required").remove();
                $(".widget-add-payment").append(`<span class="text-danger required ml-2">{{web('This All field is required.')}}</span>`);
            }
            else {
                if ($(".widget-add-payment").find(".form-group.error").length > 0) {

                }else{
                    $(".widget-add-payment .required").remove();
                    $(".widget-list-items-payment").append(`
                  <div class="widget-item-card d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <svg class="mr-3" width="40" height="26" viewBox="0 0 40 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M25.2784 4.53027H14.7266V21.4677H25.2784V4.53027Z" fill="#FF5F00"/>
                        <path d="M15.8154 13C15.8141 11.3691 16.1903 9.75921 16.9155 8.29227C17.6407 6.82533 18.696 5.53974 20.0014 4.53278C18.3846 3.284 16.4429 2.50747 14.3982 2.29191C12.3536 2.07636 10.2884 2.43049 8.4389 3.31383C6.58935 4.19717 5.02999 5.57408 3.93903 7.2872C2.84807 9.00031 2.26953 10.9805 2.26953 13.0015C2.26953 15.0224 2.84807 17.0026 3.93903 18.7158C5.02999 20.4289 6.58935 21.8058 8.4389 22.6891C10.2884 23.5725 12.3536 23.9266 14.3982 23.711C16.4429 23.4955 18.3846 22.719 20.0014 21.4702C18.6956 20.4629 17.6401 19.1768 16.9148 17.7093C16.1896 16.2418 15.8136 14.6314 15.8154 13Z" fill="#EB001B"/>
                        <path d="M37.7296 13.0003C37.7295 15.0214 37.1508 17.0018 36.0597 18.7149C34.9685 20.4281 33.4089 21.805 31.5591 22.6882C29.7094 23.5714 27.6441 23.9253 25.5993 23.7095C23.5545 23.4936 21.6128 22.7167 19.9961 21.4675C21.301 20.4597 22.356 19.1737 23.0814 17.7067C23.8068 16.2397 24.1837 14.6299 24.1837 12.9988C24.1837 11.3677 23.8068 9.75796 23.0814 8.29094C22.356 6.82392 21.301 5.53797 19.9961 4.53011C21.6128 3.28095 23.5545 2.50404 25.5993 2.28818C27.6441 2.07232 29.7094 2.42622 31.5591 3.30943C33.4089 4.19265 34.9685 5.56953 36.0597 7.2827C37.1508 8.99587 37.7295 10.9762 37.7296 12.9973V13.0003Z" fill="#F79E1B"/>
                      </svg>
                      <p>${$cvv}</p>
                    </div>
                    <div class="d-flex align-items-center">
                      <p>${$expDate}</p>
                      <button class="btn-delete-payment ml-4">{{web('Delete')}}</button>
                    </div>
                  </div>
                `);
                    $(".widget-list-add-payment").fadeOut(70);
                    $(".widget-list-items-payment .widget-item-payment").last().hide().fadeIn(800);
                    var $cardNumber = $(".card-number").val("");
                    var $expDate = $(".exp-date").val("");
                    var $cvv = $(".cvv").val("");
                    $( ".widget-list-add-payment .form-control" ).prop( "disabled", true );
                    if ($(".widget-item-branch").length > 1) {
                        var height = $(".step-four .content-step").height();
                        $(".wrapper-step").css("height", height);
                    }
                }
            }
        });

        /*------------------------------------
              Remove Item Branch On click
          --------------------------------------*/
        $(document).on("click", ".delete-item-payment", function () {
            $(this)
                .closest(".widget-item-payment")
                .fadeOut(300, function () {
                    $(this).remove();
                });
        });
    </script>

    <script>
        var input_phone = document.querySelector("#phone_company"),
            errorMsg1 = document.querySelector("#error-msg_phone"),
            validMsg1 = document.querySelector("#valid-msg_phone");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap1 = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        // initialise plugin
        var iti1 = window.intlTelInput(input_phone, {
            initialCountry: "auto",
            autoHideDialCode:false,
            nationalMode:false,


            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        var reset1 = function() {
            input_phone.classList.remove("error");
            errorMsg1.innerHTML = "";
            errorMsg1.classList.add("hide");
            validMsg1.classList.add("hide");
        };

        // on blur: validate
        input_phone.addEventListener('blur', function() {
            reset1();
            if (input_phone.value.trim()) {
                if (iti1.isValidNumber()) {
                    validMsg1.classList.remove("hide");
                } else {
                    input_phone.classList.add("error");
                    var errorCode1 = iti1.getValidationError();
                    errorMsg1.innerHTML = errorMap1[errorCode1];
                    errorMsg1.classList.remove("hide");
                }
            }
        });

        // on keyup / change flag: reset
        input_phone.addEventListener('change', reset1);
        input_phone.addEventListener('keyup', reset1);
    </script>


    <script>
        var input_branch_mobile = document.querySelector("#branch_mobile"),
            errorMsg2 = document.querySelector("#error-msg_branch_mobile"),
            validMsg2 = document.querySelector("#valid-msg_branch_mobile");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap2 = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        // initialise plugin
        var iti2 = window.intlTelInput(input_branch_mobile, {
            initialCountry: "auto",
            autoHideDialCode:false,
            nationalMode:false,


            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        var reset2 = function() {
            input_branch_mobile.classList.remove("error");
            errorMsg2.innerHTML = "";
            errorMsg2.classList.add("hide");
            validMsg2.classList.add("hide");
        };

        // on blur: validate
        input_branch_mobile.addEventListener('blur', function() {
            reset2();
            if (input_branch_mobile.value.trim()) {
                if (iti2.isValidNumber()) {
                    validMsg2.classList.remove("hide");
                } else {
                    input_branch_mobile.classList.add("error");
                    var errorCode2 = iti2.getValidationError();
                    errorMsg2.innerHTML = errorMap2[errorCode2];
                    errorMsg2.classList.remove("hide");
                }
            }
        });

        // on keyup / change flag: reset
        input_branch_mobile.addEventListener('change', reset2);
        input_branch_mobile.addEventListener('keyup', reset2);
    </script>
@endsection

@section('scripts_new')
    <script>
        var input_phone = document.querySelector("#phone_company"),
            errorMsg1 = document.querySelector("#error-msg_phone"),
            validMsg1 = document.querySelector("#valid-msg_phone");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap1 = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        // initialise plugin
        var iti1 = window.intlTelInput(input_phone, {
            initialCountry: "auto",
            autoHideDialCode:false,
            nationalMode:false,

            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        var reset1 = function() {
            input_phone.classList.remove("error");
            errorMsg1.innerHTML = "";
            errorMsg1.classList.add("hide");
            validMsg1.classList.add("hide");
        };

        // on blur: validate
        input_phone.addEventListener('blur', function() {
            reset1();
            if (input_phone.value.trim()) {
                if (iti1.isValidNumber()) {
                    validMsg1.classList.remove("hide");
                } else {
                    input_phone.classList.add("error");
                    var errorCode1 = iti1.getValidationError();
                    errorMsg1.innerHTML = errorMap1[errorCode1];
                    errorMsg1.classList.remove("hide");
                }
            }
        });

        // on keyup / change flag: reset
        input_phone.addEventListener('change', reset1);
        input_phone.addEventListener('keyup', reset1);
    </script>
    <script>
        var input_branch_mobile = document.querySelector("#branch_mobile"),
            errorMsg2 = document.querySelector("#error-msg_branch_mobile"),
            validMsg2 = document.querySelector("#valid-msg_branch_mobile");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap2 = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        // initialise plugin
        var iti2 = window.intlTelInput(input_branch_mobile, {
            initialCountry: "auto",
            autoHideDialCode:false,
            nationalMode:false,


            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        var reset2 = function() {
            input_branch_mobile.classList.remove("error");
            errorMsg2.innerHTML = "";
            errorMsg2.classList.add("hide");
            validMsg2.classList.add("hide");
        };

        // on blur: validate
        input_branch_mobile.addEventListener('blur', function() {
            reset2();
            if (input_branch_mobile.value.trim()) {
                if (iti2.isValidNumber()) {
                    validMsg2.classList.remove("hide");
                } else {
                    input_branch_mobile.classList.add("error");
                    var errorCode2 = iti2.getValidationError();
                    errorMsg2.innerHTML = errorMap2[errorCode2];
                    errorMsg2.classList.remove("hide");
                }
            }
        });

        // on keyup / change flag: reset
        input_branch_mobile.addEventListener('change', reset2);
        input_branch_mobile.addEventListener('keyup', reset2);
    </script>
@endsection
