<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.2.0
*
*/
if(!function_exists('header_output')){
	function header_output(){

        $fcolor = cs_get_option('featucolor','#00be08');
        $mcolor = cs_get_option('maincolor','#408BEA');
		$bcolor = cs_get_option('bgcolor','#F5F7FA');
		$style  = cs_get_option('style','default');
        $custom = cs_get_option('css');

        // Funsion
        $fbgcolor = cs_get_option('fbgcolor','#000');
        $facolor  = cs_get_option('facolor','#ffffff');
        $fhcolor  = cs_get_option('fhcolor','#408bea');
        $playsze  = cs_get_option('playsize','regular');

		echo "\n<style type='text/css'>\n";
		// fonts
		doo_compose_css('body', 'font-family', '"'.cs_get_option('font','Roboto').'", sans-serif');
	    doo_compose_css('body', 'background', $bcolor);
		// color
		doo_compose_css('a,.home-blog-post .entry-date .date,.top-imdb-item:hover>.title a,.module .content .items .item .data h3 a:hover,.head-main-nav ul.main-header li:hover>a,.login_box .box a.register', 'color', $mcolor);
		doo_compose_css('.nav_items_module a.btn:hover,.pagination span.current,.w_item_b a:hover>.data span.wextra b i,.comment-respond h3:before,footer.main .fbox .fmenu ul li a:hover','color', $mcolor);
		doo_compose_css('header.main .hbox .search form button[type=submit]:hover,.loading,#seasons .se-c .se-a ul.episodios li .episodiotitle a:hover,.sgeneros a:hover,.page_user nav.user ul li a:hover','color',$mcolor);
		doo_compose_css('footer.main .fbox .fmenu ul li.current-menu-item a,.posts .meta .autor i,.pag_episodes .item a:hover,a.link_a:hover,ul.smenu li a:hover','color', $mcolor);
		doo_compose_css('header.responsive .nav a.active:before, header.responsive .search a.active:before,.dtuser a.clicklogin:hover,.menuresp .menu ul.resp li a:hover,.menuresp .menu ul.resp li ul.sub-menu li a:hover','color', $mcolor);
		doo_compose_css('.sl-wrapper a:before,table.account_links tbody td a:hover,.dt_mainmeta nav.genres ul li a:hover','color', $mcolor);
		doo_compose_css('.dt_mainmeta nav.genres ul li.current-cat a:before,.dooplay_player .options ul li:hover span.title','color', $mcolor);
		doo_compose_css('.head-main-nav ul.main-header li ul.sub-menu li a:hover,form.form-resp-ab button[type=submit]:hover>span,.sidebar aside.widget ul li a:hover', 'color', $mcolor);
		doo_compose_css('header.top_imdb h1.top-imdb-h1 span,article.post .information .meta span.autor,.w_item_c a:hover>.rating i,span.comment-author-link,.pagination a:hover','color',$mcolor);
		doo_compose_css('.letter_home ul.glossary li a:hover, .letter_home ul.glossary li a.active, .user_control a.in-list', 'color', $mcolor);
        doo_compose_css('.headitems a#dooplay_signout:hover','color',$mcolor);

        // Background
		doo_compose_css('.linktabs ul li a.selected,ul.smenu li a.selected,a.liked,.module .content header span a.see-all,.page_user nav.user ul li a.selected,.dt_mainmeta nav.releases ul li a:hover','background', $mcolor);
		doo_compose_css('a.see_all,p.form-submit input[type=submit]:hover,.report-video-form fieldset input[type=submit],a.mtoc,.contact .wrapper fieldset input[type=submit],span.item_type,a.main', 'background', $mcolor);
		doo_compose_css('.head-main-nav ul.main-header li a i,.post-comments .comment-reply-link:hover,#seasons .se-c .se-q span.se-o,#edit_link .box .form_edit .cerrar a:hover','background',$mcolor);
		doo_compose_css('.user_edit_control ul li a.selected,form.update_profile fieldset input[type=submit],.page_user .content .paged a.load_more:hover,#edit_link .box .form_edit fieldset input[type="submit"]','background', $mcolor);
		doo_compose_css('.login_box .box input[type="submit"],.form_post_lik .control .left a.add_row:hover,.form_post_lik .table table tbody tr td a.remove_row:hover,.form_post_lik .control .right input[type="submit"]','background', $mcolor);
		doo_compose_css('#dt_contenedor','background', $bcolor);
		doo_compose_css('.plyr input[type=range]::-ms-fill-lower', 'background', $mcolor);
		doo_compose_css('.menuresp .menu .user a.ctgs,.menuresp .menu .user .logout a:hover', 'background', $mcolor);
		doo_compose_css('.plyr input[type=range]:active::-webkit-slider-thumb', 'background', $mcolor);
		doo_compose_css('.plyr input[type=range]:active::-moz-range-thumb', 'background', $mcolor);
		doo_compose_css('.plyr input[type=range]:active::-ms-thumb', 'background', $mcolor);
		doo_compose_css('.tagcloud a:hover,ul.abc li a:hover,ul.abc li a.select, ','background',$mcolor);
        doo_compose_css('.featu','background',$fcolor);

		// border color
		doo_compose_css('.contact .wrapper fieldset input[type=text]:focus, .contact .wrapper fieldset textarea:focus,header.main .hbox .dt_user ul li ul li:hover > a,.login_box .box a.register','border-color',$mcolor);
		doo_compose_css('.module .content header h1','border-color', $mcolor);
		doo_compose_css('.module .content header h2','border-color', $mcolor);
		doo_compose_css('a.see_all','border-color', $mcolor);
		doo_compose_css('.top-imdb-list h3', 'border-color', $mcolor);
		doo_compose_css('.user_edit_control ul li a.selected:before','border-top-color', $mcolor);

        // Colors for styles
        switch($style) {
            case 'dark':
                doo_compose_css('header.main .loading', 'color', '#fff!important');
                doo_compose_css('.starstruck .star-on-png:before','color', $mcolor);
                break;

            case 'fusion':
                doo_compose_css('header.main .loading', 'color', '#fff!important');
                doo_compose_css('header.main, header.responsive','background', $fbgcolor);
                doo_compose_css('.head-main-nav ul.main-header li a, .dtuser a#dooplay_signout, header.responsive .nav a:before, header.responsive .search a:before, .dtuser a.clicklogin','color',$facolor);
                doo_compose_css('.head-main-nav ul.main-header li:hover>a, .dtuser a#dooplay_signout:hover, header.main .hbox .search form button[type=submit]:hover','color', $fhcolor);
                doo_compose_css('.dtuser a.clicklogin:hover, header.responsive .nav a.active:before, header.responsive .search a.active:before, .dtuser a.clicklogin:hover','color', $fhcolor);
                doo_compose_css('.head-main-nav ul.main-header li ul.sub-menu','background',$fbgcolor);
                doo_compose_css('.head-main-nav ul.main-header li ul.sub-menu li a','color',$facolor);
                doo_compose_css('.head-main-nav ul.main-header li ul.sub-menu li a:hover','color',$fhcolor);
                break;
        }

        if($style == 'dark' && $playsze == 'bigger'){
            doo_compose_css('.dooplay_player','border-bottom','none');
        }

		// custom CSS
		if($custom) echo "\n$custom\n";
		echo "</style>\n";
	}
	add_action('wp_head','header_output');
}

// Generate CSS Line
function doo_compose_css($class, $type, $val) {
	echo sprintf('%s{%s:%s;}', $class, $type, $val)."\n";
}
