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
	<?php get_template_part('inc/parts/sidebar'); ?>
	<div class="content">
		<header><h1><?php _d('Page not found'); ?></h1></header>
		<div class="search-page">
			<div class="no-result animation-2">
				<h2><?php _d('ERROR'); ?> <span>404</span></h2>
				<strong><?php _d('Suggestions'); ?>:</strong>
				<ul>
					<li><?php _d('Verify that the link is correct.'); ?></li>
					<li><?php _d('Use the search box on the page.'); ?></li>
					<li><?php _d('Contact support page.'); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
