/*-----------------------------------------------------------------------------------*/
/*	RETINA.JS
/*-----------------------------------------------------------------------------------*/
(function () {
    function t(e) {
        this.path = e;
        var t = this.path.split("."),
            n = t.slice(0, t.length - 1).join("."),
            r = t[t.length - 1];
        this.at_2x_path = n + "@2x." + r
    }
    function n(e) {
        this.el = e, this.path = new t(this.el.getAttribute("src"));
        var n = this;
        this.path.check_2x_variant(function (e) {
            e && n.swap()
        })
    }
    var e = typeof exports == "undefined" ? window : exports;
    e.RetinaImagePath = t, t.confirmed_paths = [], t.prototype.is_external = function () {
        return !!this.path.match(/^https?\:/i) && !this.path.match("//" + document.domain)
    }, t.prototype.check_2x_variant = function (e) {
        var n, r = this;
        if (this.is_external()) return e(!1);
        if (this.at_2x_path in t.confirmed_paths) return e(!0);
        n = new XMLHttpRequest, n.open("HEAD", this.at_2x_path), n.onreadystatechange = function () {
            return n.readyState != 4 ? e(!1) : n.status >= 200 && n.status <= 399 ? (t.confirmed_paths.push(r.at_2x_path), e(!0)) : e(!1)
        }, n.send()
    }, e.RetinaImage = n, n.prototype.swap = function (e) {
        function n() {
            t.el.complete ? (t.el.setAttribute("width", t.el.offsetWidth), t.el.setAttribute("height", t.el.offsetHeight), t.el.setAttribute("src", e)) : setTimeout(n, 5)
        }
        typeof e == "undefined" && (e = this.path.at_2x_path);
        var t = this;
        n()
    }, e.devicePixelRatio > 1 && (window.onload = function () {
        var e = document.getElementsByTagName("img"),
            t = [],
            r, i;
        for (r = 0; r < e.length; r++) i = e[r], t.push(new n(i))
    })
})();
/*-----------------------------------------------------------------------------------*/
/*	ISOTOPE PORTFOLIO
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    var $container = $('.portfolio-wrapper .items');
    $container.imagesLoaded(function () {
        $container.isotope({
            itemSelector: '.item',
            layoutMode: 'fitRows',
            resizable: false
        });

        var windowWidth = $(window).width();
        $(window).smartresize(function () {
            var newWindowWidth = $(window).width();
            if (newWindowWidth != windowWidth) {
                $('.portfolio-wrapper:not(.showcase) .items').isotope('reLayout');
                windowWidth = newWindowWidth;
            }
        });
    });

    $('.filter li a').click(function () {

        $('.filter li a').removeClass('active');
        $(this).addClass('active');

        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector
        });

        return false;
    });
});
/*-----------------------------------------------------------------------------------*/
/*	FANCYBOX
/*-----------------------------------------------------------------------------------*/
$(document).ready(function() {
	$(".fancybox-media").fancybox({
		arrows: true,
		padding: 0,
		closeBtn: true,
		openEffect: 'fade',
		closeEffect: 'fade',
		prevEffect: 'fade',
		nextEffect: 'fade',
		helpers: {
			media: {},
			overlay: {
		        locked: false
		    },
			buttons: false,
			thumbs: {
				width: 50,
				height: 50
			},
			title: {
				type: 'inside'
			}
		},
		beforeLoad: function() {
			var el, id = $(this.element).data('title-id');
			if (id) {
				el = $('#' + id);
				if (el.length) {
					this.title = el.html();
				}
			}
		}
	});
});
/*-----------------------------------------------------------------------------------*/
/*	FORM
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function ($) {
    $('.forms').dcSlickForms();
});
$(document).ready(function () {
    $('.comment-form input[title], .comment-form textarea').each(function () {
        if ($(this).val() === '') {
            $(this).val($(this).attr('title'));
        }

        $(this).focus(function () {
            if ($(this).val() == $(this).attr('title')) {
                $(this).val('').addClass('focused');
            }
        });
        $(this).blur(function () {
            if ($(this).val() === '') {
                $(this).val($(this).attr('title')).removeClass('focused');
            }
        });
    });
});
/*-----------------------------------------------------------------------------------*/
/*	TABS
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    $('.tabs').easytabs({
        animationSpeed: 300,
        updateHash: false
    });
});
/*-----------------------------------------------------------------------------------*/
/*	TESTIMONIALS
/*-----------------------------------------------------------------------------------*/
 $(document).ready( function() {
      $('#testimonials').easytabs({
	      animationSpeed: 500,
	      updateHash: false,
	      cycle: 5000
      });

    });
/*-----------------------------------------------------------------------------------*/
/*	TOGGLE
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    //Hide the tooglebox when page load
    $(".togglebox").hide();
    //slide up and down when click over heading 2
    $("h4").click(function () {
        // slide toggle effect set to slow you can set it to fast too.
        $(this).toggleClass("active").next(".togglebox").slideToggle("slow");
        return true;
    });
});
/*-----------------------------------------------------------------------------------*/
/*	VIDEO
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function () {
    jQuery('.video').fitVids();
});
/*-----------------------------------------------------------------------------------*/
/*	HOVER OPACITY
/*-----------------------------------------------------------------------------------*/
jQuery(document).ready(function ($) {
    $("ul.client-list li").css("opacity", "0.70");
    $("ul.client-list li").hover(function () {
        $(this).stop().animate({
            opacity: 1.0
        }, "fast");
    },

    function () {
        $(this).stop().animate({
            opacity: 0.70
        }, "fast");
    });
});
/*-----------------------------------------------------------------------------------*/
/*	SLIDER
/*-----------------------------------------------------------------------------------*/
$(document).ready(function() {
	if ($.fn.cssOriginal != undefined) $.fn.css = $.fn.cssOriginal;
	$('.banner').revolution({
		delay: 0,
		startheight: 460,
		startwidth: 1110,
		hideThumbs: 200,
		thumbWidth: 100,
		// Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
		thumbHeight: 50,
		thumbAmount: 5,
		navigationType: "bullet",
		// bullet, thumb, none
		navigationArrows: "verticalcentered",
		// nexttobullets, solo (old name verticalcentered), none
		navigationStyle: "round",
		// round,square,navbar,round-old,square-old,navbar-old, or any from the list in the docu (choose between 50+ different item), custom
		navigationHAlign: "center",
		// Vertical Align top,center,bottom
		navigationVAlign: "bottom",
		// Horizontal Align left,center,right
		navigationHOffset: 0,
		navigationVOffset: 20,
		soloArrowLeftHalign: "left",
		soloArrowLeftValign: "center",
		soloArrowLeftHOffset: 20,
		soloArrowLeftVOffset: 0,
		soloArrowRightHalign: "right",
		soloArrowRightValign: "center",
		soloArrowRightHOffset: 20,
		soloArrowRightVOffset: 0,
		touchenabled: "on",
		// Enable Swipe Function : on/off
		onHoverStop: "on",
		// Stop Banner Timet at Hover on Slide on/off
		stopAtSlide: -1,
		// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
		stopAfterLoops: -1,
		// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic
		hideCaptionAtLimit: 0,
		// It Defines if a caption should be shown under a Screen Resolution ( Basod on The Width of Browser)
		hideAllCaptionAtLilmit: 0,
		// Hide all The Captions if Width of Browser is less then this value
		hideSliderAtLimit: 0,
		// Hide the whole slider, and stop also functions if Width of Browser is less than this value
		shadow: 0,
		//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
		fullWidth: "on" // Turns On or Off the Fullwidth Image Centering in FullWidth Modus
	});
	$('.portfolio-banner').revolution({
		delay: 0,
		startheight: 550,
		startwidth: 1110,
		hideThumbs: 200,
		thumbWidth: 100,
		// Thumb With and Height and Amount (only if navigation Tyope set to thumb !)
		thumbHeight: 50,
		thumbAmount: 5,
		navigationType: "bullet",
		// bullet, thumb, none
		navigationArrows: "verticalcentered",
		// nexttobullets, solo (old name verticalcentered), none
		navigationStyle: "round",
		// round,square,navbar,round-old,square-old,navbar-old, or any from the list in the docu (choose between 50+ different item), custom
		navigationHAlign: "center",
		// Vertical Align top,center,bottom
		navigationVAlign: "bottom",
		// Horizontal Align left,center,right
		navigationHOffset: 0,
		navigationVOffset: 20,
		soloArrowLeftHalign: "left",
		soloArrowLeftValign: "center",
		soloArrowLeftHOffset: 20,
		soloArrowLeftVOffset: 0,
		soloArrowRightHalign: "right",
		soloArrowRightValign: "center",
		soloArrowRightHOffset: 20,
		soloArrowRightVOffset: 0,
		touchenabled: "on",
		// Enable Swipe Function : on/off
		onHoverStop: "on",
		// Stop Banner Timet at Hover on Slide on/off
		stopAtSlide: -1,
		// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
		stopAfterLoops: -1,
		// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic
		hideCaptionAtLimit: 0,
		// It Defines if a caption should be shown under a Screen Resolution ( Basod on The Width of Browser)
		hideAllCaptionAtLilmit: 0,
		// Hide all The Captions if Width of Browser is less then this value
		hideSliderAtLimit: 0,
		// Hide the whole slider, and stop also functions if Width of Browser is less than this value
		shadow: 0,
		//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
		fullWidth: "off" // Turns On or Off the Fullwidth Image Centering in FullWidth Modus
	});
});
/*-----------------------------------------------------------------------------------*/
/*	TOUCH CAROUSEL
/*-----------------------------------------------------------------------------------*/
jQuery(function($) {
			$(".touch-carousel").touchCarousel({
				pagingNav: false,
				snapToItems: false,
				itemsPerMove: 4,
				scrollToLast: false,
				loopItems: false,
				scrollbar: true
		    });
		});
/*-----------------------------------------------------------------------------------*/
/*	PORTFOLIO SHOWCASE
/*-----------------------------------------------------------------------------------*/
/**************************************************************************
 * jQuery Plugin for Showcase
 * @version: 1.0+
 * @requires jQuery v1.8 or later
 * @author ThunderBudies http://themeforest.net/user/Thunderbuddies/portfolio
 * @author Daniel Rudolf
 **************************************************************************/
$(function() {
    var $container = $('.portfolio-wrapper.showcase .items');
    var animationSpeed = 600;
    var scrollSpeed = 600;

    // wait until isotope is ready to roll...
    $container.imagesLoaded(function () {
        $container.find('.item').each(function() {
            var $item = $(this);

            // prepare deeplinking
            var itemName = $item.data('path');
            itemName = itemName.substring(itemName.lastIndexOf('/') + 1, itemName.lastIndexOf('.'));
            itemName = itemName.replace(/[^a-zA-Z0-9_.-]/g, '_');
            $item.attr('data-name', itemName);

            // click on items to open/close them
            $item.click(function(event) {
                event.preventDefault();

                var $item = $(this);
                if ($item.hasClass('active')) {
                    // close currently opened item
                    closeDetailView($item);
                } else {
                    var $pdv = $('body > .portfolio-detail-view');
                    if ($pdv.length) {
                        // there's currently another item opened; close it first
                        closeActiveDetailView(function () {
                            // open the new item afterwards
                            openDetailView($item);
                        });

                        // a detail view is being closed in this exact moment
                        // ignore the click event
                        return;
                    }

                    // open new item
                    openDetailView($item);
                }
            });
        });

        // close detail view when applying filters
        $('.portfolio-wrapper.showcase .filter *[data-filter]').each(function() {
            var $filter = $(this);
            $filter.click(function (event) {
                event.preventDefault();
                closeActiveDetailView();
            });
        });

        // close detail view when window is resized, but ignore changes in height
        var windowWidth = $(window).width();
        $(window).smartresize(function () {
            var newWindowWidth = $(window).width();
            if (newWindowWidth != windowWidth) {
                windowWidth = newWindowWidth;

                if (!closeActiveDetailView()) {
                    $container.isotope('reLayout');
                }
            }
        });

        // support deeplinking
        var deeplinkRegex = /^#entry-([a-zA-Z0-9_.-]+)$/;
        var deeplinkMatch = deeplinkRegex.exec(window.location.hash);
        if (deeplinkMatch) {
            var $deeplinkItem = $container.find('.item[data-name="' + deeplinkMatch[1] + '"]');
            if ($deeplinkItem.length) {
                $deeplinkItem.click();
            }
        }
    });

    function updateUrlHash(hash) {
        var scrollTop = $(document).scrollTop();
        window.location.hash = (hash && hash.length) ? '#' + hash : '';
        $(document).scrollTop(scrollTop);
    }

    function moveDetailView($item, $pdv) {
        var $pdcc = $pdv.find('.portfolio-detail-content-container');

        $pdv.css({ top: ($item.offset().top + $item.outerHeight(true)) + 'px' });

        $pdv.stop(true);
        $pdv.animate(
            { height: $pdcc.outerHeight(true) + 'px' },
            { duration: animationSpeed, queue: false }
        );
    }

    function moveItems(itemsToMove, offset) {
        // move items
        $.each(itemsToMove, function () {
            var $moveItem = $(this);
            $moveItem.stop(true);
            $moveItem.animate(
                { top: (offset + (parseInt($moveItem.data('topOffset') || 0))) + 'px' },
                { duration: animationSpeed, queue: false }
            );
        });

        // grow/shrink container
        if ($('html').hasClass('is-ie8') || $('html').hasClass('is-ie9')) {
            $container.stop(true);
            $container.animate(
                { height: ($container.data('height') + offset) + 'px' },
                { duration: animationSpeed, queue: false }
            );
        } else {
            $container.css({ height: ($container.data('height') + offset) + 'px' });
        }
    }

    function openDetailView($item, callback) {
        // mark item as active
        $item.addClass('active');
        updateUrlHash('entry-' + $item.data('name'));

        // append detail view to body
        var $pdv = $(
            '<div class="portfolio-detail-view ' + ($item.data('layout') || '') + '">' +
            '<div class="inner">' +
            '<div class="portfolio-detail-content-container">' +
            $item.data('detailcontent') +
            '</div>' +
            '</div>' +
            '<div class="closebutton"><i class="icon-cancel-1"></i></div>' +
            '</div>'
        ).appendTo('body');

        var $pdcc = $pdv.find('.portfolio-detail-content-container'),
            pdvMargin = parseInt($pdv.css('marginTop'), 0) + parseInt($pdv.css('marginBottom'), 0);

        // init close button
        $pdv.find('.closebutton').click(function (event) {
            event.preventDefault();
            closeDetailView($item);
        });

        // unique ID of this detail view
        var processId = (parseInt($container.data('process')) || 0) + 1;
        $container.data('processId', processId);

        // remember the container's height to calculate the final height with the opened detail view
        $container.data('height', $container.height());

        // determine which items must be moved
        var itemsToMove = [],
            itemPosition = $item.position().top;
        $container.find('.item').each(function () {
            var $checkItem = $(this);
            if ($checkItem.position().top > itemPosition) {
                itemsToMove.push($checkItem);
            }
        });

        $pdv.data('itemsToMove', itemsToMove);

        // fix position of moved items in <= IE9
        if ($('html').hasClass('is-ie8') || $('html').hasClass('is-ie9')) {
            $.each(itemsToMove, function () {
                var $moveItem = $(this);
                $moveItem.data('topOffset', $moveItem.position().top);
            });
        }

        // scroll to the item
        $('html, body').animate(
            { scrollTop: $item.offset().top - 10 },
            { duration: scrollSpeed, queue: false }
        );

        // open the detail view
        moveDetailView($item, $pdv);
        moveItems($pdv.data('itemsToMove'), $pdcc.outerHeight(true) + pdvMargin);

        // fire item callback
        if ($item.data('callback')) {
            try {
                var itemCallback = new Function($item.data('callback'));
                itemCallback();
            } catch (e) {}
        }

        // init carousel
        $pdcc.find('.carousel').each(function () {
            $(this).carousel({
                interval: 4000
            });
        });

        // update detail view height after all images have been loaded
        $pdcc.imagesLoaded(function () {
            if ($item.hasClass('active') && (processId == $container.data('processId'))) {
                moveDetailView($item, $pdv);
                moveItems($pdv.data('itemsToMove'), $pdcc.outerHeight(true) + pdvMargin);
            }
        });

        // fire finish callback
        if (callback) {
            // FIXME: this can't be trusted... jQuery animations suck
            setTimeout(function () { callback($item); }, animationSpeed + 50);
        }
    }

    function closeDetailView($item, callback) {
        // unmark active item
        $item.removeClass('active');
        updateUrlHash();

        var $pdv = $('body > .portfolio-detail-view');
        if ($pdv.length) {
            var completeCallback = function () {
                // let isotope recalculate container height
                // jQuery fucks this up for some reason...
                $container.isotope('reLayout', function () {
                    $pdv.remove();

                    if (callback) {
                        setTimeout(function () { callback($item); }, 50);
                    }
                });
            };

            // reset item position
            moveItems($pdv.data('itemsToMove'), 0);

            // close pdv
            $pdv.stop(true);
            $pdv.animate(
                { height: '0px', opacity: 0 },
                { duration: animationSpeed, queue: false, complete: completeCallback }
            );

            return;
        }

        if (callback) {
            callback($item);
        }
    }

    function closeActiveDetailView(callback) {
        $activeItem = $container.find('.item.active');
        if ($activeItem.length) {
            closeDetailView($activeItem, callback);
            return true;
        }
        return false;
    }
});
/*-----------------------------------------------------------------------------------*/
/*	TWITTER
/*-----------------------------------------------------------------------------------*/
getTwitters('twitter', {
    id: 'elemisdesign',
    count: 1,
    enableLinks: true,
    ignoreReplies: false,
    template: '<span class="twitterPrefix"><span class="twitterStatus">%text%</span><br /><em class="twitterTime"><a href="http://twitter.com/%user_screen_name%/statuses/%id_str%">%time%</a></em>',
    newwindow: true
});
/*-----------------------------------------------------------------------------------*/
/*	SELECTNAV
/*-----------------------------------------------------------------------------------*/
$(document).ready(function () {
    selectnav('tiny', {
        label: '--- Navigation --- ',
        indent: '-'
    });
});
/*-----------------------------------------------------------------------------------*/
/*	MENU
/*-----------------------------------------------------------------------------------*/
ddsmoothmenu.init({
    mainmenuid: "menu",
    orientation: 'h',
    classname: 'menu',
    contentsource: "markup"
})
