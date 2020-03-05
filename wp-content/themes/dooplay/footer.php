<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.2.6
*
*/
// Options
$focode = get_option('_dooplay_footer_code');
$footer = cs_get_option('footer');
$fotext = cs_get_option('footertext');
$foclm1 = cs_get_option('footerc1');
$foclm2 = cs_get_option('footerc2');
$foclm3 = cs_get_option('footerc3');
$focopy = cs_get_option('footercopyright');
$fologo = doo_compose_image_option('logofooter');
// Copyright
$copytext = sprintf( __d('%s %s by %s. All Rights Reserved. Powered by %s'), '&copy;', date('Y'), '<strong>'.get_option('blogname').'</strong>', '<a href="https://doothemes.com/items/dooplay/"><strong>DooPlay</strong></a>' );
$copyright = isset($focopy) ? str_replace('{year}', date('Y'), $focopy) : $copytext;
// Print Header
?>
</div>
<footer class="main">
	<div class="fbox">
		<div class="fcmpbox">
			<?php if( $footer == 'complete' ) { ?>
			<div class="primary">
				<div class="columenu">

					<div class="item">
					   <?php echo ( $foclm1 ) ? '<h3>'. $foclm1. '</h3>' : null; ?>
					   <?php wp_nav_menu( array('theme_location' => 'footer1', 'fallback_cb' => null ) ); ?>
					</div>

					<div class="item">
						<?php echo ( $foclm2 ) ? '<h3>'. $foclm2. '</h3>' : null; ?>
						<?php wp_nav_menu( array('theme_location' => 'footer2', 'fallback_cb' => null)); ?>
					</div>

					<div class="item">
						<?php echo ( $foclm3 ) ? '<h3>'. $foclm3. '</h3>' : null; ?>
						<?php wp_nav_menu( array('theme_location' => 'footer3', 'fallback_cb' => null)); ?>
					</div>

				</div>
				<div class="fotlogo">
					<?php
					// Logo And text
					echo ( $fologo ) ? '<div class="logo"><img src="'. $fologo .'" alt="'.get_option('blogname').'" /></div>' : null;
					echo ( $fotext ) ? '<div class="text"><p>'. $fotext. '</p></div>' : null;
					?>
				</div>
			</div>
			<?php } ?>
			<div class="copy"><?php echo $copyright; ?></div>
			<span class="top-page"><a id="top-page"><i class="icon-angle-up"></i></a></span>
			<?php wp_nav_menu( array('theme_location' => 'footer','container_class' => 'fmenu', 'fallback_cb' => null ) ); ?>
		</div>
	</div>
</footer>
</div>
<?php wp_footer();  if( $focode ) echo stripslashes( $focode ). "\n"; ?>
<div id="oscuridad"></div>
<?php if(is_single() == true AND get_post_type() != 'seasons' AND get_post_meta($post->ID, 'imagenes', true) ) { ?>
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev"><?php _d('&lsaquo;'); ?></a>
    <a class="next"><?php _d('&rsaquo;'); ?></a>
    <a class="close"><?php _d('&times;'); ?></a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<?php } ?>
</body>
</html>
