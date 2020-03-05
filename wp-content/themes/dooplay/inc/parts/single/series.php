<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.1.5
*
*/

// All Postmeta
$postmeta = doo_postmeta_tvshows($post->ID); // doo_isset($postmeta, '')
$adsingle = doo_compose_ad('_dooplay_adsingle');
// Get User ID
global $user_ID;

// Movies Meta data
$dt_clgnrt = doo_get_postmeta('clgnrt');
// Datos
$backgound = cs_get_option('dynamicbg');
$manually  = doo_isset($_GET,'manually');
// Image
$dynamicbg  = dbmovies_get_rand_image(doo_isset($postmeta,'imagenes'));
// Update Status for generator
if($manually == 'true') {
    if( $user_ID && current_user_can('level_10') ) {
        update_post_meta($post->ID,'clgnrt','1');
    }
}

// Dynamic Background
if($backgound == true) { ?>
<style>
#dt_contenedor {
    background-image: url(<?php echo $dynamicbg; ?>);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-position: 50% 0%;
}
</style>
<?php } ?>

<!-- Start Single POST -->
<div id="single" class="dtsingle">

    <!-- Start Post -->
    <?php if(have_posts()): while(have_posts()): the_post(); doo_set_views($post->ID); ?>
    <div class="content">



        <!-- Head Show Info -->
        <div class="sheader">
	        <div class="poster">
	            <img src="<?php echo dbmovies_get_poster($post->ID); ?>" alt="<?php the_title(); ?>">
	        </div>
	        <div class="data">
		        <h1><?php the_title(); ?></h1>
        		<div class="extra">
        			<?php if($d = doo_isset($postmeta, 'first_air_date')) echo '<span class="date">'.doo_date_compose($d,false).'</span>'; ?>
        			<span><?php echo get_the_term_list($post->ID, 'dtnetworks', '', '', ''); ?></span>
        		</div>
		        <?php echo do_shortcode('[starstruck_shortcode]'); ?>
        		<div class="sgeneros">
        		    <?php echo get_the_term_list($post->ID, 'genres', '', '', ''); ?>
        		</div>
            </div>
        </div>


        <!-- Show Tab single -->
        <div class="single_tabs">
            <?php if(is_user_logged_in() && doo_is_true('permits','eusr')){ ?>
            <div class="user_control">
                <?php dt_list_button( $post->ID ); dt_views_button( $post->ID ); ?>
            </div>
            <?php } ?>
        	<ul id="section" class="smenu idTabs">
                <?php if($dt_clgnrt == '1') echo '<li><a href="#episodes">'.__d('Episodes').'</a></li>'; ?>
        	    <li><a href="#info"><?php _d('Info'); ?></a></li>
        	    <?php if(doo_isset($postmeta,'dt_cast')) echo '<li><a href="#cast">'.__d('Cast').'</a></li>'; ?>
        	    <?php if(doo_isset($postmeta,'youtube_id')) echo '<li><a href="#trailer">'.__d('Trailer').'</a></li>'; ?>
        	</ul>
        </div>

        <!-- Single Post Ad -->
        <?php if($adsingle) echo '<div class="module_single_ads">'.$adsingle.'</div>'; ?>

        <!-- Seasons and Episodes List -->
        <?php get_template_part('inc/parts/single/listas/seasons_episodes'); ?>

        <!-- Show Cast -->
        <div id="cast" class="sbox fixidtab">
        	<h2><?php _d('Creator'); ?></h2>
        	<div class="persons">
        		<?php  doo_creator(doo_isset($postmeta,'dt_creator'), "img", true); ?>
        	</div>
        	<h2><?php _d('Cast'); ?></h2>
        	<div class="persons">
        		<?php doo_cast(doo_isset($postmeta,'dt_cast'), "img", true); ?>
        	</div>
        </div>

        <!-- Show Trailer -->
        <?php if($trailers = doo_isset($postmeta,'youtube_id')){ ?>
        <div id="trailer" class="sbox fixidtab">
        	<h2><?php _d('Video trailer'); ?></h2>
        	<div class="videobox">
        		<div class="embed">
        			<?php echo doo_trailer_iframe($trailers) ?>
        		</div>
        	</div>
        </div>
        <?php } ?>

        <!-- Show Information -->
        <div id="info" class="sbox fixidtab">
            <h2><?php _d('Synopsis'); ?></h2>
            <div class="wp-content">
                <?php the_content(); ?>
                <?php the_tags('<ul class="wp-tags"><li>','</li><li>','</li></ul>'); ?>
                <?php dbmovies_get_images(doo_isset($postmeta,'imagenes')); ?>
            </div>
            <?php if($d = doo_isset($postmeta,'original_name')) { ?>
            <div class="custom_fields">
                <b class="variante"><?php _d('Original title'); ?></b>
                <span class="valor"><?php echo $d; ?></span>
            </div>
            <?php } if($d = doo_isset($postmeta, 'imdbRating')) { ?>
            <div class="custom_fields">
                <b class="variante"><?php _d('TMDb Rating'); ?></b>
                <span class="valor">
                    <b id="repimdb"><?php echo '<strong>'.$d.'</strong> '; if($votes = doo_isset($postmeta, 'imdbVotes')) echo sprintf( __d('%s votes'), number_format($votes) ); ?></b>
                </span>
            </div>
            <?php } if($d = doo_isset($postmeta,'first_air_date')) { ?>
            <div class="custom_fields">
                <b class="variante"><?php _d('First air date'); ?></b>
                <span class="valor"><?php doo_date_compose($d); ?></span>
            </div>
            <?php } if($d = doo_isset($postmeta,'last_air_date')) { ?>
            <div class="custom_fields">
                <b class="variante"><?php _d('Last air date'); ?></b>
                <span class="valor"><?php doo_date_compose($d); ?></span>
            </div>
            <?php } if($d = doo_isset($postmeta,'number_of_seasons')) { ?>
            <div class="custom_fields">
                <b class="variante"><?php _d('Seasons'); ?></b>
                <span class="valor"><?php echo $d; ?></span>
            </div>
            <?php } if($d = doo_isset($postmeta,'number_of_episodes')) { ?>
            <div class="custom_fields">
                <b class="variante"><?php _d('Episodes'); ?></b>
                <span class="valor"><?php echo $d; ?></span>
            </div>
            <?php } if($d = doo_isset($postmeta,'episode_run_time')) { ?>
            <div class="custom_fields">
                <b class="variante"><?php _d('Average Duration'); ?></b>
                <span class="valor"><?php echo sprintf( __d('%s minutes'), $d); ?> </span>
            </div>
            <?php } ?>
        </div>

        <!-- Show Social Links -->
        <?php doo_social_sharelink($post->ID); ?>

        <!-- Show Related content -->
        <?php if(DOO_THEME_RELATED) get_template_part('inc/parts/single/relacionados'); ?>

        <!-- Show comments -->
        <?php get_template_part('inc/parts/comments'); ?>

        <!-- Show breadcrumb -->
        <?php doo_breadcrumb($post->ID, 'tvshows', __d('TV Shows'), 'breadcrumb_bottom'); ?>

    </div>
    <!-- End Post -->
    <?php endwhile; endif; ?>


    <!-- Show Sidebar -->
    <div class="sidebar scrolling">
    	<?php dynamic_sidebar('sidebar-tvshows'); ?>
    </div>


</div>
<!-- End Single POST -->
