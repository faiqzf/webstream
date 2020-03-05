<?php
/*
Template Name: DT - Posts page
*/

// Get Header
get_header();

// Paged Info
$crrpage = get_query_var('paged') ? get_query_var('paged') : 1;
$perpage = cs_get_option('bperpage','10');
// Recalculate Page
query_posts(array('showposts' => $perpage,'paged' => $crrpage,'order' => 'DESC','post_type' => 'post'));

// End PHP
?>
<div class="module">
	<div class="content fix_posts_templante">
		<header>
			<h1><?php the_title(); ?></h1>
		</header>
		<div class="blog-list-items">
			<?php if (have_posts()) : while ( have_posts() ) : the_post();
			$thumb_id = get_post_thumbnail_id();
			$thumb_url =  wp_get_attachment_image_src($thumb_id,'dt_episode_a', true);
			?>
			<div class="entry animation-2">
				<article class="post">
					<a href="<?php the_permalink(); ?>">
					<div class="images">
							<img src="<?php echo ($thumb_id) ? $thumb_url[0] : DOO_URI. '/assets/img/no/backdrop.png'; ?>" alt="<?php the_title(); ?>" />
							<div class="background_over_image"></div>
					</div>
					</a>
					<div class="information">
						<h2><?php the_title(); ?></h2>
						<div class="meta">
							<span class="autor"><i class="icon-account_circle"></i> <?php the_author(); ?></span>
							<span class="date"><?php doo_post_date('F j, Y'); ?></span>
						</div>
						<p class="descr"><?php dt_content_alt('180'); ?></p>
					</div>
				</article>
			</div>
			<?php endwhile;  else: ?>
			<div class="dt-no-post"><?php _d('No posts to show'); ?></div>
			<?php endif; ?>
		</div>
		<?php doo_pagination(); ?>
	</div>
	<?php get_template_part('inc/parts/sidebar'); ?>
</div>
<?php get_footer(); ?>
