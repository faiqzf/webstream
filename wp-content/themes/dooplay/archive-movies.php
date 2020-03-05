<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.1.3
*
*/
get_header();
doo_glossary('movies');
echo '<div class="module"><div class="content">';
get_template_part('inc/parts/modules/featured-post-movies');
echo '<header class="archive_post"><h1>'. __d('Movies').'</h1><span>'.doo_total_count('movies').'</span></header>';
echo '<div id="archive-content" class="animation-2 items">';
if(have_posts()){
    while(have_posts()){
        the_post();
		get_template_part('inc/parts/item');
	}
}
echo '</div>';
doo_pagination();
echo '</div>';
get_template_part('inc/parts/sidebar');
echo '</div>';
get_footer();
