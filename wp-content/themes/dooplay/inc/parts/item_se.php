<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.2.4
*
*/

// Data
$postmeta  = doo_postmeta_seasons($post->ID);
// End PHP
?>
<article class="item se <?php echo get_post_type(); ?>" id="post-<?php the_id(); ?>">
	<div class="poster">
		<img src="<?php echo dbmovies_get_poster($post->ID); ?>" alt="<?php the_title(); ?>">
		<div class="season_m animation-1">
			<a href="<?php the_permalink() ?>">
				<span class="a"><?php _d('season'); ?></span>
				<span class="b"><?php echo doo_isset($postmeta,'temporada'); ?></span>
				<span class="c"><?php echo doo_isset($postmeta,'serie'); ?></span>
			</a>
		</div>
	</div>
	<div class="data">
		<h3><a href="<?php the_permalink() ?>"><?php _d('Season'); ?> <?php echo doo_isset($postmeta,'temporada'); ?></a></h3>
		<span><?php doo_date_compose(doo_isset($postmeta,'air_date')) ?></span>
	</div>
</article>
