/*glopal $, alert, console*/

$(function(){

    'use strict';

    // magic carousel
    $('#cascade-slider').cascadeSlider({
      itemClass: 'cascade-slider_item',
      arrowClass: 'cascade-slider_arrow'
    });

    // menu bars at mobile screen
    $("header .container .row > div:nth-of-type(1) i").click(function(){

        $("header .container .row > div:nth-of-type(2) ul").slideToggle(500)

    });

    // start all the timers
    $('.timer').each(count);

    function count(options) {
        var $this = $(this);
        options = $.extend({}, options || {}, $this.data('countToOptions') || {});
        $this.countTo(options);
    }
    
    // loop carousel
    $('.loop').owlCarousel({
        center: true,
        items:3,
        autoplay:false,
        smartSpeed:500,
        loop:true,
        dots:true,
        margin:10,
        responsive:{
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:2
            },
            992:{
                items:3
            },
            1199:{
                items:3
            }
        }
    });


});