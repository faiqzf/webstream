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
$orde = cs_get_option('episodesmodorderby','date');
$ordr = cs_get_option('episodesmodorder','DESC');
$pitm = cs_get_option('episodesitems','10');
$titl = cs_get_option('episodestitle','Episodes');
$auto = doo_is_true('episodesmodcontrol','autopl');
$slid = doo_is_true('episodesmodcontrol','slider');
$pmlk = get_post_type_archive_link('episodes');
$totl = doo_total_count('episodes');

// Compose Query
$query = array(
    'post_type' => array('episodes'),
    'showposts' => $pitm,
    'orderby'   => $orde,
    'order'     => $ordr
);

// End Data
?>
<header>
    <h2><?php echo $titl; ?></h2>
    <?php if($slid == true && !$auto){ ?>
    <div class="nav_items_module">
        <a class="btn prev"><i class="icon-caret-left"></i></a>
        <a class="btn next"><i class="icon-caret-right"></i></a>
    </div>
    <?php } ?>
    <span><?php echo $totl; ?> <a href="<?php echo $pmlk; ?>" class="see-all"><?php _d('See all'); ?></a></span>
</header>
<div id="epiload" class="load_modules"><?php _d('Loading..'); ?></div>
<div <?php if($slid) echo 'id="dt-episodes" '; ?>class="animation-2 items">
    <?php query_posts($query); while(have_posts()){ the_post(); get_template_part('inc/parts/item_ep'); } wp_reset_query(); ?>
</div>
