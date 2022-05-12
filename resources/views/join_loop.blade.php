@extends('layouts.website')
@section('content')
    <style>
        .hide{
            display:none;
        }
    </style>
    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="loader-page"><span></span><span></span></div>
        <div class="mobile-menu-overlay"></div>
        @include('partials.header')

        <div class="progress progress-step">
            <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="25" aria-valuemin="0"
                 aria-valuemax="100"></div>
        </div>
        <div class="page-content">
            <div class="container">
                <section class="section wow fadeInUp" data-wow-delay="0.2s">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 overflow-hidden">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2 class="title-section font-bold mb-2">{{web('Join Us')}}</h2>
                                        <h5 class="text_muted">{{web('Lorem ipsum dolor sit amet, consectetur adipiscing elit. dimentum diam orci, orci feugiat cursus. Dictumst risus, sem gestas odio')}}</h5>
                                    </div>
                                </div>
                                <form action="{{url('/join_loop_post')}}" method="post" id="form_join" class="form-join"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <h3>{{web('Account')}}</h3>
                                    <section>
                                        <div class="row mb-4 mb-lg-5">
                                            <div class="col-lg-12">
                                                <h2 class="sub-title text_muted mt-5">{{web('Personal Information')}}</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('name') is-invalid @enderror"
                                                               value="{{ old('name', '') }}" name="name" type="text"/>
                                                        <label>{{web('First name')}}</label>
                                                        @error('name')
                                                        <div class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input
                                                            class="form-control @error('last_name') is-invalid @enderror"
                                                            value="{{ old('last_name', '') }}" name="last_name"
                                                            type="text"/>
                                                        <label>{{web('Last name')}}</label>
                                                        @error('last_name')
                                                        <div class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input
                                                            class="form-control @error('date_of_birth') is-invalid @enderror"
                                                            value="{{ old('date_of_birth', '') }}" name="date_of_birth"
                                                            type="date"/>
                                                        <label>{{web('Date of Birth')}}</label>
                                                        @error('date_of_birth')
                                                        <div class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{--                                                <div class="form-group">--}}
                                                {{--                                                    <select class="selectpicker custom_select border rounded" name="nationality" data-style="btn_white" title="nationality" data-width="100%">--}}
                                                {{--                                                        <option value="1">Gaza</option>--}}
                                                {{--                                                        <option value="2">Gaza</option>--}}
                                                {{--                                                        <option value="3">Gaza</option>--}}
                                                {{--                                                    </select>--}}
                                                {{--                                                </div>--}}
                                                <div class="form-group">
                                                    <select
                                                        class="selectpicker custom_select border rounded  @error('country_id') is-invalid @enderror"
                                                        name="country_id" data-style="btn_white" title="country"
                                                        data-width="100%">
                                                        @foreach($country as $value)
                                                            <option
                                                                value="{{$value->id}}" {{ old('country_id', '') == $value->id ? 'selected' : '' }}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('country_id')
                                                    <div class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <select
                                                        class="selectpicker custom_select border rounded @error('city_id') is-invalid @enderror"
                                                        name="city_id" data-style="btn_white" title="City"
                                                        data-width="100%">
                                                        @foreach($city as $value)
                                                            <option
                                                                value="{{$value->id}}" {{ old('city_id', '') == $value->id ? 'selected' : '' }}>{{$value->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('city_id')
                                                    <div class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('phone') is-invalid @enderror" type="text" style="width: 446px" id="phone" name="phone" value="{{ old('phone', '') }}"/>
                                                        <span id="valid-msg" class="hide">✓ Valid</span>
                                                        <span id="error-msg" class="hide"></span>
                                                        {{--                                                        <label>{{web('Mobile No')}} </label>--}}
                                                        @error('phone')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('email') is-invalid @enderror"
                                                               type="text" value="{{ old('email', '') }}" name="email"/>
                                                        <label>{{web('Email')}} </label>
                                                        @error('email')
                                                        <div
                                                            class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            type="password" value="{{ old('password', '') }}"
                                                            name="password"/>
                                                        <label>{{web('password')}} </label>
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
                                            <div class="col-lg-12">
                                                <h2 class="sub-title text_muted mt-5 font-semiBold">{{web('Payout method')}}</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="d-flex align-items-center justify-content-between my-5">
                                                    <div class="form-group mb-0 d-flex">
                                                        <label class="m-radio radio-card mb-1 font-medium"> <input
                                                                type="radio" class="radio_1" name="payment_type"
                                                                value="bank" checked/><span
                                                                class="checkmark"></span>{{web('Bank Account')}}</label>
                                                        <label class="m-radio radio-card mb-0 font-medium ml-4 ml-lg-5">
                                                            <input type="radio" class="radio_2" name="payment_type"
                                                                   value="cash"/><span
                                                                class="checkmark"></span>{{web('Cash')}}</label>
                                                    </div>
                                                    {{--                                                    <button class="bg-white btn-link font-bold color-primary add-bank"--}}
                                                    {{--                                                            type="button">--}}
                                                    {{--                                                        {{web('Add a Bank')}}--}}
                                                    {{--                                                        <svg class="mr-1" width="10" height="10" viewBox="0 0 10 10"--}}
                                                    {{--                                                             fill="none" xmlns="http://www.w3.org/2000/svg">--}}
                                                    {{--                                                            <path--}}
                                                    {{--                                                                d="M9.10714 4.10714H6.07143C5.97281 4.10714 5.89286 4.02719 5.89286 3.92857V0.892857C5.89286 0.39978 5.49308 0 5 0C4.50692 0 4.10714 0.39978 4.10714 0.892857V3.92857C4.10714 4.02719 4.02719 4.10714 3.92857 4.10714H0.892857C0.39978 4.10714 0 4.50692 0 5C0 5.49308 0.39978 5.89286 0.892857 5.89286H3.92857C4.02719 5.89286 4.10714 5.97281 4.10714 6.07143V9.10714C4.10714 9.60022 4.50692 10 5 10C5.49308 10 5.89286 9.60022 5.89286 9.10714V6.07143C5.89286 5.97281 5.97281 5.89286 6.07143 5.89286H9.10714C9.60022 5.89286 10 5.49308 10 5C10 4.50692 9.60022 4.10714 9.10714 4.10714Z"--}}
                                                    {{--                                                                fill="#27BA4D"></path>--}}
                                                    {{--                                                        </svg>--}}
                                                    {{--                                                    </button>--}}
                                                </div>
                                                <div class="widget-list-add-method">
                                                    <div class="bg-gray rounded_lg p-3 p-lg-4 mb-4 widget-add-method">
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input
                                                                    class="bank-name form-control @error('bank_name') is-invalid @enderror"
                                                                    name="bank_name"
                                                                    type="text" value="{{ old('bank_name', '') }}"/>
                                                                <label>{{web('bank name')}}</label>
                                                                @error('bank_name')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input
                                                                    class="swift-code form-control @error('swift_code') is-invalid @enderror"
                                                                    name="swift_code"
                                                                    type="text" value="{{ old('swift_code', '') }}"/>
                                                                <label>{{web('swift code')}} </label>
                                                                @error('swift_code')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input
                                                                    class="iban form-control @error('iban') is-invalid @enderror"
                                                                    name="iban"
                                                                    type="text" value="{{ old('iban', '') }}"/>
                                                                <label>{{web('IBAN')}}</label>
                                                                @error('iban')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-wrapper">
                                                                <input
                                                                    class="branch-no form-control @error('branch_no') is-invalid @enderror"
                                                                    name="branch_no"
                                                                    type="text" value="{{ old('branch_no', '') }}"/>
                                                                <label>{{web('Branch no.')}}</label>
                                                                @error('branch_no')
                                                                <div
                                                                    class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        {{--                                                        <div class="form-group text-center mb-0">--}}
                                                        {{--                                                            <button class="btn btn-primary add-item-method"--}}
                                                        {{--                                                                    type="button">{{web('Add')}}</button>--}}
                                                        {{--                                                        </div>--}}
                                                    </div>
                                                </div>
                                                <div class="widget-list-items-method"></div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>{{web('Account')}}</h3>
                                    <section>
                                        <div class="row mb-4 mb-lg-5">
                                            <div class="col-lg-12">
                                                <h2 class="sub-title text_muted mt-5 font-semiBold">{{web('ID Verification')}}</h2>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <div class="form-group d-flex">
                                                    <label class="m-radio mb-1 font-medium">
                                                        <input type="radio" name="verification_type"
                                                               value="national"
                                                               checked/><span
                                                            class="checkmark"></span>{{web('National ID')}} </label>
                                                    <label class="m-radio mb-0 font-medium ml-5"> <input type="radio"
                                                                                                         name="verification_type"
                                                                                                         value="passboard"/><span
                                                            class="checkmark"></span>{{web('Passboard ID')}} </label>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('national') is-invalid @enderror" type="text" name="national" value="{{ old('national', '') }}"/>
                                                        <label>{{web('National ID')}} </label>
                                                        @error('national')
                                                            <div
                                                                class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                    @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-wrapper">
                                                        <input class="form-control @error('expire_date') is-invalid @enderror" type="text" name="expire_date" value="{{ old('expire_date', '') }}"/>
                                                        <label>{{web('Expire Date')}} </label>
                                                        @error('expire_date')
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
                                                                <input class="form-control uploadeImage @error('attach_national') is-invalid @enderror" value="{{ old('attach_national', '') }}"
                                                                       name="attach_national"
                                                                       accept="image/x-png,image/gif,image/jpeg"
                                                                       type="file" id="upload_1"/>
                                                            </label>
                                                            @error('attach_national')
                                                            <div
                                                                class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col">
                                                            <span class="form-control"></span>
                                                            <label
                                                                class="name-image"> {{web('Attach your National ID')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group row no-gutters">
                                                        <div class="input-group-prepend mr-1 col-auto input-upload">
                                                            <label class="input-group-label mb-0" for="upload_2">
                                                                {{web('Upload')}}
                                                                <input class="form-control uploadeImage @error('invoice_image') is-invalid @enderror"
                                                                       name="invoice_image" value="{{ old('invoice_image', '') }}"
                                                                       accept="image/x-png,image/gif,image/jpeg"
                                                                       type="file" id="upload_2"/>
                                                            </label>
                                                            @error('invoice_image')
                                                            <div
                                                                class="invalid-feedback {{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? 'text-right' : 'text-left'}}"> {{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col">
                                                            <span class="form-control"></span>
                                                            <label
                                                                class="name-image"> {{web('Electricty or telephone invoice')}} </label>
                                                        </div>
                                                    </div>
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
    <script>
        var formJoin = $(".form-join");
        formJoin.validate({
            highlight: function (element) {
                $(element).closest(".form-group").addClass("error");
            },
            unhighlight: function (element) {
                $(element).closest(".form-group").removeClass("error");
            },
            errorPlacement: function errorPlacement(error, element) {
                var elem = $(element);
                elem.before(error);
                $('.selectpicker ').on('change', function () {
                    $(this).closest('.form-group').find('.bootstrap-select .error').css('display', 'none');
                    $(this).closest('.form-group').removeClass('error')
                })

            },

            rules: {
                name: {
                    required: true,
                    minlength:3,
                },
                last_name: {
                    required: true,
                    minlength:3,
                },
                date_of_birth: {
                    required: true,
                },
                // nationality: {
                //     required: true,
                // },
                country_id: {
                    required: true,
                },
                city_id: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                    // number: true,
                    minlength:9,
                    maxlength:14,
                },
                password: {
                    required: true,
                },

                bank_name: {
                    required: true,
                },
                swift_code: {
                    required: true,
                },
                iban: {
                    required: true,
                },
                branch_no: {
                    required: true,
                },
                national_id: {
                    required: true,
                },
                expire_date: {
                    required: true,
                },
                attach_national: {
                    required: true,
                },
                invoice_image  : {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: "This field is required.",
                },
                last_name: {
                    required: "This field is required.",
                },
                date_of_birth: {
                    required: "This field is required.",
                },
                // nationality: {
                //     required: "This field is required.",
                // },
                country_id: {
                    required: "This field is required.",
                },
                city_id: {
                    required: "This field is required.",
                },
                phone: {
                    required: "This field is required.",
                    number: "Please enter a valid number",
                },
                email: {
                    required: "This field is required.",
                    email: "Please enter a valid email address.",
                },
                national_id: {
                    required: "This field is required.",
                },
                expire_date: {
                    required: "This field is required.",
                },
                attach_national: {
                    required: "This field is required.",
                },
                invoice_image: {
                    required: "This field is required.",
                },
            },
        });
        formJoin.steps({
            headerTag: "h3",
            labels: {
                next: "Next",
                finish: "Submit",
                current: "Next",
                previous: "Back",
            },
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, previousIndex, newIndex , currentIndex) {
                formJoin.validate().settings.ignore = ":disabled,:hidden";
                return formJoin.valid();
            },
            onStepChanged: function (event, newIndex, previousIndex ) {
                if (newIndex === 0) {
                    $(".actions ul li:first-child").fadeOut(1);
                    $('.progress-bar').css("width","33.33%")
                }
                if (newIndex === 1) {
                    $(".actions ul li:first-child").fadeIn(1);
                    $('.progress-bar').css("width","66.33%")
                }
                if (newIndex === 2) {
                    $('.progress-bar').css("width","100%")
                    $(".actions ul li:first-child").fadeIn(1);

                }

                if (newIndex === 3) {
                    $(".actions ul li:first-child").fadeIn(1);
                }
            },
            onFinishing: function (event, currentIndex) {
                document.getElementById("form_join").submit();
                formJoin.validate().settings.ignore = ":disabled";
                return formJoin.valid();
                console.log(event.type);
            },
            onFinished: function (event, currentIndex) {
                document.getElementById("form_join").submit();

            },
        })

        /*------------------------------------
            Add Item Branch On click
        --------------------------------------*/
        $(document).on("click", ".add-item-method", function () {
            var $bankName = $(".bank-name").val();
            var $swiftCode = $(".swift-code").val();
            var $iban = $(".iban").val();
            var $branchNo = $(".branch-no").val();
            if ($(".bank-name").val() == "" || $(".swift-code").val() == "" || $(".iban").val() == "" || $(".branch-no").val() == "") {
                $(".widget-add-method .required").remove();
                $(".widget-add-method").append(`<span class="text-danger required ml-2">This All field is required.</span>`);
            } else {
                $(".widget-add-method .required").remove();
                $(".widget-list-items-method").append(`
              <div class="widget-item-branch py-3 px-4 mb-2">
                <div class="d-flex align-items-start justify-content-between">
                  <h5 class="widget-item-name">${$bankName}</h5>
                  <button class="text-danger font-medium bg-white delete-item-branch" type="button">Delete</button>
                </div>
                <p class="widget-item-addres">${$swiftCode}</p>
                <p class="widget-item-mobile">${$iban}</p>
                <p class="widget-item-mobile">${$branchNo}</p>
              </div>
            `);
                $(".widget-list-add-method").fadeOut(70);
                $(".widget-list-items-method .widget-item-branch").last().hide().fadeIn(800);
                var $bankName = $(".bank-name").val("");
                var $swiftCode = $(".swift-code").val("");
                var $iban = $(".iban").val("");
                var $branchNo = $(".branch-no").val("");
                if ($(".widget-item-branch").length > 1) {
                    var height = $(".step-four .content-step").height();
                    $(".wrapper-step").css("height", height);
                }
            }
        });

        /*------------------------------------
            Remove Item Branch On click
        --------------------------------------*/
        $(document).on("click", ".delete-item-method", function () {
            $(this)
                .closest(".widget-item-branch")
                .fadeOut(300, function () {
                    $(this).remove();
                });
        });


        /*------------------------------------
              Add Bank On click
          --------------------------------------*/
        $(document).on("click", ".add-bank", function () {
            if ($(".widget-item-branch").length > 0 || $(".widget-item-branch").length == 0) {
                $(".widget-list-add-method").fadeIn();
                animateLable();
            }
        });


        $('.radio-card').change(function() {
            if($('.radio_1').is(':checked')) {
                $('.widget-list-add-method').fadeIn()
            }else{
                $('.widget-list-add-method').fadeOut()
            }
        });

    </script>
@endsection
