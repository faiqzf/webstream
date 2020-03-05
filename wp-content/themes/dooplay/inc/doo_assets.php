<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.2.0
*
*/

if(!function_exists('dt_styles')) {
	function dt_styles()  {
		wp_enqueue_style('owl-carousel', DOO_URI .'/assets/css/front.owl.css' , array(), DOO_VERSION );
	    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family='.cs_get_option('font','Roboto').':300,400,500,700', array(), null );
		wp_enqueue_style('icons', DOO_URI .'/assets/css/front.icons.css' , array(), DOO_VERSION );
		wp_enqueue_style('scrollbar', DOO_URI .'/assets/css/front.crollbar.css' , array(), DOO_VERSION );
		wp_enqueue_style('theme', DOO_URI .'/assets/css/front.style.css' , array(), DOO_VERSION );
		wp_enqueue_style('color-scheme', DOO_URI .'/assets/css/colors.'.cs_get_option('style','default').'.css' , array(), DOO_VERSION );
		wp_enqueue_style('responsive', DOO_URI .'/assets/css/front.mobile.css' , array(), DOO_VERSION );
	}
	add_action('wp_enqueue_scripts', 'dt_styles');
}

/* javascript */
if(!function_exists('dt_scripts')){
	function dt_scripts() {

		wp_enqueue_script('scrollbar',DOO_URI.'/assets/js/lib/mcsbscrollbar.js', array('jquery'), DOO_VERSION, false );
		wp_enqueue_script('owl',DOO_URI.'/assets/js/lib/owlcarousel.js', array('jquery'), DOO_VERSION, false  );
        wp_enqueue_script('idTabs', DOO_URI.'/assets/js/lib/idtabs.js', array('jquery'), DOO_VERSION, false);
        wp_enqueue_script('dtRepeat', DOO_URI.'/assets/js/lib/isrepeater.js', array('jquery'), DOO_VERSION, false );
		wp_enqueue_script('scripts', doo_compose_javascript('front.scripts'), array('jquery'), DOO_VERSION, true );
	    if ( is_singular() && get_option('thread_comments') ) {
			wp_enqueue_script('comment-reply');
		}
		if(is_singular()) {
			wp_enqueue_style('blueimp-gallery', DOO_URI.'/assets/css/front.gallery.css', array(), DOO_VERSION, 'all');
			wp_enqueue_script('blueimp-gallery', DOO_URI.'/assets/js/lib/blueimp.js', array('jquery'), DOO_VERSION, false  );
		}
	}
	add_action('wp_enqueue_scripts', 'dt_scripts');
}

// Live Search The function
if( ! function_exists( 'live_search' ) ) {
	function live_search() {
		$args = array(
			'api'	           => dooplay_url_search(),
	        'glossary'         => dooplay_url_glossary(),
			'nonce'            => dooplay_create_nonce('dooplay-search-nonce'),
			'area'	           => ".live-search",
			'button'	       => ".search-button",
			'more'		       => __d('View all results'),
			'mobile'	       => doo_mobile(),
			'reset_all'        => __d('Really you want to restart all data?'),
			'manually_content' => __d('They sure have added content manually?'),
	        'loading'          => __d('Loading..'),
            'loadingplayer'    => __d('Loading player..'),
            'selectaplayer'    => __d('Select a video player'),
            'playeradstime'    => cs_get_option('playwait'),
            'autoplayer'       => cs_get_option('playautoload'),
            'livesearchactive' => doo_is_true('permits','enls'),
		);
		wp_enqueue_script('live_search', doo_compose_javascript('front.livesearch'), array('jquery'), DOO_VERSION, true );
		wp_localize_script('live_search', 'dtGonza', $args);
	}
	add_action('wp_enqueue_scripts', 'live_search');
}


// Ajax Admin
if( ! function_exists( 'dt_ajax_admin' ) ) {
	function dt_ajax_admin() {
		wp_enqueue_script('ajax_dooplay_upload', DOO_URI.'/assets/js/lib/wpupload.js', array('jquery'), DOO_VERSION, false );
		wp_enqueue_script('ajax_dooplay_admin', doo_compose_javascript('admin.ajax'), array('jquery'), DOO_VERSION, false );
		wp_localize_script('ajax_dooplay_admin', 'dooAj', array(
				// Importar
				'url'                => admin_url('admin-ajax.php', 'relative'),
                'rem_featu'	         => __('Remove'),
				'add_featu'          => __('Add'),
				'loading'	         => __d('Loading...'),
				'reloading'          => __d('Reloading..'),
				'exists'	         => __d('Domain has already been registered'),
				'updb'		         => __d('Updating database..'),
				'completed'          => __d('Action completed'),
                'nolink'             => __d('The links field is empty'),
                'deletelink'         => __d('Do you really want to delete this item?'),
                'confirmdbtool'      => __d('Do you really want to delete this register, once completed this action will not recover the data again?'),
                'confirmpublink'     => __d('Do you want to publish the links before continuing?'),
				'domain'	         => doo_compose_domain( get_site_url() ),
				'doothemes_server'	 => 'https://doothemes.com',
				'doothemes_license'  => (current_user_can('administrator')) ? get_option( DOO_THEME_SLUG. '_license_key') : false,
				'doothemes_item'	 => DOO_THEME,
			) );
	}
    add_action('admin_enqueue_scripts', 'dt_ajax_admin');
}

/* owl controls And Google analytics */
if(!function_exists('dooplay_scripts_footer')) {
	function dooplay_scripts_footer() {
		#globals
		global $user_ID, $post;

		# Options
		$dt_featured_slider_ac = doo_is_true('featuredcontrol','slider');
		$dt_featured_slider_ap = doo_is_true('featuredcontrol','autopl');
		$dt_mm_activate_slider = doo_is_true('moviemodcontrol','slider');
		$dt_mm_autoplay_slider = doo_is_true('moviemodcontrol','autopl');
		$dt_mt_activate_slider = doo_is_true('tvmodcontrol','slider');
		$dt_mt_autoplay_slider = doo_is_true('tvmodcontrol','autopl');
		$dt_me_autoplay_slider = doo_is_true('episodesmodcontrol','autopl');
		$dt_ms_autoplay_slider = doo_is_true('seasonsmodcontrol','autopl');
		$dt_autoplay_s_movies  = doo_is_true('sliderautoplaycontrol','autopsm');
		$dt_autoplay_s_tvshows = doo_is_true('sliderautoplaycontrol','autopst');
		$dt_autoplay_s         = doo_is_true('sliderautoplaycontrol','autopms');
		$dt_slider_speed       = cs_get_option('sliderspeed','4000');
		$dt_google_analytics   = cs_get_option('ganalytics');
	    $dt_full_width         = cs_get_option('homefullwidth');

		# conditionals
		$cond['0'] = ($dt_featured_slider_ap == true) ? '3500' : 'false';
		$cond['1'] = ($dt_mm_autoplay_slider == true) ? '3500' : 'false';
		$cond['2'] = ($dt_mt_autoplay_slider == true) ? '3500' : 'false';
		$cond['3'] = ($dt_me_autoplay_slider == true) ? '3500' : 'false';
		$cond['4'] = ($dt_ms_autoplay_slider == true) ? '3500' : 'false';
		$cond['5'] = ($dt_autoplay_s_movies  == true) ? $dt_slider_speed : 'false';
		$cond['6'] = ($dt_autoplay_s_tvshows == true) ? $dt_slider_speed : 'false';
		$cond['7'] = ($dt_autoplay_s         == true) ? $dt_slider_speed : 'false';


	    // Condicionals full width
	    $cond['9']  = ($dt_full_width == true) ? "6" : "5";
	    $cond['10'] = ($dt_full_width == true) ? "6" : "5";
	    $cond['11'] = ($dt_full_width == true) ? "4" : "3";
	    $cond['12'] = ($dt_full_width == true) ? "3" : "2";
        $cond['13'] = (is_archive()) ? '5' : $cond['10'];

		$out = "<script type='text/javascript'>\n";
		$out .= "jQuery(document).ready(function($) {\n";
		if(is_single()) {
			$out .= "$('#dt_galery').owlCarousel({ items:3,autoPlay:false,itemsDesktop:[1199,3],itemsDesktopSmall:[980,3],itemsTablet:[768,3],itemsTabletSmall:false,itemsMobile:[479,1] });\n";
			$out .= "$('#dt_galery_ep').owlCarousel({ items:2,autoPlay:false });\n";
			$out .= "$('#single_relacionados').owlCarousel({ items:6,autoPlay:3000,stopOnHover:true,pagination:false,itemsDesktop:[1199,6],itemsDesktopSmall:[980,6],itemsTablet:[768,5],itemsTabletSmall:false,itemsMobile:[479,3] });\n";
		} else {
			if($dt_featured_slider_ac == true) {
				$out .= "$('#featured-titles').owlCarousel({ autoPlay:". $cond['0'] .",items:".$cond['13'].",stopOnHover:true,pagination:false,itemsDesktop:[1199,4],itemsDesktopSmall:[980,4],itemsTablet:[768,3],itemsTabletSmall: false,itemsMobile : [479,2] });\n";
				$out .= "$('.nextf').click(function(){ $('#featured-titles').trigger('owl.next') });\n";
				$out .= "$('.prevf').click(function(){ $('#featured-titles').trigger('owl.prev') });\n";

			}
			if($dt_mm_activate_slider == true) {
				$out .= "$('#dt-movies').owlCarousel({ autoPlay:". $cond['1'] .",items:".$cond['9'].",stopOnHover:true,pagination:false,itemsDesktop:[1199,5],itemsDesktopSmall:[980,5],itemsTablet:[768,4],itemsTabletSmall: false,itemsMobile : [479,3] });\n";
				if(!$dt_mm_autoplay_slider) {
					$out .= "$('.next3').click(function(){ $('#dt-movies').trigger('owl.next') });\n";
					$out .= "$('.prev3').click(function(){ $('#dt-movies').trigger('owl.prev') });\n";
				}
			}
			if($dt_mt_activate_slider == true) {
				$out .= "$('#dt-tvshows').owlCarousel({ autoPlay:". $cond['2'] .",items:".$cond['9'].",stopOnHover:true,pagination:false,itemsDesktop:[1199,5],itemsDesktopSmall:[980,5],itemsTablet:[768,4],itemsTabletSmall:false,itemsMobile:[479,3] });\n";
				if(!$dt_mt_autoplay_slider) {
					$out .= "$('.next4').click(function(){ $('#dt-tvshows').trigger('owl.next') });\n";
					$out .= "$('.prev4').click(function(){ $('#dt-tvshows').trigger('owl.prev') });\n";
				}
			}
			$out .= "$('#dt-episodes').owlCarousel({ autoPlay:". $cond['3'] .",pagination:false,items:".$cond['11'].",stopOnHover:true,itemsDesktop:[900,3],itemsDesktopSmall:[750,3],itemsTablet:[500,2],itemsMobile:[320,1] });\n";
			if(!$dt_me_autoplay_slider) {
				$out .= "$('.next').click(function(){ $('#dt-episodes').trigger('owl.next') });\n";
				$out .= "$('.prev').click(function(){ $('#dt-episodes').trigger('owl.prev') });\n";
			}
			$out .= "$('#dt-seasons').owlCarousel({ autoPlay:". $cond['4'] .",items:".$cond['9'].",stopOnHover:true,pagination:false,itemsDesktop:[1199,5],itemsDesktopSmall:[980,5],itemsTablet:[768,4],itemsTabletSmall:false,itemsMobile:[479,3] });\n";
			if(!$dt_ms_autoplay_slider) {
				$out .= "$('.next2').click(function(){ $('#dt-seasons').trigger('owl.next') });\n";
				$out .= "$('.prev2').click(function(){ $('#dt-seasons').trigger('owl.prev') });\n";
			}
			$out .= "$('#slider-movies').owlCarousel({ autoPlay:". $cond['5'] .",items:".$cond['12'].",stopOnHover:true,pagination:true,itemsDesktop:[1199,2],itemsDesktopSmall:[980,2],itemsTablet:[768,2],itemsTabletSmall:[600,1],itemsMobile:[479,1] });\n";
			$out .= "$('#slider-tvshows').owlCarousel({ autoPlay:". $cond['6'] .",items:".$cond['12'].",stopOnHover:true,pagination:true,itemsDesktop:[1199,2],itemsDesktopSmall:[980,2],itemsTablet:[768,2],itemsTabletSmall:[600,1],itemsMobile:[479,1] });\n";
			$out .= "$('#slider-movies-tvshows').owlCarousel({ autoPlay:". $cond['7'] .",items:".$cond['12'].",stopOnHover:true,pagination:true,itemsDesktop:[1199,2],itemsDesktopSmall:[980,2],itemsTablet:[768,2],itemsTabletSmall:[600,1],itemsMobile:[479,1] });\n";
		}
		if(is_single()) {
			if( $user_ID ) {
				if( current_user_can('level_10') ) {
					$out .= "$('.dtload').click(function() { var o = $(this).attr('id'); 1 == o ? ($('.dtloadpage').hide(), $(this).attr('id', '0')) : ($('.dtloadpage').show(), $(this).attr('id', '1')) });\n";
					$out .= "$('.dtloadpage').mouseup(function() { return !1 });\n";
					$out .= "$('.dtload').mouseup(function() { return !1 });\n";
					$out .= "$(document).mouseup(function() { $('.dtloadpage').hide(), $('.dtload').attr('id', '') });\n";
				}
			}
		}
		$out .= "$('.reset').click(function(event){ if (!confirm( dtGonza.reset_all )) { event.preventDefault() } });\n";
		$out .= "$('.addcontent').click(function(event){ if (!confirm( dtGonza.manually_content )) { event.preventDefault() } });";
		$out .= "});\n";
		if( is_single() == true AND get_post_type() != 'seasons' AND get_post_meta($post->ID, 'imagenes', true) ) {
			$out .= "document.getElementById('dt_galery').onclick=function(a){a=a||window.event;var b=a.target||a.srcElement,c=b.src?b.parentNode:b,d={index:c,event:a},e=this.getElementsByTagName('a');blueimp.Gallery(e,d)};\n";
		}
		if($dt_google_analytics) {
			$out .= "(function(b,c,d,e,f,h,j){b.GoogleAnalyticsObject=f,b[f]=b[f]||function(){(b[f].q=b[f].q||[]).push(arguments)},b[f].l=1*new Date,h=c.createElement(d),j=c.getElementsByTagName(d)[0],h.async=1,h.src=e,j.parentNode.insertBefore(h,j)})(window,document,'script','//www.google-analytics.com/analytics.js','ga'),ga('create','".$dt_google_analytics."','auto'),ga('send','pageview');\n";
		}
		$out .= "</script>\n";
		// Out
		echo $out;
	}
	add_action('wp_footer','dooplay_scripts_footer');
}


// Java Script for head
if(!function_exists('dooplay_scripts_head')){
	function dooplay_scripts_head() {
		echo "<script type='text/javascript'>jQuery(document).ready(function(a){'false'==dtGonza.mobile&&a(window).load(function(){a('.scrolling').mCustomScrollbar({theme:'minimal-dark',scrollButtons:{enable:!0},callbacks:{onTotalScrollOffset:100,alwaysTriggerOffsets:!1}})})});</script>";
	}
	add_action('wp_head', 'dooplay_scripts_head');
}


// Java Script for Comments
if(!function_exists('dooplay_js_comments')){
    function dooplay_js_comments(){
        if(is_page() OR is_single()){
            $doocmts = cs_get_option('comments');
            switch ($doocmts) {
                case 'fb':
                    $appi = cs_get_option('fbappid');
                    $lang = cs_get_option('fblang','en_US');
                    require_once(DOO_DIR.'/inc/parts/jscomments_facebook.php');
                    break;

                case 'dq':
                    $sname = cs_get_option('dqshortname');
                    if($sname){
                        require_once(DOO_DIR.'/inc/parts/jscomments_disqus.php');
                    }
                    break;
            }
        }
    }
    add_action('wp_head', 'dooplay_js_comments');
}
