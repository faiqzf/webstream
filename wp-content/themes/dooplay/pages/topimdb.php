<?php
/*
Template Name: DT - TOP IMDb
*/
get_header();
doo_glossary();
?>

<div class="module">
	<div class="content fix_posts_templante">
		<header class="top_imdb">
			<h1 class="top-imdb-h1"><?php the_title(); ?> <span><?php echo cs_get_option('itopimdb','50'); ?></span></h1>
		</header>
		<?php get_template_part('inc/parts/modules/top-imdb-page'); ?>
	</div>
	<?php get_template_part('inc/parts/sidebar'); ?>
</div>
<?php get_footer(); ?>
