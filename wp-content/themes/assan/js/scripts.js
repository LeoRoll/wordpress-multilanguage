jQuery(document).ready(function ($) {

    //HOVER DROP DOWN MENU
    //$('.dropdown-toggle').dropdownHover();
    //SCROLL MENU
    $(window).load(function () {
        $(".sticky").sticky({topSpacing: 0});
    });

    $( window ).resize(function() {$(".navbar-collapse").css({ maxHeight: $(window).height() - $(".navbar-header").height() + "px" });});

    var $container = $('.portfolio-wrap');
    var $filter = $('.portfolio-filter');
    var filterItemA = $('.portfolio-filter li a');
    $container.imagesLoaded(function () {
        $container.isotope({
            itemSelector: '.project-post',
            layoutMode: 'fitRows',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
    });
    $filter.on('click', 'a', function () {
        var filterValue = $(this).attr('data-filter');
        $container.isotope({
            filter: filterValue,
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
    });

    filterItemA.on('click', function () {
        var $this = $(this);
        if (!$this.hasClass('active')) {
            filterItemA.removeClass('active');
            $this.addClass('active');
        }
    });
    $('.blog-list').isotope({
        itemSelector: '.masonry-item',
        percentPosition: true
    });


    $(window).stellar({
        horizontalScrolling: false,
        responsive: true,
        scrollProperty: 'scroll',
        parallaxElements: false,
        horizontalScrolling: false,
        horizontalOffset: 0,
        verticalOffset: 0
    });

//OWL CAROUSEL
    $("#work-carousel").owlCarousel({
        // Most important owl features
        items: 4,
        itemsCustom: false,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [980, 3],
        itemsTablet: [768, 3],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        startDragging: true,
        autoPlay: 6000
    });

    $("#news-carousel").owlCarousel({
        // Most important owl features
        items: 2,
        itemsCustom: false,
        itemsDesktop: [1199, 2],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [768, 2],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        startDragging: true,
        autoPlay: 4000
    });

   $("#image-news-carousel").owlCarousel({
        // Most important owl features
        // autoHeight : true,
        autoPlay: 9000,
        stopOnHover: true,
        items: 1,
        itemsCustom: false,
        itemsDesktop: [1199, 2],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [768, 2],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        navigationText: [
                            '<i class="fa fa-chevron-left"></i>',
                            '<i class="fa fa-chevron-right"></i>'
                        ],
        singleItem: true,
        navigation: true,
        pagination: true,
        startDragging: true,
        transitionStyle : "fadeUp",
        itemsScaleUp: true,
        afterUpdate: function () {
            var minHeight=parseInt($('#image-news-carousel .owl-item').eq(0).css('height').replace('px', ''));
            $('#image-news-carousel .owl-item').each(function () {
                var thisHeight = parseInt($(this).css('height').replace('px', ''));
                if (minHeight > 0 && thisHeight > 0) {
                    minHeight=(minHeight<=thisHeight?minHeight:thisHeight);
                }
            });
            if (minHeight > 0) {
                $('#image-news-carousel .owl-wrapper-outer').css('height',minHeight+'px');
            }
        },
        afterInit:function(){
            var minHeight=parseInt($('#image-news-carousel .owl-item').eq(0).css('height').replace('px', ''));
            $('#image-news-carousel .owl-item').each(function () {
                var thisHeight = parseInt($(this).css('height').replace('px', ''));
                if (minHeight > 0 && thisHeight > 0) {
                    minHeight=(minHeight<=thisHeight?minHeight:thisHeight);
                }
            });
            if (minHeight > 0) {
                $('#image-news-carousel .owl-wrapper-outer').css('height',minHeight+'px');
            }
        }
    });

   $(".custom-owl-carousel").owlCarousel({
        // Most important owl features
        autoPlay: 5000,
        stopOnHover: true,
        items: 1,
        itemsCustom: false,
        itemsDesktop: [1199, 2],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [768, 2],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        navigationText: [
                            '<i class="fa fa-chevron-left"></i>',
                            '<i class="fa fa-chevron-right"></i>'
                        ],
        singleItem: true,
        navigation: true,
        pagination: true,
        startDragging: true,
        transitionStyle : "fadeUp",
        itemsScaleUp: true
    });

    $("#testi-carousel").owlCarousel({
        // Most important owl features
        items: 1,
        itemsCustom: false,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [768, 1],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        startDragging: true,
        autoPlay: 4000
    });

    $("#featured-work").owlCarousel({
        autoPlay: 5000, //Set AutoPlay to 3 seconds
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 3],
        stopOnHover: true

    });
    $("#clients-slider").owlCarousel({
        autoPlay: 3000,
        pagination: false,
        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [991, 2]
    });

    $('.counter').counterUp({
        delay: 100,
        time: 800
    });

    //MAGNIFIC POPUP
    $('.show-image,.gallery-icon a').magnificPopup({type: 'image'});
    $('.latest-blog-section > .margin30').addClass('col-md-4 col-sm-6');
    $('.gallery-icon > a > img').addClass('img-responsive');

    // flex slider
    $('.main-flex-slider,.testi-slide').flexslider({
        slideshowSpeed: 5000,
        directionNav: false,
        animation: "fade"
    });

    $("[data-toggle=popover]").popover();
    $("[data-toggle=tooltip]").tooltip();

    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.transparent-header').css("background", "#252525");
        } else {
            $('.transparent-header').css("background", "transparent");
        }
    });
    var wow = new WOW(
            {
                boxClass: 'wow', // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset: 100, // distance to the element when triggering the animation (default is 0)
                mobile: false        // trigger animations on mobile devices (true is default)
            }
    );
    wow.init();

    //ONEPAGE START
    $('.scroll-to a[href*=\\#]:not([href=\\#])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
    $('.scroll-to a[href=\\#home]:not([href=\\#])').click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
        return false;
    });
    //back to top
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 250) {
            $("#back-to-top").addClass("show");
        } else {
            $("#back-to-top").removeClass("show");
        }
    });
    $("#back-to-top a").click(function () {
        $("html, body").animate({scrollTop: 0}, 1000);
        return false;
    });

    // 搜索栏点击

    $('.global-search').on('click', function(){
        $(this).toggleClass('open');
    })

    $('.global-search form input').on('click', function(event){
        event.stopPropagation();
    })

});


