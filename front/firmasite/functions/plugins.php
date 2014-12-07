<?php
/**
 * @package firmasite
 */
 
if ( class_exists( 'bbPress' ) ) 
	require_once ( get_template_directory() . '/functions/bbpress.php');	// bbPress changes
if ( class_exists( 'BuddyPress' ) ) 		
	require_once ( get_template_directory() . '/functions/buddypress.php');	// BuddyPress changes


add_filter("firmasite_nav_below", "firmasite_plugins_nav_below_fix");
function firmasite_plugins_nav_below_fix($nav_below){
	if ( class_exists( 'bbPress' ) && is_bbpress() ) 
		return;
	if ( class_exists( 'BuddyPress' ) && is_buddypress() ) 
		return;
		
	return $nav_below;
}

// Redirecting forum profiles to buddypress ones
if ( class_exists( 'bbPress' ) && class_exists( 'BuddyPress' ) ) 
	add_filter('template_redirect','firmasite_buddypress_bbpress_redirect_profile');
	function firmasite_buddypress_bbpress_redirect_profile(){
		global $bp;
		if (bbp_is_single_user_profile()){
			global $wp_query;
			$author_page_link = trailingslashit(bp_core_get_user_domain($wp_query->query_vars["bbp_user_id"]) . 'forums');
			wp_redirect( $author_page_link, 301 );
			exit();
		}
	}



if (FIRMASITE_COMBINE_JS) {
	add_action( 'firmasite_combine_js_before', "firmasite_js_plugins_init_combine",2);
} else {
	add_action( 'wp_footer', "firmasite_js_plugins_init");
}	
function firmasite_js_plugins_init() {
  ?>
  <script type="text/javascript">	
	  <?php echo firmasite_js_plugins_init_combine(); ?>
  </script>
  <?php
}
function firmasite_js_plugins_init_combine() {?> 
	<?php if ( !class_exists( 'BuddyPress' ) ) {?>
	/* jQuery Easing Plugin, v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/ */
	jQuery.easing.jswing=jQuery.easing.swing;jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,f,a,h,g){return jQuery.easing[jQuery.easing.def](e,f,a,h,g)},easeInQuad:function(e,f,a,h,g){return h*(f/=g)*f+a},easeOutQuad:function(e,f,a,h,g){return -h*(f/=g)*(f-2)+a},easeInOutQuad:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f+a}return -h/2*((--f)*(f-2)-1)+a},easeInCubic:function(e,f,a,h,g){return h*(f/=g)*f*f+a},easeOutCubic:function(e,f,a,h,g){return h*((f=f/g-1)*f*f+1)+a},easeInOutCubic:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f+a}return h/2*((f-=2)*f*f+2)+a},easeInQuart:function(e,f,a,h,g){return h*(f/=g)*f*f*f+a},easeOutQuart:function(e,f,a,h,g){return -h*((f=f/g-1)*f*f*f-1)+a},easeInOutQuart:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f+a}return -h/2*((f-=2)*f*f*f-2)+a},easeInQuint:function(e,f,a,h,g){return h*(f/=g)*f*f*f*f+a},easeOutQuint:function(e,f,a,h,g){return h*((f=f/g-1)*f*f*f*f+1)+a},easeInOutQuint:function(e,f,a,h,g){if((f/=g/2)<1){return h/2*f*f*f*f*f+a}return h/2*((f-=2)*f*f*f*f+2)+a},easeInSine:function(e,f,a,h,g){return -h*Math.cos(f/g*(Math.PI/2))+h+a},easeOutSine:function(e,f,a,h,g){return h*Math.sin(f/g*(Math.PI/2))+a},easeInOutSine:function(e,f,a,h,g){return -h/2*(Math.cos(Math.PI*f/g)-1)+a},easeInExpo:function(e,f,a,h,g){return(f==0)?a:h*Math.pow(2,10*(f/g-1))+a},easeOutExpo:function(e,f,a,h,g){return(f==g)?a+h:h*(-Math.pow(2,-10*f/g)+1)+a},easeInOutExpo:function(e,f,a,h,g){if(f==0){return a}if(f==g){return a+h}if((f/=g/2)<1){return h/2*Math.pow(2,10*(f-1))+a}return h/2*(-Math.pow(2,-10*--f)+2)+a},easeInCirc:function(e,f,a,h,g){return -h*(Math.sqrt(1-(f/=g)*f)-1)+a},easeOutCirc:function(e,f,a,h,g){return h*Math.sqrt(1-(f=f/g-1)*f)+a},easeInOutCirc:function(e,f,a,h,g){if((f/=g/2)<1){return -h/2*(Math.sqrt(1-f*f)-1)+a}return h/2*(Math.sqrt(1-(f-=2)*f)+1)+a},easeInElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return -(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e},easeOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k)==1){return e+l}if(!j){j=k*0.3}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}return g*Math.pow(2,-10*h)*Math.sin((h*k-i)*(2*Math.PI)/j)+l+e},easeInOutElastic:function(f,h,e,l,k){var i=1.70158;var j=0;var g=l;if(h==0){return e}if((h/=k/2)==2){return e+l}if(!j){j=k*(0.3*1.5)}if(g<Math.abs(l)){g=l;var i=j/4}else{var i=j/(2*Math.PI)*Math.asin(l/g)}if(h<1){return -0.5*(g*Math.pow(2,10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j))+e}return g*Math.pow(2,-10*(h-=1))*Math.sin((h*k-i)*(2*Math.PI)/j)*0.5+l+e},easeInBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*(f/=h)*f*((g+1)*f-g)+a},easeOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*((f=f/h-1)*f*((g+1)*f+g)+1)+a},easeInOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}if((f/=h/2)<1){return i/2*(f*f*(((g*=(1.525))+1)*f-g))+a}return i/2*((f-=2)*f*(((g*=(1.525))+1)*f+g)+2)+a},easeInBounce:function(e,f,a,h,g){return h-jQuery.easing.easeOutBounce(e,g-f,0,h,g)+a},easeOutBounce:function(e,f,a,h,g){if((f/=g)<(1/2.75)){return h*(7.5625*f*f)+a}else{if(f<(2/2.75)){return h*(7.5625*(f-=(1.5/2.75))*f+0.75)+a}else{if(f<(2.5/2.75)){return h*(7.5625*(f-=(2.25/2.75))*f+0.9375)+a}else{return h*(7.5625*(f-=(2.625/2.75))*f+0.984375)+a}}}},easeInOutBounce:function(e,f,a,h,g){if(f<g/2){return jQuery.easing.easeInBounce(e,f*2,0,h,g)*0.5+a}return jQuery.easing.easeOutBounce(e,f*2-g,0,h,g)*0.5+h*0.5+a}});
	/*!
	 * jQuery Cookie Plugin v1.3.1
	 * https://github.com/carhartl/jquery-cookie
	 *
	 * Copyright 2013 Klaus Hartl
	 * Released under the MIT license
	 */
	(function(e){if(typeof define==="function"&&define.amd){define(["jquery"],e)}else{e(jQuery)}})(function(e){function n(e){return e}function r(e){return decodeURIComponent(e.replace(t," "))}function i(e){if(e.indexOf('"')===0){e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\")}try{return s.json?JSON.parse(e):e}catch(t){}}var t=/\+/g;var s=e.cookie=function(t,o,u){if(o!==undefined){u=e.extend({},s.defaults,u);if(typeof u.expires==="number"){var a=u.expires,f=u.expires=new Date;f.setDate(f.getDate()+a)}o=s.json?JSON.stringify(o):String(o);return document.cookie=[s.raw?t:encodeURIComponent(t),"=",s.raw?o:encodeURIComponent(o),u.expires?"; expires="+u.expires.toUTCString():"",u.path?"; path="+u.path:"",u.domain?"; domain="+u.domain:"",u.secure?"; secure":""].join("")}var l=s.raw?n:r;var c=document.cookie.split("; ");var h=t?undefined:{};for(var p=0,d=c.length;p<d;p++){var v=c[p].split("=");var m=l(v.shift());var g=l(v.join("="));if(t&&t===m){h=i(g);break}if(!t){h[m]=i(g)}}return h};s.defaults={};e.removeCookie=function(t,n){if(e.cookie(t)!==undefined){e.cookie(t,"",e.extend({},n,{expires:-1}));return true}return false}});
<?php
	}
}

if ( class_exists( 'bbPress' ) || class_exists( 'BuddyPress' ) ) {
	if (FIRMASITE_COMBINE_JS) {
		add_action( 'firmasite_combine_js', "firmasite_social_footer_scripts_combine");
	} else {
		add_action( 'wp_footer', "firmasite_social_footer_scripts");
	}
	function firmasite_social_footer_scripts(){
	  ?>
	  <script type="text/javascript">	
		(function ($) {
			<?php echo firmasite_social_footer_scripts_combine(); ?>
		})(jQuery);	
	  </script>
	  <?php
	}
	function firmasite_social_footer_scripts_combine() { ?>
	$(document).ready(function() {
		firmasite_social_edits();	

		$("#aw-whats-new-submit").prop("disabled", false);
		/* Activity update AJAX posting */
		$("input#aw-whats-new-submit").click( function() {
			tinyMCE.triggerSave();
			$('#whats-new_ifr').contents().find('#tinymce').html();
		});

		/* Message reply AJAX posting */
		$("input#send_reply_button").click( function() {
			tinyMCE.triggerSave();
			$('#whats-new_ifr').contents().find('#tinymce').html();
		});		
        
		$(".makeit-pag-small").find("ul.pagination-lg").addClass("pagination-sm").removeClass("pagination-lg");
       
	});
	$(document).on("DOMNodeInserted", throttle(function(){
          firmasite_social_edits();
    },250));
	
	function firmasite_social_edits(){
		$(".generic-button").find("a").addClass("btn btn-default btn-xs");
		$("img.avatar").parent("a").addClass("thumbnail pull-left");
		/* pull-left fixes */
		$("#wpadminbar").find("a").removeClass("thumbnail pull-left");
        
		$("#message").addClass("alert alert-info");
        
		$("div[role=search]").addClass("pull-right"); // search boxes
		$("#main [role=navigation]").find("span").addClass("badge");
		
		$("div#item-actions").find("ul").addClass("list-unstyled"); 		
		$(".pagination-links").addClass("pager lead").children("span").wrap('<li class="disabled" />').parent().parent().children("a").wrap("<li>");
        
		$("ul.item-list").addClass("list-unstyled").children("li").addClass("well well-sm clearfix");	
	}
<?php	
	}
}


function firmasite_highlight_search_results(){
	/* modified..replaced:
	className="highlight"
	to 
	className="highlight label label-warning"
	
	replaced:
	.find("span.highlight")
	to
	.find("span.highlight.label.label-warning")
	*/
	?>
  <script type="text/javascript">	
	/*
	highlight v4
	
	Highlights arbitrary terms.
	
	<http://johannburkard.de/blog/programming/javascript/highlight-javascript-text-higlighting-jquery-plugin.html>
	
	MIT license.
	
	Johann Burkard
	<http://johannburkard.de>
	<mailto:jb@eaio.com>
	
	*/
	jQuery.fn.highlight=function(c){function e(b,c){var d=0;if(3==b.nodeType){var a=b.data.toUpperCase().indexOf(c);if(0<=a){d=document.createElement("span");d.className="highlight label label-warning";a=b.splitText(a);a.splitText(c.length);var f=a.cloneNode(!0);d.appendChild(f);a.parentNode.replaceChild(d,a);d=1}}else if(1==b.nodeType&&b.childNodes&&!/(script|style)/i.test(b.tagName))for(a=0;a<b.childNodes.length;++a)a+=e(b.childNodes[a],c);return d}return this.length&&c&&c.length?this.each(function(){e(this,c.toUpperCase())}): this};jQuery.fn.removeHighlight=function(){return this.find("span.highlight.label.label-warning").each(function(){this.parentNode.firstChild.nodeName;with(this.parentNode)replaceChild(this.firstChild,this),normalize()}).end()};
	</script>
	<?php
}
add_action( 'bbp_template_after_search_results', "firmasite_bbpress_highlight_search_results");
function firmasite_bbpress_highlight_search_results(){
	firmasite_highlight_search_results();
	// Get search terms
	$search_terms = bbp_get_search_terms();
	echo "<script>jQuery('#bbp-search-results').highlight('" . $search_terms . "');</script>";
	
}
