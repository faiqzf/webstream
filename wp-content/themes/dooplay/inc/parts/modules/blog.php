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

// Compose DATA
$title = cs_get_option('blogtitle','Last entries');
$items = cs_get_option('blogitems','5');
$words = cs_get_option('blogwords','190');
$perml = doo_compose_pagelink('pageblog');

// Compose Query
$query = array(
	'post_type' => array('post'),
	'showposts' => $items,
	'order' => 'desc'
);

// End Data
?>
<header>
	<h2><?php echo $title; ?></h2>
	<?php if($perml) { ?><span><a href="<?php echo $perml; ?>"><?php _d('See all'); ?></a></span><?php } ?>
</header>
<div class="list-items-blogs">
	<?php query_posts($query); ?>
	<?php if (have_posts()): while(have_posts()): the_post(); ?>
	<div class="post-entry" id="entry-<?php the_id(); ?>">
		<div class="home-blog-post">
			<div class="entry-date">
				<div class="date"><?php doo_post_date('j'); ?></div>
				<div class="month"><?php doo_post_date('F'); ?></div>
			</div>
			<div class="entry-datails">
				<div class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
				<div class="entry-content"><?php dt_content_alt($words); ?></div>
			</div>
		</div>
	</div>
	<?php endwhile;  else: ?>
	<div class="dt-no-post"><?php _d('No posts to show'); ?></div>
	<?php endif;  wp_reset_query(); ?>
</div>
