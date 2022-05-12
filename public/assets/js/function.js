(function ($) {
  "use-strict";

  /*------------------------------------
        menu mobile
    --------------------------------------*/
  $(".header-mobile__toolbar").on("click", function () {
    $(".menu--mobile").addClass("menu-mobile-active");
    $(".mobile-menu-overlay").addClass("mobile-menu-overlay-active");
  });

  $(".mobile-menu-overlay").on("click", function () {
    $(".menu--mobile").removeClass("menu-mobile-active");
    $(".mobile-menu-overlay").removeClass("mobile-menu-overlay-active");
  });

  $(".main-header .btn-close-header-mobile").on("click", function () {
    $(".menu--mobile").removeClass("menu-mobile-active");
    $(".mobile-menu-overlay").removeClass("mobile-menu-overlay-active");
  });

  /*------------------------------------
        loader page
    --------------------------------------*/
  $(window).on("load", function () {
    $(".loader-page").fadeOut(500);
    var wow = new WOW({
      boxClass: "wow",
      animateClass: "animated",
      offset: 0,
      mobile: false,
      live: true,
    });
    new WOW().init();
  });

  /*------------------------------------
        selectpicker
    --------------------------------------*/

  /*------------------------------------
        Add Branch On click
    --------------------------------------*/
  $(document).on("click", ".add-branch", function () {
    if ($(".widget-item-branch").length > 0 || $(".widget-item-branch").length == 0) {
      $(".widget-list-add-branch").fadeIn();
      animateLable();
    }
  });

  /*------------------------------------
       Add Item Branch On click
   --------------------------------------*/
  $(document).on("click", ".add-item-branch", function () {
    var $branchName = $(".branch-name").val();
    var $brancAddress = $(".branch-address").val();
    var $brancMobile = $(".branch-mobile").val();
    var $brancState = $(".branch-state").find(".filter-option-inner-inner .number").text();
    if ($(".branch-name").val() == "" || $(".branch-address").val() == "" || $(".branch-mobile").val() == "") {
      $(".widget-add-branch .required").remove();
      $(".widget-add-branch").append(`<span class="text-danger required ml-2">This All field is required.</span>`);
    } else {
      $(".widget-add-branch .required").remove();
      $(".widget-list-items-branch").append(`
          <div class="widget-item-branch py-3 px-4 mb-2">
            <div class="d-flex align-items-start justify-content-between">
              <h5 class="widget-item-name">${$branchName}</h5>
              <button class="text-danger font-medium bg-white delete-item-branch" type="button">Delete</button>
            </div>
            <p class="widget-item-addres">${$brancAddress}</p>
            <p class="widget-item-mobile">${$brancState} ${$brancMobile}</p>
          </div>
        `);
      $(".widget-list-add-branch").fadeOut(70);
      $(".widget-list-items-branch .widget-item-branch").last().hide().fadeIn(800);
      var $branchName = $(".branch-name").val("");
      var $brancAddress = $(".branch-address").val("");
      var $brancMobile = $(".branch-mobile").val("");

      if ($(".widget-item-branch").length > 1) {
        var height = $(".step-four .content-step").height();
        $(".wrapper-step").css("height", height);
      }
    }
  });

  /*------------------------------------
        Remove Item Branch On click
    --------------------------------------*/
  $(document).on("click", ".delete-item-branch", function () {
    $(this)
      .closest(".widget-item-branch")
      .fadeOut(300, function () {
        $(this).remove();
      });
  });
  //

  animateLable();

  $("#cascade-slider").cascadeSlider({});
})(jQuery);


/*------------------------------------
Action Placeholder Input
--------------------------------------*/
function animateLable() {
  var $form = $("form"),
    $elements = $form.find('input[type="text"],input[type="email"],input[type="password"],textarea, select , tel');

  $elements.each(function (index, element) {
    refreshValueState(element);

    $(element).focus(function () {
      $(element).parent().addClass("has-value");
    });
  });

  $elements.on("blur", function (e) {
    var element = e.currentTarget;

    refreshValueState(element);
  });
}

function refreshValueState(element) {
  var cleanedValue = $(element).val().replace(/^\s+$/, "");

  $(element).val(cleanedValue);

  if ($(element).val() !== "") {
    $(element).parent().addClass("has-value");
  } else {
    $(element).parent().removeClass("has-value");
  }
}

/*------------------------------------
  swiper
--------------------------------------*/

var slider_phone = new Swiper(".slider-phone", {
  slidesPerView: 3,
  centeredSlides: true,
  loop: true,
  speed: 2000,
  // autoplay: {
  //   delay: 4000,
  //   disableOnInteraction: false
  // },
  // pagination: {
  //   el: '.swiper-pagination',
  //   clickable: true,
  // },
  navigation: {
    nextEl: ".action-swiper .swiper-button-next",
    prevEl: ".action-swiper .swiper-button-prev",
  },
});

var slider_clients = new Swiper(".slider-clients", {
  slidesPerView: 6,
  loop: false,
  speed: 2000,
  slidesPerColumn: 3,
  slidesPerGroup: 6,
  spaceBetween: 30,
  // autoplay: {
  //   delay: 4000,
  //   disableOnInteraction: false,
  // },
  pagination: {
    el: "#section-partners .swiper-pagination",
    clickable: true,
  },
  // navigation: {
  //   nextEl: '.action-swiper .swiper-button-next',
  //   prevEl: '.action-swiper .swiper-button-prev',
  // },
  breakpoints: {
    576: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
    },
    992: {
      slidesPerView: 3,
    },
    1400: {
      slidesPerView: 6,
    },
  },
});

$(".swiper-filter").on("click", ".btn-filter", function () {
  var filter = $(this).attr("data-filter");
  $(".slider-rest .swiper-slide").fadeOut(0);
  $(".slider-rest .swiper-slide" + filter).fadeIn();
  $(".swiper-filter .btn-filter").removeClass("swiper-active");
  $(this).addClass("swiper-active");

  slider_rest.updateSize();
  slider_rest.updateSlides();
  slider_rest.updateProgress();
  slider_rest.updateSlidesClasses();
  slider_rest.slideTo(0);
  slider_rest.scrollbar.updateSize();

  return false;
});

var filterSwiper = new Swiper(".swiper-filter", {
  slidesPerView: "auto",
  spaceBetween: 40,
});

var slider_rest = new Swiper(".slider-rest", {
  slidesPerView: 3,
  loop: false,
  speed: 2000,
  spaceBetween: 30,
  scrollbarHide: false,
  updateOnImagesReady: true,
  observer: true,
  runCallbacksOnInit: true,
  // autoplay: {
  //   delay: 4000,
  //   disableOnInteraction: false
  // },
  pagination: {
    el: "#section-restaurants .swiper-pagination",
    clickable: true,
  },
  // navigation: {
  //   nextEl: '.action-swiper .swiper-button-next',
  //   prevEl: '.action-swiper .swiper-button-prev',
  // },
  breakpoints: {
    576: {
      slidesPerView: 1.2,
    },
    768: {
      slidesPerView: 1.5,
    },
    992: {
      slidesPerView: 2.5,
    },
    1400: {
      slidesPerView: 3,
    },
  },
});
