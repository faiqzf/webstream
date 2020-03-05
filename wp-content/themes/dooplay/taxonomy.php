<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.1.3
*
*/
get_header(); ?>
<div class="module">
	<div class="content">
	<header>
		<h1><?php printf( __d('%s'), '' . single_tag_title('', false ) . ''); ?></h1>
	</header>
	<div class="desc_category">
		<?php echo category_description(); ?>
	</div>
	<div class="<?php if(is_tax('dtquality')) { echo 'slider'; } else { echo 'items'; } ?>">
	<?php if(have_posts()) :while (have_posts()) : the_post();
		if(is_tax('dtquality')) { get_template_part('inc/parts/item_b'); } else { get_template_part('inc/parts/item'); }
	endwhile; endif; ?>
	</div>
	<?php doo_pagination(); ?>
	</div>
	<?php get_template_part('inc/parts/sidebar'); ?>
</div>
<?php get_footer(); ?>
