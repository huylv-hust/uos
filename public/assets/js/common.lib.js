/* ----------------------------------------------------------------------------------------------------
	Dreamweaver8 - publish common script
---------------------------------------------------------------------------------------------------- */
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

/*window.open control*/
function MM_openBrWindow(theURL,winName,features) { //v2.0
  w = window.open(theURL,winName,features);
  w.focus();
}

/* ----------------------------------------------------------------------------------------------------
	IE BackgroundImageCache
---------------------------------------------------------------------------------------------------- */
try{
	document.execCommand("BackgroundImageCache", false, true);
}
catch(err){}


/* ----------------------------------------------------------------------------------------------------
 * jQuery.rollover
 *
 * @version    1.0.4
 * @author     Hiroshi Hoaki <rewish.org@gmail.com>
 * @copyright  2010-2011 Hiroshi Hoaki
 * @license    http://rewish.org/license/mit The MIT License
 * @link       http://rewish.org/javascript/jquery_rollover_plugin
 *
 * Usage:
 * jQuery(document).ready(function($) {
 *   // <img>
 *   $('#nav a img').rollover();
 *
 *   // <input type="image">
 *   $('form input:image').rollover();
 *
 *   // set suffix
 *   $('#nav a img').rollover('_over');
 * });
---------------------------------------------------------------------------------------------------- */
(function($) {

jQuery.fn.rollover = function(suffix) {
	suffix = suffix || '_on';
	var check = new RegExp(suffix + '\\.\\w+$');
	return this.each(function() {
		var img = jQuery(this);
		var src = img.attr('src');
		if (check.test(src)) return;
		var _on = src.replace(/\.\w+$/, suffix + '$&');
		jQuery('<img>').attr('src', _on);
		img.hover(
			function() { img.attr('src', _on); },
			function() { img.attr('src', src); }
		);
	});
};

})(jQuery); // Call and execute the function immediately passing the jQuery object


/* ----------------------------------------------------------------------------------------------------
	Blank window + icon
---------------------------------------------------------------------------------------------------- */
$(function(){
var domains = [document.domain,'www.jp','.jp','www.all-internet.jp','all-internet.jp','www.ai-mall.net','ai-mall.net','www.homepage-win.jp','homepage-win.jp'];
var domain_selector = "",left_str= ":not([href^=\"http://",left_str_https=":not([href^=\"https://",right_str = "\"])";
domain_selector = left_str+domains.join(right_str+left_str)+right_str;
domain_selector+= left_str_https+domains.join(right_str+left_str_https)+right_str;

	$("a[href^=http]"+domain_selector+":not(:has(img))").addClass("outlink");
	$("a[href^=http]"+domain_selector).click(function(){
	window.open(this.href,"_blank");
		return false;
	});
});


/* ----------------------------------------------------------------------------------------------------
// preload image function
---------------------------------------------------------------------------------------------------- */
(function($) {

jQuery.preloadImages = function(){
	for(var i = 0; i<arguments.length; i++) {
		jQuery("<img>").attr("src", arguments[i]);
	}
};

})(jQuery);
/*<scirpt type="text/javascript"><!--
jQuery.preloadImages("absolute_pass.jpg","absolute_pass.png");
//--></script>*/


/* ----------------------------------------------------------------------------------------------------
// preload image function
---------------------------------------------------------------------------------------------------- */
$(function(){
	$('input#sendChkbox').prop('checked',false);
	$("#mail_preview").prop('disabled',true);
	$("#mail_preview").addClass('dbd');
	
	$('#sendChkbox').click(function(){
		var chk = $(this).prop('checked');
		if(chk == true){
			$("#mail_preview").prop('disabled',false);
			$("#mail_preview").removeClass('dbd');
		}else{
			$("#mail_preview").prop('disabled',true);
			$("#mail_preview").addClass('dbd');
		}
		return true;
	});
});
$(function(){
	$('input#sendChkbox2').prop('checked',false);
	$("#mail_preview2").prop('disabled',true);
	$("#mail_preview2").addClass('dbd');
	
	$('#sendChkbox2').click(function(){
		var chk = $(this).prop('checked');
		if(chk == true){
			$("#mail_preview2").prop('disabled',false);
			$("#mail_preview2").removeClass('dbd');
		}else{
			$("#mail_preview2").prop('disabled',true);
			$("#mail_preview2").addClass('dbd');
		}
		return true;
	});
});

/* ----------------------------------------------------------------------------------------------------
	load function
---------------------------------------------------------------------------------------------------- */

jQuery(document).ready(function($) {
	$(function() {
		$('a img.rollover,form input:image.rollover').rollover();
		$('.zebra tr:nth-child(2n)').addClass("even");
		$('.tblList dt:nth-child(1)').each(function(){
			$(this).addClass("noLine");
			$(this).next().addClass("noLine");
		});
	});
});

/*
---------------------------------------------------------------------------------------------------- */