<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.3
*
*/

$postmeta  = doo_postmeta_episodes($post->ID);
$airdate = doo_isset($postmeta,'air_date');
$airdate = ($airdate) ? ' / '.doo_date_compose($airdate, false) : '';
// End PHP
?>
<article class="item se <?php echo get_post_type(); ?>" id="post-<?php the_id(); ?>">
	<div class="poster">
		<img src="<?php echo dbmovies_get_poster($post->ID,'dt_episode_a','dt_backdrop','w300'); ?>" alt="<?php the_title(); ?>">
		<div class="season_m animation-1">
			<a href="<?php the_permalink() ?>"><div class="see"></div></a>
		</div>
		<?php if($mostrar = get_the_term_list( $post->ID, 'dtquality')) {  ?><span class="quality"><?php echo strip_tags($mostrar); ?></span><?php } ?>
	</div>
	<div class="data">
		<h3><a href="<?php the_permalink() ?>"><?php echo doo_isset($postmeta,'episode_name'); ?></a></h3>
		<span><?php echo sprintf( __d('S%s E%s'), doo_isset($postmeta,'temporada'), doo_isset($postmeta,'episodio')).$airdate; ?></span>
        <span class="serie"><?php echo doo_isset($postmeta,'serie'); ?></span>
	</div>
</article>
