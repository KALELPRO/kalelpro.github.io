(function( $ ) {
	"use strict";

	jQuery(window).ready(function() {

		jQuery(".main-menu-custom .wrapper").prepend("<a href='#tgl-menu'><i class='fa fa-bars'></i>&nbsp;&nbsp;Toggle Menu</a>");

		jQuery("a[href='#tgl-menu']").click(function () {
			jQuery(this).parent().parent().toggleClass("m-active");
			return false;
		});
		
		jQuery(".more-link").each(function () {
			var thisel = jQuery(this);
			thisel.append("<span>&nbsp;</span>");
			thisel.children("i").append("<span>&nbsp;</span>");
		});

		jQuery('.back-top a').click(function () {
			jQuery("body,html").animate({
				scrollTop: 0
			}, 800);
			return false;
		});

		jQuery(".split-content").each(function () {
			var thisel = jQuery(this);
			var height_f = thisel.children(".content-white").eq(0).height();
			var height_s = thisel.children(".content-white").eq(1).height();
			if(height_f > height_s){
				thisel.children(".content-white").eq(1).css("height", height_f);
			}else{
				thisel.children(".content-white").eq(0).css("height", height_s);
			}
		});

		jQuery(".feedback-block").each(function () {
			var thisel = jQuery(this);
			var co = thisel.children(".feedback-item").size();
			var randnumber = Math.ceil(Math.random()*3);
			thisel.children(".feedback-item").eq(randnumber-1).fadeIn("slow");
		});

		// Content slider
		window.animsecs = 5;
		window.animautostart = true;

		window.activepage = 0;
		window.totalPages = jQuery(".content-slider").find(".content-block").size();
		window.doanim = true;

		jQuery(".content-slider").each(function () {
			var thisel = jQuery(this);
			thisel.find(".content-block").eq(0).css('left', 0);

			for (var i = 1; i <= window.totalPages; i++) {
				var firstactive = (i == 1)?" class='active'":"";
				jQuery("#slider-control").append("<a href='#' "+firstactive+">"+i+"</a>");
			};
		}).mouseenter(function () {
			if(window.doanim)
				clearInterval(window.intervalanim);
		}).mouseleave(function() {
			if(window.doanim)
				window.intervalanim = setInterval( function(){
				cardNavigation(true);
			}, window.animsecs*1000);
		});

		jQuery("#slider-control a").click(function () {
			clearInterval(window.intervalanim);
			window.doanim = false;
			cardNavigation(false, parseInt(jQuery(this).html())-1);
			return false;
		});

		if(window.animautostart && window.totalPages > 1)
			window.intervalanim = setInterval( function(){
				cardNavigation(true);
			}, window.animsecs*1000);

		// Image Tooltip
		jQuery("body").append('<div class="bord-tooltip"><div class="inner-tool"></div></div>');
		jQuery(".image.tooltip").mouseenter(function() {
			var thisel = jQuery(this);
			var offset = thisel.offset();
			window.customtooltip = thisel.attr("title");
			thisel.attr("title", "");
			jQuery(".bord-tooltip").css("left", ((thisel.width()/2)+offset.left)).css("top", offset.top).children(".inner-tool").html('<img src="'+window.customtooltip+'" alt="" />');
			
			jQuery(".bord-tooltip").stop().css("display", "none").fadeIn("fast");
		}).mouseleave(function() {
			var thisel = jQuery(this);
			thisel.attr("title", window.customtooltip);
			jQuery(".bord-tooltip").stop().css("display", "block").fadeOut("fast", function () {
				jQuery(".bord-tooltip").css("left", 0).css("top", 0);
				jQuery(".bord-tooltip .inner-tool").html("");
			});
		});

		// Tabbed widget
		jQuery(".tab-navi a").click(function () {
			var thisel = jQuery(this).parent();
			var thisindex = thisel.index();
			window.thisbox = thisel.parent().parent().children(".latest-activity").eq(thisindex);
			if(thisel.hasClass("active"))return false;
			thisel.siblings().removeClass("active");
			thisel.addClass("active");
			window.thisbox.siblings(".latest-activity.active").fadeOut(400, function () {
				jQuery(this).removeClass("active");
				window.thisbox.fadeIn(400).addClass("active");
			});
			return false;
		});


		// Accordion blocks
		jQuery(".accordion > div > a").click(function() {
			var thisel = jQuery(this).parent();
			if(thisel.hasClass("active")){
				thisel.removeClass("active").children("div").animate({
					"height": "toggle",
					"opacity": "toggle",
					"padding-top": "toggle"
				}, 300);
				return false;
			}
			// thisel.siblings("div").removeClass("active");
			thisel.siblings("div").each(function() {
				var tz = jQuery(this);
				if(tz.hasClass("active")){
					tz.removeClass("active").children("div").animate({
						"height": "toggle",
						"opacity": "toggle",
						"padding-top": "toggle"
					}, 300);
				}
			});
			// thisel.addClass("active");
			thisel.addClass("active").children("div").animate({
				"height": "toggle",
				"opacity": "toggle",
				"padding-top": "toggle"
			}, 300);
			return false;
		});


		// Alert box close
		jQuery('a[href="#close-alert"]').click(function() {
			jQuery(this).parent().animate({
				opacity: 0,
				padding: "0px 13px",
				margin: "0px",
				height: "0px"
			}, 300, function() {
				// Animation complete.
			});
			return false;
		});

		// Tabbed blocks

		jQuery(".short-tabs > ul > li a").click(function() {
			var thisel = jQuery(this).parent();
			thisel.siblings(".active").removeClass("active");
			thisel.addClass("active");
			thisel.parent().siblings("div.active").removeClass("active");
			thisel.parent().siblings("div").eq(thisel.index()).addClass("active");
			return false;
		});


		// Menu card
		var menucards = 0;

		var url = window.location.hash;
		var hash = url.split('#page-');

		if(hash[1] && jQuery(".menu-card-count").size() >= parseInt(hash[1])){
			var menucardcurrent = parseInt(hash[1])-1;
		}else{
			var menucardcurrent = 0;
		}

		jQuery(".menu-card-count").each(function() {
			var thisel = jQuery(this);
			thisel.attr("rel", parseInt(thisel.height()));
			if(menucards != menucardcurrent){
				thisel.css("display", "none");
			}
			menucards++;
		});

		jQuery(".menu-card-previous").click(function() {
			if(menucards > 0 && 0 < menucardcurrent){
				jQuery(".menu-card-count").eq(menucardcurrent).fadeOut(function() {
					if ("onhashchange" in window) {
						var tempel = jQuery(".menu-card-count").eq(menucardcurrent-1);
						tempel.css("height", jQuery(".menu-card-count").eq(menucardcurrent).attr("rel")).css("opacity", "0");
					}
					menucardcurrent--;
					var tempel = jQuery(".menu-card-count").eq(menucardcurrent);
					if ("onhashchange" in window) {
						tempel.css("display", "block").animate( { height: parseInt(tempel.attr("rel")), opacity: 1 }, 200 );
					}else{
						window.location = "#page-"+(menucardcurrent+1);
					}
				});
			}
			return false;
		});

		jQuery(".menu-card-next").click(function() {
			if(menucards > 0 && menucards > menucardcurrent+1){
				jQuery(".menu-card-count").eq(menucardcurrent).fadeOut(function() {
					if ("onhashchange" in window) {
						var tempel = jQuery(".menu-card-count").eq(menucardcurrent-1);
						tempel.css("height", jQuery(".menu-card-count").eq(menucardcurrent).attr("rel")).css("opacity", "0");
					}
					menucardcurrent++;
					var tempel = jQuery(".menu-card-count").eq(menucardcurrent);
					if ("onhashchange" in window) {
						tempel.css("display", "block").animate( { height: parseInt(tempel.attr("rel")), opacity: 1 }, 200 );
					}else{
						window.location = "#page-"+(menucardcurrent+1);
					}
				});
			}
			return false;
		});

		jQuery(".lightbox").click(function () {
			jQuery(".lightbox").css('overflow', 'hidden');
			jQuery("body").css('overflow', 'auto');
			jQuery(".lightbox .lightcontent").fadeOut('fast');
			jQuery(".lightbox").fadeOut('slow');
		}).children().click(function(e) {
			return false;
		});

		window.currpager = 0;

		jQuery(".woocommerce-block.bx-loading ul").each(function (){
			var thisel = jQuery(this);
			thisel.children("li").eq(0).addClass("active");
		});

		jQuery(".woocommerce-pager a").click(function (){
			var thisel = jQuery(this);
			jQuery(".woocommerce-block.bx-loading ul li.active").removeClass("active");
			window.currpager = thisel.index();
			jQuery(".woocommerce-block.bx-loading ul li").eq(window.currpager).addClass("active");
			return false;
		});

		function locationHashChanged() {
			var url = window.location.hash;
			var hash = url.split('#page-');

			if(hash[1] && jQuery(".menu-card-count").size() >= parseInt(hash[1])){
				var menucardcurrentnew = parseInt(hash[1])-1;
			}else{
				var menucardcurrentnew = 0;
			}

			jQuery(".menu-card-count").eq(menucardcurrent).fadeOut(function() {
				var tempel = jQuery(".menu-card-count").eq(menucardcurrentnew);
				tempel.css("height", jQuery(".menu-card-count").eq(menucardcurrent).attr("rel")).css("opacity", "0");
				menucardcurrent = menucardcurrentnew;
				tempel.css("display", "block").animate( { height: parseInt(tempel.attr("rel")), opacity: 1 }, 200 );
				window.location.hash = "page-"+(menucardcurrent+1);
			});
		}

		window.onhashchange = locationHashChanged;

	});
	 
	function cardNavigation(prev, jumppage){

		var tempactive = window.activepage;
		var direction = (prev == false)?'+':'-';

		if ( jumppage || jumppage == 0 ){
			if(jumppage == window.activepage)return false;
			var newactive = jumppage;
			var direction = (jumppage < window.activepage)?'+':'-';
		}else{
			if ( prev == false ){
				var newactive = window.activepage-1;
			}else{
				var newactive = window.activepage+1;
			}

			if ( prev == false ){
				if(newactive < 0){
					newactive = window.totalPages-1;
					direction = '-';
				}
			} else {
				if(newactive == window.totalPages){
					newactive = 0;
					direction = '+';
				}
			}
		}

		jQuery("#slider-control a").removeClass("active");

		var direction_reverse = (direction == '+')?'-':'+';
		window.activepage = newactive;


		jQuery(".content-slider").find(".content-block").eq(tempactive).animate({
			'left' : [direction+"200%", "easeInOutQuint"]
		}, 800);

		jQuery("#slider-control a").eq(newactive).addClass("active");

		jQuery(".content-slider").find(".content-block").eq(newactive).css("left", direction_reverse+"200%").animate({
			'left' : [0, "easeInOutQuint"]
		}, 800);
	}
})(jQuery);

function lightboxclose(){
	jQuery(".lightbox").css('overflow', 'hidden');
	jQuery(".lightbox .lightcontent").fadeOut('fast');
	jQuery(".lightbox").fadeOut('slow');
	jQuery("body").css('overflow', 'auto');
}