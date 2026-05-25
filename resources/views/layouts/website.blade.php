<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{\Illuminate\Support\Facades\App::getLocale() == 'ar' ? getSetting('sitename') : getSetting('sitename_en')}}</title>
    <link rel="icon" href="{{asset('img/setting/'.getSetting('website_icon'))}}">
    <meta property="og:type" content="{{web('og:type')}}"/>
    <meta property="og:title" content="{{web('og:title')}}"/>
    <meta property="og:description" content="{{web('og:description')}}"/>
    <meta property="og:image" content="{{web('og:image')}}"/>
    <meta property="og:image:width" content="{{web('og:image:width')}}"/>
    <meta property="og:image:height" content="{{web('og:image:height')}}"/>
    <meta property="og:url" content="{{web('og:url')}}"/>
    <meta property="og:site_name" content="{{web('og:site_name')}}"/>
    <meta property="og:ttl" content="{{web('og:ttl')}}"/>
    <meta name="twitter:card" content="{{web('twitter:card')}}"/>
    <meta name="twitter:domain" content="{{web('twitter:domain')}}"/>
    <meta name="twitter:site" content="{{web('twitter:site')}}"/>
    <meta name="twitter:creator" content="{{web('twitter:creator')}}"/>
    <meta name="twitter:image:src" content="{{web('twitter:image:src')}}"/>
    <meta name="twitter:description" content="{{web('twitter:description')}}"/>
    <meta name="twitter:title" content="{{web('twitter:title')}}"/>
    <meta name="twitter:url" content="{{web('twitter:url')}}"/>
    <meta name="description" content="{{getSetting('description')}}"/>
    <meta name="keywords" content="{{getSetting('keywords')}}"/>
    <meta name="author" content="{{getSetting('author')}}"/>
    <meta name="copyright" content="{{getSetting('copyright')}}"/>
    <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.2/css/pro.min.css"/>
    <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/swiper.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-select.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/jquery.steps.css')}}"/>
    @if (App::getLocale() =='ar')
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.rtl.min.css')}}"/>
    @endif
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}"/>
    @if (App::getLocale() =='ar')
        <link rel="stylesheet" href="{{asset('assets/css/main.rtl.css')}}"/>
    @endif
    <link rel="stylesheet" href="{{asset('assets/css/perfect-scrollbar.min.css')}}"/>
    {{-- Glassmorphism layer - website frontend only --}}
    <link rel="stylesheet" href="{{asset('assets/css/glass.css')}}"/>


    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />
    <style>
        .scroll{
            position: relative;
            height: 704px;
        }
    </style>
    <style>

        .iti__country-list {
            z-index: 20 !important;
        }
        .progress-bar {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            background-color: #27ba4d !important;
            transition: width .6s ease;
        }
        @if(\Illuminate\Support\Facades\App::getLocale() == 'ar')
        dd,p,h1,h2,h3,h4,h5,h6{
            text-align: right;
        }


        @endif
    </style>
</head>
<body>

@yield('content')


<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/wow.min.js')}}"></script>
<script src="{{asset('assets/js/swiper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('assets/js/cascade-slider.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.steps.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
@yield('scripts')
<script src="{{asset('assets/js/function.js')}}"></script>
<script>


    var form = $(".form-login");
    form.validate({
        highlight: function (element) {
            $(element).closest(".form-group").addClass("error");
        },
        unhighlight: function (element) {
            $(element).closest(".form-group").removeClass("error");
        },
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
            // if(error){
            //   $('.form-control.error').closest('.form-group').addClass('s')
            // }else{
            //   $('.form-control.error').closest('.form-group').removeClass('s')
            // }
        },

        rules: {
            first_name: {
                required: true,
                minlength:3,
            },
            last_name: {
                required: true,
                minlength:3,
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
                minlength:3,
            },
            name_ar: {
                required: true,
                minlength:3,
            },
            address: {
                required: true,
                minlength:3,
            },
            company_email: {
                required: true,
                email: true,
            },
            phone_company: {
                required: true,
                // number: true,
                minlength:9,
                maxlength:14,
            },
            logo: {
                required: true,
            },
            restaurant_licence: {
                required: true,
            },
            have_tablet: {
                required: true,
            },
            agree: {
                required: true,
            },
            // branchName: {
            //   required: true,
            // },
            // branchAddress: {
            //   required: true,
            // },
            // branchMobile: {
            //   required: true,
            //   number: true,
            // },

        },
        messages: {
            first_name: {
                required: "{{web('This field is required.')}}",
            },
            last_name: {
                required: "{{web('This field is required.')}}",
            },
            phone: {
                required: "{{web('This field is required.')}}",
            },
            password: {
                required: "{{web('This field is required.')}}",
            },
            email: {
                required: "{{web('This field is required.')}}",
                email: "{{web('Please enter a valid email address.')}}",
            },
            employeeNo: {
                required: "{{web('This field is required.')}}",
                number: "{{web('Please enter a valid number')}}",
            },
            name_ar: {
                required: "{{web('This field is required.')}}",
            },
            address: {
                required: "{{web('This field is required.')}}",
            },
            company_email: {
                required: "{{web('This field is required.')}}",
            },
            logo: {
                required: "{{web('This field is required.')}}",
            },
            restaurant_licence: {
                required: "{{web('This field is required.')}}",
            },
            have_tablet: {
                required: "{{web('This field is required.')}}",
            },
            agree: {
                required: "{{web('This field is required.')}}",
            },
            phone_company: {
                required: "{{web('This field is required.')}}",
                // number: "Please enter a valid number",
            },
        },
    });

    form.steps({
        // saveState: true,
        headerTag: "h3",
        labels: {
            next: "{{web('Next')}}",
            finish: "{{web('Next')}}",
            current: "{{web('Next')}}",
            previous: "{{web('Back')}}",
        },
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, previousIndex, newIndex , currentIndex) {

            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onStepChanged: function (event, newIndex, previousIndex ) {
            if (newIndex === 0) {
                $(".actions ul li:first-child").css('display','none');
                $('.progress-bar').css("width","20%")
            }
            if (newIndex === 1) {
                $(".actions ul li:first-child").fadeIn(1);
                $('.progress-bar').css("width","40%")
            }
            if (newIndex === 2) {
                $('.progress-bar').css("width","60%")
                $(".actions ul li:first-child").fadeIn(1);
            }

            if (newIndex === 3) {
                $('.progress-bar').css("width","80%")
                $(".actions ul li:first-child").fadeIn(1);
            }

            if (newIndex === 4) {
                $('.progress-bar').css("width","100%")
            }


        },
        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            // alert("Submitted!");
            document.getElementById("my_form").submit();

        },
    });

    $(".actions ul li:first-child a").html(`
      <svg class="mr-1" width="6" height="9" viewBox="0 0 6 9" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.03659 4.5019L5.77756 1.13488C5.88057 1.04239 5.93724 0.918732 5.93724 0.786878C5.93724 0.654951 5.88057 0.531366 5.77756 0.438732L5.44976 0.143854C5.34691 0.0510732 5.20943 0 5.06293 0C4.91642 0 4.77911 0.0510732 4.67618 0.143854L0.221953 4.15259C0.11862 4.24551 0.0620346 4.36968 0.0624411 4.50168C0.0620346 4.63427 0.118539 4.75829 0.221953 4.85129L4.67203 8.85615C4.77496 8.94893 4.91228 9 5.05886 9C5.20537 9 5.34268 8.94893 5.44569 8.85615L5.77342 8.56127C5.98667 8.36934 5.98667 8.0569 5.77342 7.86505L2.03659 4.5019Z" fill="black"></path>
      </svg>
    <span>{{web('Back')}}</span>`);


    $(".selectpicker").selectpicker();

    //
    $(".uploadeImage").change(function () {
        $(this).closest(".form-group").find(".name-image").text(this.files[0].name);
        $(this).closest(".form-group").removeClass("error");
        $(this).closest(".form-group").find("label.error").remove();
    });



    var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    // initialise plugin
    var iti = window.intlTelInput(input, {
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

    var reset = function() {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

    // on blur: validate
    input.addEventListener('blur', function() {
        reset();
        if (input.value.trim()) {
            if (iti.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                var errorCode = iti.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });

    // on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);
</script>
@yield('scripts_new')
<script src="{{asset('assets/js/perfect-scrollbar.min.js')}}"></script>
<script>
    $('.scroll').each(function(){ const ps = new PerfectScrollbar($(this)[0]); });
</script>
</body>
</html>
