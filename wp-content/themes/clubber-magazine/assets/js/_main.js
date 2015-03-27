
(function ($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
    var CM = {
        // All pages
        common: {
            init: function () {
                /*console.log('common init');*/
                // JavaScript to be fired on all pages
                // 
                //fitText
                jQuery("h2.sf-2").fitText(1.5, {minFontSize: '10px', maxFontSize: '16px'});

                /* desktop drop down*/
                $('ul#main-menu li').hover(
                        function () {
                            $('ul', this).stop().slideDown(200);
                        },
                        function () {
                            $('ul', this).stop().slideUp(200);
                        }
                );

                //append searchform inside desktop menu
                $('#menu-connect').after($('<li class="menu-search"></li>').html($('.search-form').clone()));

                /* mobile menu */
                //mobile menu search form slide efect
                $('body').on('click', '#open-search-bar', function () {
                    $btn = $(this);
                    $search = $btn.siblings('.search-form');
                    $search.slideDown("fast").find('input').focus();

                });
                $('body').on('focusout', '#mobile-menu-title .search-form', function () {
                    $search = $(this);
                    /*$search = $('.search-form');*/
                    $search.slideUp("fast");
                });

                //create menu container and append to body
                $("<div></div>").attr({
                    'id': 'mobile-menu',
                    'class': 'hide-md'}
                ).prependTo('body');
                //clone main menu, change attr and prepend to container
                $('#main-menu').clone().attr({
                    'class': 'slimmenu',
                    'id': 'slimmenu'
                }).prependTo('#mobile-menu');

                //start mobile menu plugin slimmenu
                $('#slimmenu').slimmenu(
                        {
                            resizeWidth: '768',
                            /*resizeWidth: '1078',*/
                            collapserTitle: '',
                            animSpeed: 'medium',
                            indentChildren: true,
                            childrenIndenter: '&raquo; '
                        }
                );
                //open-search-bar
                //$('#mobile-menu .menu-collapser').prepend($('#open-search-bar'));
                //insert custom html to mobile menu title
                $('#mobile-menu .menu-collapser').prepend($('#mobile-menu-title').css('display', 'block'));


                //------ fancybox
                $('.single .fancybox').fancybox({
                    autoSize: false,
                    width: "80%"
                });
                jQuery(".single .gallery-icon a").fancybox().attr('rel', 'wp-gallery-fancybox');

                /*
                 * 
                 $('.nzSCField_newpodcast').nzSCField({
                 onComplete: function(track) {
                 var plugin = this;
                 var $form = plugin.$element.offsetParent();
                 console.log('this', this);
                 console.log($form, $form);
                 $form.find('#podcast_title').val(track.title);
                 $form.find('#podcast_content').val(track.description);
                 }
                 });
                 */
                console.log('parallax');
                /* 
                 * footer parallax
                 * */
                //bottom position
                new CMP({
                    offsetStart: 300,
                    offsetEnd: 170,
                    callback: function (now, total) {
                        var
                                $obj = $('#footer-parallax'),
                                start = 320,
                                end = 10,
                                gap = start - end,
                                pos = gap * now / total,
                                move = start - pos;
                        $obj.css('bottom', move);
                    }
                });

                //decrease with
                new CMP({
                    offsetStart: 300,
                    offsetEnd: 30,
                    callback: function (now, total) {
                        var
                                $img = $('#footer-parallax img'),
                                start = 80,
                                end = 12,
                                gap = start - end,
                                pos = gap * now / total,
                                move = start - pos;

                        $img.css('width', move + '%');
                    }
                });

                //decrease margin right
                new CMP({
                    offsetStart: 200,
                    offsetEnd: 30,
                    callback: function (now, total) {
                        var
                                $obj = $('#footer-parallax img'),
                                start = 20,
                                end = 3,
                                gap = start - end,
                                pos = gap * now / total,
                                move = start - pos;
                        $obj.css('margin-right', move + '%');
                    }
                });

                //footer menu mobile adapt
                $('#footer-menu > ul > li > a').on('click', function (e) {

                    var $trig = $(this);
                    var $child_ul = $trig.next('ul');

                    if ($child_ul.is(':visible')) {
                        return;
                    }

                    e.preventDefault();

                    var $parent_uls = $trig.parent().siblings();
                    $parent_uls.each(function (ind, el) {
                        $(el).children('ul').slideUp();
                    });

                    $child_ul.slideDown();

                });



            }
        },
        // Home page
        home: {
            init: function () {
            }
        },
        // subir-event page, note the change from subit-evento to subir_evento.
        subir_evento: {
            init: function () {

            }
        }
    };

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function (func, funcname, args) {
            var namespace = CM;
            funcname = (funcname === undefined) ? 'init' : funcname;
            if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function () {
            UTIL.fire('common');

            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
                UTIL.fire(classnm);
            });
        }
    };

    $(document).ready(UTIL.loadEvents);


})(jQuery); // Fully reference jQuery after this point.

