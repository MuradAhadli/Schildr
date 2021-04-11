/* Javascript Document ... */
$(document).ready(function (){
    if (window.matchMedia("(max-width: 1023px)").matches) {
        $('.slide-element').each(function (){
            if ($(this).children('video').length>0){
                $(this).remove();
                console.log('ssdsd');
            }
        })
    }
})
$(window).ready(function () {
    $('.header_social').css({
        'visibility': 'visible'
    });
});
// window.FontAwesomeConfig = { autoReplaceSvg: false }
$('.vproduct-bottom').on('click' , function (){
    var src = $(this).attr('data-src') ;
    $('.modal-body iframe').attr('src' , src + "?autoplay=1&rel=0");
    $("#exampleModal").on("hide.bs.modal", function() {
        $('.modal-body iframe').attr("src", src);
    });
});
$(document).ready(function(){
    $("#project-menu").click(function(){
        var target1 = $(".sub-prj");
        // $(this).find('.rotate').toggleClass("down");
        $(target1).slideToggle("fast" ,function(){
        });
    });
});

$(document).ready(function (){
    if (window.matchMedia("(max-width: 1200px)").matches) {
        $(".columnn h3").click(function(){
            deg = parseInt($(this).attr('data-deg'));
            deg+=180;
            $(this).find('.fa-chevron-down').css("transform", "rotate("+deg+"deg)");
            $(this).attr('data-deg' , deg);
            var target = $(this).parent().children("ul");
            $(target).slideToggle("fast" ,function(){
            });
        });
    }
})





$(document).ready(function(){
    $('.contact-menu').hover(function (){
        $('.contact-x').css('left' , '0px');
    })
    $(window).scroll(function(){
        var project = $(".sub-prj");
        var product = $('.sub-prd');
        $('.contact-x').css('left' , '-205px');
        $(project).slideUp("fast" , function(){
        });
        $(product).slideUp("fast" ,function(){
        });
        $('.arr').removeClass('hide_child');
        $('.arr').addClass('show_sub_menu');

    });
    $("#product-menu").click(function(){
        var target2 = $(".sub-prd");
        $(target2).slideToggle("fast" ,function(){
        });
    });
});
$(document).ready(function() {
    $(window).scroll(function () {
        $('.menu_inner').css('left' , '-250px')
    });
    $('.menu-head').hover(function () {
        $('.menu_inner').css('left', '0px');
    })
});
// $(document).ready(function (){
//     $('.product-item').each(function (){
//         var count = 0;
//         $(this).find('.product-item-single').each(function (){
//             count++;
//             if (count>3){
//                 $(this).remove();
//             }
//         });
//     })
// });
// $(document).ready(function (){
//     var count = 0;
//     $('.product-item').each(function (){
//         count++;
//         if (count>3){
//             $(this).remove();
//         }
//     });
// });

/**Main slider height auto resize**/
$(document).ready(function () {

    var windowHeight = $(window).height() - 90;
    $('.slide').css({
        'height': windowHeight
    });

    // $('.bg_top').css({
    //     'height': windowHeight - 90
    // });
    // $(document).ready(function () {
    //     if ($('#myVideo').length != 0){
    //         $('.carousel').css('height' , '87.5vh');
    //     }
    // })
    $(window).resize(function () {

        if ($(window).width() >= 768) {

            var windowHeight = $(window).height() - 90;

            $('.slide').css({
                'height': windowHeight,
            });

            // $('.bg_top').css({
            //     'height': windowHeight - 90
            // });
        }
    });
});
/** /Main slider height auto resize**/

/* Home main slider... */

$(document).ready(function () {
    $('.slide').slick({
        dots: true,
        autoplay: true,
        autoplaySpeed: 3500,
        cssEase: 'linear',
        arrows: false

    });

    $('.slide').on('afterChange', function(){
        var currentSlide = $('.slide').find(".slick-current");
        var myVideo = document.getElementById("myVideo");
        if (myVideo != null){
            if (currentSlide.find('video').length != 0) {
                myVideo.play();
            }
            else{
                myVideo.pause();
            }
        }
    });

    $('.slick-arrows-helper').find('#next').click(function (e) {
        e.preventDefault();
        $('.slide').slick('slickNext');
    });

    $('.slick-arrows-helper').find('#prev').click(function (e) {
        e.preventDefault();
        $('.slide').slick('slickPrev');
    });
});

$(document).ready(function () {

    $('.home_page_video').controls = false;

    //Play
    $(document).on('click', '.play_btn', function () {
        $(this).css({
            'display': 'none'
        });
        $(this).closest('div').find('.pause_btn').css({
            'display': 'block'
        });


        $(this).closest('div').find('video')[0].play();
    });
    //Pause
    $(document).on('click', '.pause_btn', function () {
        $(this).css({
            'display': 'none'
        });
        $(this).closest('div').find('.play_btn').css({
            'display': 'block'
        });


        $(this).closest('div').find('video')[0].pause();
    });


    /** Main left dropdown menu **/
    $(document).on('click', '.show_sub_menu', function (e) {
        e.preventDefault();

        var eventElement = $(this).closest('li').find('ul');

        var hasEventElement = $(this).closest('.menu_inner').find('.menu_child ');

        hasEventElement.each(function (index, item) {
            if ($(item).hasClass('show')) {
                $(item).stop().slideUp();

                $(item).closest('li').find('.hide_child').removeClass('hide_child').addClass('show_sub_menu');
            }
        });

        var isBlock = $(this).closest('.menu_inner').find('.menu_child');

        isBlock.filter(function (index, item) {

            if ($(item).css('display') === 'block') {
                $(item).closest('li').find('.hide_child').removeClass('hide_child').addClass('show_sub_menu');

                $(item).stop().slideUp(function () {
                    $(item).removeClass('show');
                });
            }
        });

        if (eventElement.hasClass('show')) {
            eventElement.slideUp('slow', function () {
                eventElement.removeClass('show');
            });

        } else {
            eventElement.stop().slideDown(300, function () {
                $(this).removeClass('toggling');
            });
        }

        $(this).removeClass('show_sub_menu');
        $(this).addClass('hide_child');
    });


    $(document).on('click', '.hide_child', function (e) {
        e.preventDefault();
        var this_elem = $(this);
        var eventElement = $(this).closest('li').find('ul');

        eventElement.stop().slideUp(300, function () {
            $(this).removeClass('toggling');
            if (eventElement.hasClass('show')) {
                eventElement.removeClass('show');
            }
        });

        $(this).removeClass('hide_child');
        $(this).addClass('show_sub_menu');
    });

    /**Open menu icon for mini size Menu (Custom Animation)**/
    $(document).on('click', '.open_menu', function () {

        var windowWidth = $(document).width();
        var customWidth;
        /**Checking window width for mobile or large size**/
        if (windowWidth <= 415) {
            customWidth = '100%';
        } else {
            customWidth = '350px';
        }

        $('.menu_mini').css({
            'display': 'block'
        });
        $('main').css({
            'display':'none'
        });
        $('.menu_mini').animate({
            opacity: '1',
            minHeight: '87%',
            width: customWidth,
        }, 100);

        $(this).addClass('close_menu');
        $(this).removeClass('open_menu');
    });
    /** /Open menu icon for mini size Menu**/

    /**Close menu icon for mini size Menu**/
    $(document).on('click', '.close_menu', function () {
        $('main').css({
            'display':'block'
        });
        $('.menu_mini').animate({
            opacity: '0',
            minHeight: '0px',
            width: '0px',
        }, 100, function () {
            $('.menu_mini').css({
                'display': 'none'
            });
        });
        $(this).addClass('open_menu');
        $(this).removeClass('close_menu');
    });
    /** /Close menu icon for mini size Menu**/


    /** Open mini size menu sub list**/

    var selector = $('.menu_arrow').closest('li').find('.menu_arrow');
    selector.click(function (e) {
        e.preventDefault();
        $(this).parents('li').find('ul').stop().slideToggle(300, function () {
            $(this).removeClass('toggling');
        });

        $(this).toggleClass('rotate-90');
        $('.menu_mini').css({
            'height': 'auto'
        });
    });


    $(window).resize(function () {
        var windowWidth = $(document).width();

        if (windowWidth > 768) {
            $('.menu_mini').addClass('hidden');
        }
    });
    /** /Open mini size menu sub list**/


    /** Mini social and Mini language **/
    // $(document).on('click', '.open_social', function () {
    //     $('.mini_social').toggleClass('hidden');
    //     $('.mini_lang').addClass('hidden');
    // });
    $(document).on('click', '.open_lang', function () {
        $('.mini_lang').toggleClass('hidden');
        $('.mini_social').addClass('hidden');
    });

});


/**Page system slick slider**/
$(document).ready(function () {
    /**System Slick**/
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: false,
        focusOnSelect: true
    });
});

/**Page complex system slick slider**/
$(document).ready(function () {
    /**System Slick for first Complex Carousel Nav (complex_carousel_for-1 && complex_carousel_nav-1)**/
    for (var i = 0; i < 10; i++) {
        var slickNav = '#SlickNav-' + i;
        var slickFor = '#SlickFor-' + i;
        $(slickFor).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: false,
            asNavFor: slickNav
        });
        $(slickNav).slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            asNavFor: slickFor,
            dots: false,
            arrows: false,
            centerMode: false,
            focusOnSelect: true
        });
        $('.slick_right').click(function () {
            $(this).closest('.complex_carousel_helper').find('.complex_carousel_nav').slick('slickNext');
        });
        $('.slick_left').click(function () {
            $(this).closest('.complex_carousel_helper').find('.complex_carousel_nav').slick('slickPrev');
        });
    }

    //Raitings

    $(document).on('click', '.clients_left', function (e) {
        $('.clients_inner').slick('slickPrev');
    });
    $(document).on('click', '.clients_right', function (e) {
        $('.clients_inner').slick('slickNext');
    });
    $('.clients_inner').slick({
        arrows: false,
        rows: 2,
        slidesToShow: 3,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 768,
                settings:{
                    slidesToShow:2,
                }
            }

        ]
    });
    $('.ratings_item').slick({
        arrows: false,
        rows: 1,
        slidesToShow: 1
    });
    $(document).on('click', '.ratings_left', function (e) {
        $('.ratings_item').slick('slickPrev');
    });
    $(document).on('click', '.ratings_right', function (e) {
        $('.ratings_item').slick('slickNext');
    });

    //partners slider
        $('.partners_inner').slick({
        arrows: false,
        rows: 1,
        slidesToShow: 7,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 768,
                settings:{
                    slidesToShow:2,
                }
            }

        ]
    });

    //Counter Up for statistic
    $('.counter').countUp({
        'time': 800,
        'delay': 8
    });

});

$(document).ready(function () {
    $(document).on('click', '#form_reset', function () {
        $('#contact-us')[0].reset();
    });
});


$(document).ready(function () {
    $(document).on('click', '.nav-item ', function (e) {
        var elem = $(this).closest('div').find('.active');
        elem.removeClass('active');
        $(this).addClass('active');
    });
});

/** /Set and Remove active class in Tab Pane**/

$(document).ready(function () {
    function closeRightZone() {
        $('.open_right').toggleClass('toggleRightStyle');
        $('.open_right').find('svg').toggleClass('fa-angle-right');
        $('.open_right').find('svg').toggleClass('fa-angle-left');
        $('.open_right').closest('div').toggleClass('toggleRight');
    }

    setTimeout(function () {
        closeRightZone();
    }, 5000);


    $(document).on('click', '.open_right', function () {
        $(this).toggleClass('toggleRightStyle');
        $(this).find('svg').toggleClass('fa-angle-right');
        $(this).find('svg').toggleClass('fa-angle-left');
        $(this).closest('div').toggleClass('toggleRight');
    });
});


/** Product fixed and rolling system routing inner page with anchor .. **/
$(document).ready(function () {
    $("a.scrollLink").click(function (event) {
        event.preventDefault();
        $("html, body").animate({scrollTop: $($(this).attr("href")).offset().top - 80}, 750);
    });
});



/** Back to top button **/
$(document).ready(function () {
    $(document).scroll(function () {
        var htmlOffset = $('html, body').scrollTop();
        var objOffset = $('.main_center').offset().top;


        if (objOffset < htmlOffset) {
            $('#scrollTop').css({
                'visibility': 'visible',
                'opacity': 1,
                'tarnsition': 'all 0.4s ease-out'
            });
        } else {
            $('#scrollTop').css({
                'opacity': 0,
                'visibility': 'hidden',
                'tarnsition': 'all 0.4s ease-out'
            });
        }

    });


    $("#scrollTop").click(function (event) {
        event.preventDefault();
        $("html, body").animate({scrollTop: 0}, 650);
    });
});


/**Multiple Slick Slider for Project / Recidental && Commercial**/
$(document).ready(function () {
    var projectSelector = $('.project_org .project_item');
    projectSelector.slickLightbox({
        itemSelector: 'a',
        navigateByKeyboard: false
    });
});
/** /Multiple Slick Slider for Project / Recidental && Commercial**/


$(document).ready(function () {

    $(document).on('click', '#load_more', function (e) {
        e.preventDefault();

        var lastId, resultDiv = '';
        var thisElem = $(this);
        var parentDiv = thisElem.closest('.project').find('div#lightgallery');
        var lastElem = $('.contain-group:last-child .project_item:last-child');
        var scriptUrl = window.location.pathname;
        var indexSlash = scriptUrl.lastIndexOf('/');
        projectType = scriptUrl.slice(indexSlash + 1);
        lastId = $(lastElem).data('id');

        $(this).html('LOADING...');
        $(this).attr('disabled', 'disabled');

        $.ajax({
            url: 'append-ajax',
            type: 'POST',
            dataType: 'json',
            data: {
                id: lastId,
                projectType: projectType
            },
            success: function (data) {
                // console.log(data);
                thisElem.removeAttr('disabled');
                thisElem.html('LOAD MORE');
                parentDiv.append(data.append);

                $.each(data.slickId, function (index, item) {
                    $("#lightgallery").find("[data-id='" + data.slickId[index] + "']").slickLightbox({
                        itemSelector: 'a',
                        navigateByKeyboard: true
                    })

                });

                if (data.state === false) {
                    thisElem.css({
                        'display': 'none'
                    });
                }

            },
            error: function (err) {
                err.responseType;
            }
        });

    });
});
$(function() {
    $('.aniimated-thumbnials').lightGallery({
        thumbnail: true,
        exThumbImage: 'data-exthumbimage'

    });
// Card's slider
    var $carousels = $('.slider-for-prd');

});



/**Append New Product Category when clicked load_more_pr button**/
$(document).ready(function () {
    $(document).on('click', '#load_more_pr', function (e) {
        e.preventDefault();
        var thisElem = $(this);
        var lastId = thisElem.closest('.project').find('.project_item:last-child').data('id');

        thisElem.html('LOADING...');

        $.ajax({
            url: './product-category/append-category',
            method: 'POST',
            data: {
                lastId: lastId,
            },
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                var closest = thisElem.closest('.project').find('.product_item_closest');
                closest.append(data.output);

                if (!data.state) {
                    thisElem.css({
                        'display': 'none'
                    })
                } else {
                    thisElem.html('LOADING');
                }

            },
            error: function (err) {
                err.responseText;
            }
        });
    });
});
/** /Append New Product Category when clicked load_more_pr button**/


/**Append New Product Alt Category when clicked load_more_pr button**/
$(document).ready(function () {
    $(document).on('click', '#load_more_pr_alt', function (e) {
        e.preventDefault();
        var thisElem = $(this);
        var lastId = thisElem.closest('.project').find('.project_item:last-child').data('id');
        var parentId = thisElem.data('url-id');
        thisElem.html('LOADING...');

        $.ajax({
            url: './../../product-category/append-alt-category',
            method: 'POST',
            data: {
                lastId: lastId,
                parentId: parentId,
            },
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                var closest = thisElem.closest('.project').find('.product_item_closest');
                closest.append(data.output);

                if (!data.state) {
                    thisElem.css({
                        'display': 'none'
                    })
                } else {
                    thisElem.html('LOADING');
                }

            },
            error: function (err) {
                err.responseText;
            }
        });
    });
});
/** /Append New Product Alt Category when clicked load_more_pr button**/

/** Product fixed and rolling system routing inner page with anchor .. **/
$(document).ready(function () {
    $("a.scrollLink").click(function (event) {
        event.preventDefault();
        $("html, body").animate({scrollTop: $($(this).attr("href")).offset().top - 80}, 750);
    });
});

/** Back to top button **/
$(document).ready(function () {
    $(document).scroll(function () {
        var htmlOffset = $('html, body').scrollTop();
        var objOffset = $('.main_center').offset().top;


        if (objOffset < htmlOffset) {
            $('#scrollTop').css({
                'visibility': 'visible',
                'opacity': 1,
                'tarnsition': 'all 0.4s ease-out'
            });
        } else {
            $('#scrollTop').css({
                'opacity': 0,
                'visibility': 'hidden',
                'tarnsition': 'all 0.4s ease-out'
            });
        }
    });


    $("#scrollTop").click(function (event) {
        event.preventDefault();
        $("html, body").animate({scrollTop: 0}, 650);
    });
});

// $(document).ready(function () {
//     $(document).on('mouseover', '.real_image', function () {
//         var checkHoverImgSrcValue = $(this).closest('a').find('.hover_image').attr('src');
//         if (checkHoverImgSrcValue != '') {
//             $(this).css('display', 'none');
//             $(this).closest('a').find('.hover_image').css('display', 'block');
//         }
//     });
//
//     $(document).on('mouseleave', '.hover_image', function () {
//         $(this).css('display', 'none');
//         $(this).closest('a').find('.real_image').css('display', 'block');
//     });
// });

/**Clear Console**/
// $(document).ready(function () {
//     setTimeout(function () {
//         console.clear();
//     }, 3000);
// });

// $(document).ready(function (){
//     var colors = ['#d1d7e7','#cea890', '#bcbcbc','#a8c9df','#d1d7e7','#cea890', '#bcbcbc','#a8c9df'];
//     var buttons = ['#acb5ce' , '#be835d' , '#8c8c8c' , '#6ba4ca','#acb5ce' , '#be835d' , '#8c8c8c' , '#6ba4ca']
//     var div = $('.prdct-single-info');
//     var i;
//     for (i = 0; i < div.length; i++) {
//     div.eq(i).find('.contener').css('background-color', buttons[i]);
//     div.eq(i).css('background-color', colors[i] );
//         if (window.matchMedia('(max-width: 1200px)').matches) {
//             div.eq(i).parent().find('.prdct-single-name').css('background-color', colors[i] );
//         }
//     }
// });

/** Auto scroll For Action **/
// $(document).ready(function () {
//     function autoScroll(action, time) {
//         var location = window.location.href;
//         var lastIndex = location.lastIndexOf('#');
//         var pageSlug = location.substr(lastIndex + 1);
//
//         if (lastIndex != -1) {
//             var height = $('.main_center').find('#' + pageSlug).offset().top;
//             $('html, body').animate({
//                 scrollTop: height
//             }, time);
//         }
//
//         console.log(height);
//     }
//     autoScroll('product-category', 1200);
//
// });
/**Set and Remove active class in Tab Pane**/