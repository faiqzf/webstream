<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.1.8
*
*/

// Compose data MODULE
$sldr = doo_is_true('moviemodcontrol','slider');
$auto = doo_is_true('moviemodcontrol','autopl');
$orde = cs_get_option('moviemodorderby','date');
$ordr = cs_get_option('moviemodorder','DESC');
$pitm = cs_get_option('movieitems','10');
$titl = cs_get_option('movietitle','Movies');
$pmlk = get_post_type_archive_link('movies');
$totl = doo_total_count('movies');
$eowl = ($sldr == true) ? 'id="dt-movies" ' : false;

// Compose Query
$query = array(
	'post_type' => array('movies'),
	'showposts' => $pitm,
	'orderby' 	=> $orde,
	'order' 	=> $ordr
);

// End Data
?>
<header>
	<h2><?php echo $titl; ?></h2>
	<?php if($sldr == true && !$auto) { ?>
	<div class="nav_items_module">
	  <a class="btn prev3"><i class="icon-caret-left"></i></a>
	  <a class="btn next3"><i class="icon-caret-right"></i></a>
	</div>
	<?php } ?>
	<span><?php echo $totl; ?> <a href="<?php echo $pmlk; ?>" class="see-all"><?php _d('See all'); ?></a></span>
</header>
<div id="movload" class="load_modules"><?php _d('Loading..'); ?></div>
<div <?php echo $eowl; ?>class="items">
	<?php query_posts($query); while(have_posts()){ the_post(); get_template_part('inc/parts/item'); } wp_reset_query(); ?>
</div>
