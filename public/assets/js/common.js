
//
// accordion switch pc sp
//
$(window).load(function(e) {	
	$.fn.accor = function(e){
		var set = $.extend({
										//btnAcc: ".btn_accor",
										conAcc: ".con_accor",
										souLaval: false /* true false */
									},e);
									
		$(this).click(function(){
		$(set.conAcc).slideUp();
		$(this).removeClass("open").addClass("close");//.removeAttr("class").addClass("close");
		var Disp ="";
		if(set.souLaval == true){			
			Disp = $(this).next().css("display");
		}else{
			Disp = $(this).parent().next().css("display");
		}
		//console.log(Disp);
		if(Disp != "block"){
			if(set.souLaval == true){
				$(this).next().slideDown();
			}else{				
				$(this).parent().next().slideDown();
			}			
			$(this).removeClass("close").addClass("open");//.removeAttr("class").addClass("open");
		};
		
		return false;
		});
	};/* End Function */
});
//
// scrollUp
//
$(window).load(function(e) {
	//$.scrollUp({
//				animation: 'fade',
//				scrollImg: {
//						active: true,
//						type: 'background',
//						src: '../common/images/common/pagetop.png'
//				}
//		});
});
//imghover/////////////////////////////////////////////////////////////////////////////////
$(function()
{
	//$("h1").append($(window).width());
	initRollovers();//ロールオーバー

	/*initTabs();	*/			// タブの初期化

	$(".imghover").hover(animateKesu,animateDasu); //ふわっと消す 

	$(".imghoverMore").hover(animateKesuMore,animateDasuMore); //ふわっと背景画像を表示させる 

	$("table tr:even").addClass("alt");//テーブルにクラス命名
	//	$("div table td[rowspan]").css("background-color", "#ffffff");



});
// smoothScrolling
$(function(){
	$(".smooth a").click(function(){
		var speed = 500;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		$("html, body").animate({scrollTop:position}, speed, "swing");
		return false;
	});
});

//
// acordion
//
$(document).ready(function(){
	var timing = "slow";
	
	// サブメニューを一旦非表示に
	$(".drop").css("display", "none");
	$(".acordion").hover(
		function(){
			// マウスホバー時
			var container = $(this);
			if (!container.hasClass("active")){
				container.addClass("active");
				$(">.drop", this).stop(true, true).slideDown(timing);
			}else{
				$(">.drop", this).slideDown(timing);
			}
		},
		function(){
			// マウスホバーアウト時
			var container = $(this);
			$(">.drop", this).stop(true, true).slideUp(timing, function() { container.removeClass("active"); });
		}
	);
});




///////////////////////////////////////////////////////////////////////////////////////////
//  ふわっと消す
function animateKesu(){
	    $(this).stop().fadeTo(300,0.5);
	//$(this).stop().animate({opacity: 1.0, marginTop:'-5px',marginBottom:'5px'}, 100);
	    //スピード指定、透明度の指定
	    }
function animateDasu(){
	    $(this).stop().fadeTo(200,1.0);
	//$(this).stop().animate({opacity: 1.0, marginTop:'-5px',marginBottom:'5px'}, 100);
	    //スピード指定、透明度の指定
	    }

///////////////////////////////////////////////////////////////////////////////////////////
//  ふわっと背景画像を表示させる
function animateKesuMore(){
	    $(this).stop().fadeTo(300,0);
	    //スピード指定、透明度の指定
	    }
function animateDasuMore(){
	    $(this).stop().fadeTo(200,1.0);
	    //スピード指定、透明度の指定
	    }

///////////////////////////////////////////////////////////////////////////////////////////
//  ロールオーバースクリプト
//　Standards Compliant Rollover Script
//　Author : Daniel Nolan
//　http://www.bleedingego.co.uk/webdev.php

function initRollovers() {
	if (!document.getElementById) return
	
	var aPreLoad = new Array();
	var sTempSrc;
	var aImages = document.getElementsByTagName('img');

	for (var i = 0; i < aImages.length; i++) {		
		if (aImages[i].className == 'imgover') {
			var src = aImages[i].getAttribute('src');
			var ftype = src.substring(src.lastIndexOf('.'), src.length);
			var hsrc = src.replace(ftype, '_o'+ftype);

			aImages[i].setAttribute('hsrc', hsrc);
			
			aPreLoad[i] = new Image();
			aPreLoad[i].src = hsrc;
			
			aImages[i].onmouseover = function() {
				sTempSrc = this.getAttribute('src');
				this.setAttribute('src', this.getAttribute('hsrc'));
			}	
			
			aImages[i].onmouseout = function() {
				if (!sTempSrc) sTempSrc = this.getAttribute('src').replace('_o'+ftype, ftype);
				this.setAttribute('src', sTempSrc);
			}
		}
	}
}

/* acordion-end ------------------------------------------------------- */

/*	function initTabs() {
		$("ul.tabs").jTabs({ "content": ".tabs_content", "animate": true });
	}
*/
// フッタアコーディオン設定
	$(document).on("click", "a.open-close", function(e) {
		var tgt = $(e.currentTarget);
		if (tgt.hasClass("open")) {
			$("+.acordion_tree", tgt).hide();
			tgt.removeClass("open");
		} else {
			var pos = tgt.offset().top;
			$("body,html").animate({ "scrollTop": pos }, 400, "swing");
			$("+.acordion_tree", tgt).show();
			tgt.addClass("open");
		}
		return false;
	});

	$(document).on("click", "a.trigger_link", function(e) {
		var href = $(e.currentTarget).attr("href") || "#";
		location.href = href;
		return false;
	});


$(function() {
	$(".tn_btn_maxheight").on("click", function() {
		var mh_father = $(this).parent(".tn_box_maxheight")
		if (mh_father.hasClass("open")) {
			mh_father.removeClass("open");
			$(this).html("...続き&raquo;");
		} else {
			mh_father.addClass("open");
			$(this).html("閉じる");
		}
	});

	$(".acco_box .acco_a").on("click", function() {
		$(this).toggleClass('opened');
		$(this).next('.acco_dv').slideToggle('slow');
	});

	$(".first").show();
	$(document).on("click", ".trigger", function(e) {
		if ($("+.acordion_tree", this).css("display") == "none") {
			if (!$(this).hasClass("active")) $(this).addClass("active");
			$(".open-close", $(this)).html("CLOSE");
			$("+.acordion_tree", this).slideDown("normal");
		} else {
			if ($(this).hasClass("active")) $(this).removeClass("active");
			$(".open-close", $(this)).html("OPEN");
			$("+.acordion_tree", this).slideUp("normal");
		}
		return false;
	});
});

// PC SP 画像切り替え /////////////////////////////////////////////////////
$(function(){
	var $setElem = $('.switch'),
	pcName = '_pc',
	spName = '_sp',
	replaceWidth = 770;

	$setElem.each(function(){
		var $this = $(this);
		function imgSize(){
			var windowWidth = parseInt($(window).width());
			if(windowWidth >= replaceWidth) {
				$this.attr('src',$this.attr('src').replace(spName,pcName)).css({visibility:'visible'});
			} else if(windowWidth < replaceWidth) {
				$this.attr('src',$this.attr('src').replace(pcName,spName)).css({visibility:'visible'});
			}
		}
		$(window).resize(function(){imgSize();});
		imgSize();
	});
});



//// スムーズスクロール
//$(function(){
//	// ページ内リンクをクリックすると
//	$('a[href^=#]').click(function(){
// 		// スクロールスピード
// 		var speed = 500;
// 		// クリックしたリンク先を保存
//		var href= $(this).attr("href");
//		// リンク先へスムーズに移動する
//		$("html, body").animate({scrollTop:position}, speed, "swing");
//		return false;
//	});
//});


// ページTOP表示
$(function() {
    var topBtn = $('#bk_top a');    
   // topBtn.hide();
    //スクロールが250に達したらボタン表示
   // $(window).scroll(function () {
//        if ($(this).scrollTop() > 50) {
//            topBtn.fadeIn();
//        } else {
//            topBtn.fadeOut();
//        }
//    });
    //スクロールしてトップ
    topBtn.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});


/**
* NG Responsive Tables v1.0
* Inspiration: http://css-tricks.com/examples/ResponsiveTables/responsive.php
* Author: Tomislav Matijević
* List of functions:
*	- targetTable: Searches for each table row , find td and take its current index.
*      Apply to that index same index of table head or td in first table row ( in case there are no table header applied )
*	- checkForTableHead: If there is no table head defined, use td in first table row as table head (prevention mode)
* Config:
* - Adjust paddings
* - On each td there is class named "tdno[index]", so you can modify each td if you need custom padding
*/

;(function ( $ ) {
	$.fn.ngResponsiveTables = function(options) {
		var defaults = {
		smallPaddingCharNo: 5,
		mediumPaddingCharNo: 10,
		largePaddingCharNo: 15
		},
		$selElement = this,
		ngResponsiveTables = {
			opt: '',
			dataContent: '',
			globalWidth: 0,
		init: function(){
			this.opt = $.extend( defaults, options );
			ngResponsiveTables.targetTable();
		},
		targetTable: function(){
			var that = this;
			$selElement.find('tr').each(function(){
				$(this).find('td').each(function(i, v){
					that.checkForTableHead( $(this), i );
					$(this).addClass('tdno' + i);
				});
			});
		},
		checkForTableHead: function(element, index){
			if( $selElement.find('th').length ){
				this.dataContent = $selElement.find('th')[index].textContent;
			}else{
				this.dataContent = $selElement.find('tr:first td')[index].textContent;
			}
			// This padding is for large texts inside header of table
			// Use small, medium and large paddingMax values from defaults to set-up offsets for each class
			if( this.opt.smallPaddingCharNo > $.trim(this.dataContent).length ){
				element.addClass('small-padding');
			}else if( this.opt.mediumPaddingCharNo > $.trim(this.dataContent).length ){
				element.addClass('medium-padding');
			}else{
				element.addClass('large-padding');
			}
			element.attr('data-content', this.dataContent);
		}
	};

	$(function(){
		ngResponsiveTables.init();
	});
		return this;
	};
	
}( jQuery ));


//要素の高さを揃える/////////////////////////////////////////////////////////////////////
/**
 * Plugin: equalbox
 * 
 * Version: 1.0
 * (c) Copyright 2011, Jose Erlino Lontok and Myhedspace.com
 * 
 * Description: A simple jQuery solution that will make sure that related and adjacent columns are of the same height. 
 *
 **/

(function( $ ){
	
	/* equalbox */
	$.fn.equalbox = function(e){
		var settings = $.extend({
										eqName:".eq"
									},e);
		$(this).each(function(e){
			var bigHeight = 0;
			
			$(settings.eqName, $(this)).each(function(){
			
				$this = $(this);
				
				if($this.height() > bigHeight){
					bigHeight = $this.height();
				}
				
			});
			
			return $(settings.eqName,$(this)).css("height", bigHeight);
			
		});

	};/* End Function */
	
	/* toggle */
	$.fn.toggles = function(e){
		
		var settings = $.extend({
										content: ".dropdown-container",
										btnLink: ".dropdown-link",
										btnType: "img",
										pressOff: "../common_img/arrow_off.gif",
										pressOn:"../common_img/arrow_on.gif",
										boxObj:"span",
										onlyOne: true,
										speed:1000
									},e);
		
		
		$(settings.content,".select").css("display","block");
		var chImage = settings.btnLink+" span";
		$(settings.boxObj+" "+settings.btnType,".select").attr("src",settings.pressOn);

		
		var selectOld = $(settings.content,".select").next(settings.content);
		$(settings.content).not(function(selectOld){
			$(settings.content).not(function($div){
				$(settings.content).css("display","none");
			})
		});
		
		$(this).click(function(e) {
			e.preventDefault();
			var $div = $(this).next(settings.content);
			
			switch (settings.btnType){
				case "img":
						if(settings.onlyOne == true){
							$(settings.content).not(function($div){
								$(settings.content).slideUp(settings.speed);
								$(settings.boxObj+" "+settings.btnType,settings.btnLink).attr("src",settings.pressOff);
							})
						}
						if ($div.is(":visible")) {
							$div.slideUp(settings.speed);
							$(settings.boxObj+" "+settings.btnType,this).attr("src",settings.pressOff);
						} else {
							$div.slideDown(settings.speed);
							$(settings.boxObj+" "+settings.btnType,this).attr("src",settings.pressOn);
						}
					break;
					
				default:
						if(settings.onlyOne == true){
							$(settings.content).not(function($div){
								$(settings.content).slideUp(settings.speed);
								$(settings.btnType,settings.btnLink).text(settings.pressOff);
							})
						}
						if ($div.is(":visible")) {
							$div.slideUp(settings.speed);
							$(settings.btnType,this).text(settings.pressOff);
						} else {
							$div.slideDown(settings.speed);
							$(settings.btnType,this).text(settings.pressOn);
						}
					break;
			} // End Switch
		
		
		});//End Click
		
		
	};/* End Function */
})( jQuery );

/*
 * ScrollToFixed
 * https://github.com/bigspotteddog/ScrollToFixed
 * 
 * Copyright (c) 2011 Joseph Cava-Lynch
 * MIT license
 */
(function($) {
    $.isScrollToFixed = function(el) {
        return !!$(el).data('ScrollToFixed');
    };

    $.ScrollToFixed = function(el, options) {
        // To avoid scope issues, use 'base' instead of 'this' to reference this
        // class from internal events and functions.
        var base = this;

        // Access to jQuery and DOM versions of element.
        base.$el = $(el);
        base.el = el;

        // Add a reverse reference to the DOM object.
        base.$el.data('ScrollToFixed', base);

        // A flag so we know if the scroll has been reset.
        var isReset = false;

        // The element that was given to us to fix if scrolled above the top of
        // the page.
        var target = base.$el;

        var position;
        var originalPosition;
        var originalOffsetTop;
        var originalZIndex;

        // The offset top of the element when resetScroll was called. This is
        // used to determine if we have scrolled past the top of the element.
        var offsetTop = 0;

        // The offset left of the element when resetScroll was called. This is
        // used to move the element left or right relative to the horizontal
        // scroll.
        var offsetLeft = 0;
        var originalOffsetLeft = -1;

        // This last offset used to move the element horizontally. This is used
        // to determine if we need to move the element because we would not want
        // to do that for no reason.
        var lastOffsetLeft = -1;

        // This is the element used to fill the void left by the target element
        // when it goes fixed; otherwise, everything below it moves up the page.
        var spacer = null;

        var spacerClass;

        var className;

        // Capture the original offsets for the target element. This needs to be
        // called whenever the page size changes or when the page is first
        // scrolled. For some reason, calling this before the page is first
        // scrolled causes the element to become fixed too late.
        function resetScroll() {
            // Set the element to it original positioning.
            target.trigger('preUnfixed.ScrollToFixed');
            setUnfixed();
            target.trigger('unfixed.ScrollToFixed');

            // Reset the last offset used to determine if the page has moved
            // horizontally.
            lastOffsetLeft = -1;

            // Capture the offset top of the target element.
            offsetTop = target.offset().top;

            // Capture the offset left of the target element.
            offsetLeft = target.offset().left;

            // If the offsets option is on, alter the left offset.
            if (base.options.offsets) {
                offsetLeft += (target.offset().left - target.position().left);
            }

            if (originalOffsetLeft == -1) {
                originalOffsetLeft = offsetLeft;
            }

            position = target.css('position');

            // Set that this has been called at least once.
            isReset = true;

            if (base.options.bottom != -1) {
                target.trigger('preFixed.ScrollToFixed');
                setFixed();
                target.trigger('fixed.ScrollToFixed');
            }
        }

        function getLimit() {
            var limit = base.options.limit;
            if (!limit) return 0;

            if (typeof(limit) === 'function') {
                return limit.apply(target);
            }
            return limit;
        }

        // Returns whether the target element is fixed or not.
        function isFixed() {
            return position === 'fixed';
        }

        // Returns whether the target element is absolute or not.
        function isAbsolute() {
            return position === 'absolute';
        }

        function isUnfixed() {
            return !(isFixed() || isAbsolute());
        }

        // Sets the target element to fixed. Also, sets the spacer to fill the
        // void left by the target element.
        function setFixed() {
            // Only fix the target element and the spacer if we need to.
            if (!isFixed()) {
                // Set the spacer to fill the height and width of the target
                // element, then display it.
                spacer.css({
                    'display' : target.css('display'),
                    'width' : target.outerWidth(true),
                    'height' : target.outerHeight(true),
                    'float' : target.css('float')
                });

                // Set the target element to fixed and set its width so it does
                // not fill the rest of the page horizontally. Also, set its top
                // to the margin top specified in the options.

                cssOptions={
                    'z-index' : base.options.zIndex,
                    'position' : 'fixed',
                    'top' : base.options.bottom == -1?getMarginTop():'',
                    'bottom' : base.options.bottom == -1?'':base.options.bottom,
                    'margin-left' : '0px'
                }
                if (!base.options.dontSetWidth){ cssOptions['width']=target.width(); };

                target.css(cssOptions);
                
                target.addClass(base.options.baseClassName);
                
                if (base.options.className) {
                    target.addClass(base.options.className);
                }

                position = 'fixed';
            }
        }

        function setAbsolute() {

            var top = getLimit();
            var left = offsetLeft;

            if (base.options.removeOffsets) {
                left = '';
                top = top - offsetTop;
            }

            cssOptions={
              'position' : 'absolute',
              'top' : top,
              'left' : left,
              'margin-left' : '0px',
              'bottom' : ''
            }
            if (!base.options.dontSetWidth){ cssOptions['width']=target.width(); };

            target.css(cssOptions);

            position = 'absolute';
        }

        // Sets the target element back to unfixed. Also, hides the spacer.
        function setUnfixed() {
            // Only unfix the target element and the spacer if we need to.
            if (!isUnfixed()) {
                lastOffsetLeft = -1;

                // Hide the spacer now that the target element will fill the
                // space.
                spacer.css('display', 'none');

                // Remove the style attributes that were added to the target.
                // This will reverse the target back to the its original style.
                target.css({
                    'z-index' : originalZIndex,
                    'width' : '',
                    'position' : originalPosition,
                    'left' : '',
                    'top' : originalOffsetTop,
                    'margin-left' : ''
                });

                target.removeClass('scroll-to-fixed-fixed');

                if (base.options.className) {
                    target.removeClass(base.options.className);
                }

                position = null;
            }
        }

        // Moves the target element left or right relative to the horizontal
        // scroll position.
        function setLeft(x) {
            // Only if the scroll is not what it was last time we did this.
            if (x != lastOffsetLeft) {
                // Move the target element horizontally relative to its original
                // horizontal position.
                target.css('left', offsetLeft - x);

                // Hold the last horizontal position set.
                lastOffsetLeft = x;
            }
        }

        function getMarginTop() {
            var marginTop = base.options.marginTop;
            if (!marginTop) return 0;

            if (typeof(marginTop) === 'function') {
                return marginTop.apply(target);
            }
            return marginTop;
        }

        // Checks to see if we need to do something based on new scroll position
        // of the page.
        function checkScroll() {
            if (!$.isScrollToFixed(target)) return;
            var wasReset = isReset;

            // If resetScroll has not yet been called, call it. This only
            // happens once.
            if (!isReset) {
                resetScroll();
            } else if (isUnfixed()) {
                // if the offset has changed since the last scroll,
                // we need to get it again.

                // Capture the offset top of the target element.
                offsetTop = target.offset().top;

                // Capture the offset left of the target element.
                offsetLeft = target.offset().left;
            }

            // Grab the current horizontal scroll position.
            var x = $(window).scrollLeft();

            // Grab the current vertical scroll position.
            var y = $(window).scrollTop();

            // Get the limit, if there is one.
            var limit = getLimit();

            // If the vertical scroll position, plus the optional margin, would
            // put the target element at the specified limit, set the target
            // element to absolute.
            if (base.options.minWidth && $(window).width() < base.options.minWidth) {
                if (!isUnfixed() || !wasReset) {
                    postPosition();
                    target.trigger('preUnfixed.ScrollToFixed');
                    setUnfixed();
                    target.trigger('unfixed.ScrollToFixed');
                }
            } else if (base.options.maxWidth && $(window).width() > base.options.maxWidth) {
                if (!isUnfixed() || !wasReset) {
                    postPosition();
                    target.trigger('preUnfixed.ScrollToFixed');
                    setUnfixed();
                    target.trigger('unfixed.ScrollToFixed');
                }
            } else if (base.options.bottom == -1) {
                // If the vertical scroll position, plus the optional margin, would
                // put the target element at the specified limit, set the target
                // element to absolute.
                if (limit > 0 && y >= limit - getMarginTop()) {
                    if (!isAbsolute() || !wasReset) {
                        postPosition();
                        target.trigger('preAbsolute.ScrollToFixed');
                        setAbsolute();
                        target.trigger('unfixed.ScrollToFixed');
                    }
                // If the vertical scroll position, plus the optional margin, would
                // put the target element above the top of the page, set the target
                // element to fixed.
                } else if (y >= offsetTop - getMarginTop()) {
                    if (!isFixed() || !wasReset) {
                        postPosition();
                        target.trigger('preFixed.ScrollToFixed');

                        // Set the target element to fixed.
                        setFixed();

                        // Reset the last offset left because we just went fixed.
                        lastOffsetLeft = -1;

                        target.trigger('fixed.ScrollToFixed');
                    }
                    // If the page has been scrolled horizontally as well, move the
                    // target element accordingly.
                    setLeft(x);
                } else {
                    // Set the target element to unfixed, placing it where it was
                    // before.
                    if (!isUnfixed() || !wasReset) {
                        postPosition();
                        target.trigger('preUnfixed.ScrollToFixed');
                        setUnfixed();
                        target.trigger('unfixed.ScrollToFixed');
                    }
                }
            } else {
                if (limit > 0) {
                    if (y + $(window).height() - target.outerHeight(true) >= limit - (getMarginTop() || -getBottom())) {
                        if (isFixed()) {
                            postPosition();
                            target.trigger('preUnfixed.ScrollToFixed');

                            if (originalPosition === 'absolute') {
                                setAbsolute();
                            } else {
                                setUnfixed();
                            }

                            target.trigger('unfixed.ScrollToFixed');
                        }
                    } else {
                        if (!isFixed()) {
                            postPosition();
                            target.trigger('preFixed.ScrollToFixed');
                            setFixed();
                        }
                        setLeft(x);
                        target.trigger('fixed.ScrollToFixed');
                    }
                } else {
                    setLeft(x);
                }
            }
        }

        function getBottom() {
            if (!base.options.bottom) return 0;
            return base.options.bottom;
        }

        function postPosition() {
            var position = target.css('position');

            if (position == 'absolute') {
                target.trigger('postAbsolute.ScrollToFixed');
            } else if (position == 'fixed') {
                target.trigger('postFixed.ScrollToFixed');
            } else {
                target.trigger('postUnfixed.ScrollToFixed');
            }
        }

        var windowResize = function(event) {
            // Check if the element is visible before updating it's position, which
            // improves behavior with responsive designs where this element is hidden.
            if(target.is(':visible')) {
                isReset = false;
                checkScroll();
            }
        }

        var windowScroll = function(event) {
            (!!window.requestAnimationFrame) ? requestAnimationFrame(checkScroll) : checkScroll();
        }

        // From: http://kangax.github.com/cft/#IS_POSITION_FIXED_SUPPORTED
        var isPositionFixedSupported = function() {
            var container = document.body;

            if (document.createElement && container && container.appendChild && container.removeChild) {
                var el = document.createElement('div');

                if (!el.getBoundingClientRect) return null;

                el.innerHTML = 'x';
                el.style.cssText = 'position:fixed;top:100px;';
                container.appendChild(el);

                var originalHeight = container.style.height,
                originalScrollTop = container.scrollTop;

                container.style.height = '3000px';
                container.scrollTop = 500;

                var elementTop = el.getBoundingClientRect().top;
                container.style.height = originalHeight;

                var isSupported = (elementTop === 100);
                container.removeChild(el);
                container.scrollTop = originalScrollTop;

                return isSupported;
            }

            return null;
        }

        var preventDefault = function(e) {
            e = e || window.event;
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.returnValue = false;
        }

        // Initializes this plugin. Captures the options passed in, turns this
        // off for devices that do not support fixed position, adds the spacer,
        // and binds to the window scroll and resize events.
        base.init = function() {
            // Capture the options for this plugin.
            base.options = $.extend({}, $.ScrollToFixed.defaultOptions, options);

            originalZIndex = target.css('z-index')

            // Turn off this functionality for devices that do not support it.
            // if (!(base.options && base.options.dontCheckForPositionFixedSupport)) {
            //     var fixedSupported = isPositionFixedSupported();
            //     if (!fixedSupported) return;
            // }

            // Put the target element on top of everything that could be below
            // it. This reduces flicker when the target element is transitioning
            // to fixed.
            base.$el.css('z-index', base.options.zIndex);

            // Create a spacer element to fill the void left by the target
            // element when it goes fixed.
            spacer = $('<div />');

            position = target.css('position');
            originalPosition = target.css('position');

            originalOffsetTop = target.css('top');

            // Place the spacer right after the target element.
            if (isUnfixed()) base.$el.after(spacer);

            // Reset the target element offsets when the window is resized, then
            // check to see if we need to fix or unfix the target element.
            $(window).bind('resize.ScrollToFixed', windowResize);

            // When the window scrolls, check to see if we need to fix or unfix
            // the target element.
            $(window).bind('scroll.ScrollToFixed', windowScroll);

            // For touch devices, call checkScroll directlly rather than
            // rAF wrapped windowScroll to animate the element
            if ('ontouchmove' in window) {
              $(window).bind('touchmove.ScrollToFixed', checkScroll);
            }

            if (base.options.preFixed) {
                target.bind('preFixed.ScrollToFixed', base.options.preFixed);
            }
            if (base.options.postFixed) {
                target.bind('postFixed.ScrollToFixed', base.options.postFixed);
            }
            if (base.options.preUnfixed) {
                target.bind('preUnfixed.ScrollToFixed', base.options.preUnfixed);
            }
            if (base.options.postUnfixed) {
                target.bind('postUnfixed.ScrollToFixed', base.options.postUnfixed);
            }
            if (base.options.preAbsolute) {
                target.bind('preAbsolute.ScrollToFixed', base.options.preAbsolute);
            }
            if (base.options.postAbsolute) {
                target.bind('postAbsolute.ScrollToFixed', base.options.postAbsolute);
            }
            if (base.options.fixed) {
                target.bind('fixed.ScrollToFixed', base.options.fixed);
            }
            if (base.options.unfixed) {
                target.bind('unfixed.ScrollToFixed', base.options.unfixed);
            }

            if (base.options.spacerClass) {
                spacer.addClass(base.options.spacerClass);
            }

            target.bind('resize.ScrollToFixed', function() {
                spacer.height(target.height());
            });

            target.bind('scroll.ScrollToFixed', function() {
                target.trigger('preUnfixed.ScrollToFixed');
                setUnfixed();
                target.trigger('unfixed.ScrollToFixed');
                checkScroll();
            });

            target.bind('detach.ScrollToFixed', function(ev) {
                preventDefault(ev);

                target.trigger('preUnfixed.ScrollToFixed');
                setUnfixed();
                target.trigger('unfixed.ScrollToFixed');

                $(window).unbind('resize.ScrollToFixed', windowResize);
                $(window).unbind('scroll.ScrollToFixed', windowScroll);

                target.unbind('.ScrollToFixed');

                //remove spacer from dom
                spacer.remove();

                base.$el.removeData('ScrollToFixed');
            });

            // Reset everything.
            windowResize();
        };

        // Initialize the plugin.
        base.init();
    };

    // Sets the option defaults.
    $.ScrollToFixed.defaultOptions = {
        marginTop : 0,
        limit : 0,
        bottom : -1,
        zIndex : 1000,
        baseClassName: 'scroll-to-fixed-fixed'
    };

    // Returns enhanced elements that will fix to the top of the page when the
    // page is scrolled.
    $.fn.scrollToFixed = function(options) {
        return this.each(function() {
            (new $.ScrollToFixed(this, options));
        });
    };
})(jQuery);


/*!
 * scrollup v2.4.0
 * Url: http://markgoodyear.com/labs/scrollup/
 * Copyright (c) Mark Goodyear — @markgdyr — http://markgoodyear.com
 * License: MIT
 */
(function ($, window, document) {
    'use strict';

    // Main function
    $.fn.scrollUp = function (options) {

        // Ensure that only one scrollUp exists
        if (!$.data(document.body, 'scrollUp')) {
            $.data(document.body, 'scrollUp', true);
            $.fn.scrollUp.init(options);
        }
    };

    // Init
    $.fn.scrollUp.init = function (options) {

        // Define vars
        var o = $.fn.scrollUp.settings = $.extend({}, $.fn.scrollUp.defaults, options),
            triggerVisible = false,
            animIn, animOut, animSpeed, scrollDis, scrollEvent, scrollTarget, $self;

        // Create element
        if (o.scrollTrigger) {
            $self = $(o.scrollTrigger);
        } else {
            $self = $('<a/>', {
                id: o.scrollName,
                href: '#top'
            });
        }

        // Set scrollTitle if there is one
        if (o.scrollTitle) {
            $self.attr('title', o.scrollTitle);
        }

        $self.appendTo('body');

        // If not using an image display text
        if (!(o.scrollImg || o.scrollTrigger)) {
            $self.html(o.scrollText);
        }

        // Minimum CSS to make the magic happen
        $self.css({
            display: 'none',
            position: 'fixed',
            zIndex: o.zIndex
        });

        // Active point overlay
        if (o.activeOverlay) {
            $('<div/>', {
                id: o.scrollName + '-active'
            }).css({
                position: 'absolute',
                'top': o.scrollDistance + 'px',
                width: '100%',
                borderTop: '1px dotted' + o.activeOverlay,
                zIndex: o.zIndex
            }).appendTo('body');
        }

        // Switch animation type
        switch (o.animation) {
            case 'fade':
                animIn = 'fadeIn';
                animOut = 'fadeOut';
                animSpeed = o.animationSpeed;
                break;

            case 'slide':
                animIn = 'slideDown';
                animOut = 'slideUp';
                animSpeed = o.animationSpeed;
                break;

            default:
                animIn = 'show';
                animOut = 'hide';
                animSpeed = 0;
        }

        // If from top or bottom
        if (o.scrollFrom === 'top') {
            scrollDis = o.scrollDistance;
        } else {
            scrollDis = $(document).height() - $(window).height() - o.scrollDistance;
        }

        // Scroll function
        scrollEvent = $(window).scroll(function () {
            if ($(window).scrollTop() > scrollDis) {
                if (!triggerVisible) {
                    $self[animIn](animSpeed);
                    triggerVisible = true;
                }
            } else {
                if (triggerVisible) {
                    $self[animOut](animSpeed);
                    triggerVisible = false;
                }
            }
        });

        if (o.scrollTarget) {
            if (typeof o.scrollTarget === 'number') {
                scrollTarget = o.scrollTarget;
            } else if (typeof o.scrollTarget === 'string') {
                scrollTarget = Math.floor($(o.scrollTarget).offset().top);
            }
        } else {
            scrollTarget = 0;
        }

        // To the top
        $self.click(function (e) {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: scrollTarget
            }, o.scrollSpeed, o.easingType);
        });
    };

    // Defaults
    $.fn.scrollUp.defaults = {
        scrollName: 'scrollUp',      // Element ID
        scrollDistance: 600,         // Distance from top/bottom before showing element (px)
        scrollFrom: 'top',           // 'top' or 'bottom'
        scrollSpeed: 300,            // Speed back to top (ms)
        easingType: 'linear',        // Scroll to top easing (see http://easings.net/)
        animation: 'fade',           // Fade, slide, none
        animationSpeed: 200,         // Animation in speed (ms)
        scrollTrigger: false,        // Set a custom triggering element. Can be an HTML string or jQuery object
        scrollTarget: false,         // Set a custom target element for scrolling to. Can be element or number
        scrollText: 'Scroll to top', // Text for element, can contain HTML
        scrollTitle: false,          // Set a custom <a> title if required. Defaults to scrollText
        scrollImg: false,            // Set true to use image
        activeOverlay: false,        // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        zIndex: 2147483647           // Z-Index for the overlay
    };

    // Destroy scrollUp plugin and clean all modifications to the DOM
    $.fn.scrollUp.destroy = function (scrollEvent) {
        $.removeData(document.body, 'scrollUp');
        $('#' + $.fn.scrollUp.settings.scrollName).remove();
        $('#' + $.fn.scrollUp.settings.scrollName + '-active').remove();

        // If 1.7 or above use the new .off()
        if ($.fn.jquery.split('.')[1] >= 7) {
            $(window).off('scroll', scrollEvent);

        // Else use the old .unbind()
        } else {
            $(window).unbind('scroll', scrollEvent);
        }
    };

    $.scrollUp = $.fn.scrollUp;

})(jQuery, window, document);
