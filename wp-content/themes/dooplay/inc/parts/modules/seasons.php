<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.1.9
*
*/

// Compose data MODULE
$orde = cs_get_option('seasonsmodorderby','date');
$ordr = cs_get_option('seasonsmodorder','DESC');
$auto = doo_is_true('seasonsmodcontrol','autopl');
$sldr = doo_is_true('seasonsmodcontrol','slider');
$pitm = cs_get_option('seasonsitems','10');
$titl = cs_get_option('seasonstitle','Seasons');
$pmlk = get_post_type_archive_link('seasons');
$totl = doo_total_count('seasons');

// Compose Query
$query = array(
	'post_type' => array('seasons'),
	'showposts' => $pitm,
	'orderby'   => $orde,
	'order'     => $ordr
);

// End Data
?>
<header>
	<h2><?php echo $titl; ?></h2>
	<?php if($sldr == true && !$auto){ ?>
	<div class="nav_items_module">
	  <a class="btn prev2"><i class="icon-caret-left"></i></a>
	  <a class="btn next2"><i class="icon-caret-right"></i></a>
	</div>
	<?php } ?>
	<span><?php echo $totl; ?> <a href="<?php echo $pmlk; ?>" class="see-all"><?php _d('See all'); ?></a></span>
</header>
<div id="seaload" class="load_modules"><?php _d('Loading..'); ?></div>
<div <?php if($sldr == true) echo 'id="dt-seasons" '; ?>class="animation-2 items">
	<?php query_posts($query); while(have_posts()){ the_post(); get_template_part('inc/parts/item_se'); } wp_reset_query(); ?>
</div>
