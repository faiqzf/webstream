<?php
/*
Template Name: DT - Rating page
*/
get_header();
$dt = isset( $_GET['get'] ) ? $_GET['get'] : null;
$admin = isset( $_GET['admin'] ) ? $_GET['admin'] : null;
if($dt == 'movies'):
	$setion = array('movies');
elseif($dt == 'tv'):
	$setion = array('tvshows');
else:
	$setion = array('movies','tvshows');
endif;
doo_glossary();
?>

<div class="module">
	<div class="content">
	<header>
		<h1><?php _d('Ratings'); ?></h1>
		<span class="s_trending">
			<a href="<?php the_permalink() ?>" class="m_trending <?php echo $dt == '' ? 'active' : ''; ?>"><?php _d('See all'); ?></a>
			<a href="<?php the_permalink() ?>?get=movies" class="m_trending <?php echo $dt == 'movies' ? 'active' : ''; ?>"><?php _d('Movies'); ?></a>
			<a href="<?php the_permalink() ?>?get=tv" class="m_trending <?php echo $dt == 'tv' ? 'active' : ''; ?>"><?php _d('TV Show'); ?></a>
		</span>
	</header>
		<div class="items">
		<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		query_posts(array(
			'post_type'    => $setion,
			'meta_key'     => 'end_time',
			'meta_compare' => '>=',
			'meta_value'   => time() ,
			'meta_key'     => DOO_MAIN_RATING,
			'orderby'      => 'meta_value_num',
			'order'        => 'DESC',
			'paged'        => $paged
		));

		while (have_posts()):
			the_post(); ?>
		<?php get_template_part('inc/parts/item'); ?>
		<?php endwhile; ?>
		</div>
		<?php doo_pagination(); ?>
		</div>
		<?php get_template_part('inc/parts/sidebar'); ?>
</div>
<?php get_footer();
