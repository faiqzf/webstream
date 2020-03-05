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


// All Postmeta
$postmeta = doo_postmeta_seasons($post->ID);
$adsingle = doo_compose_ad('_dooplay_adsingle');
// Get User ID
global $user_ID;
// Main data
$ids    = doo_isset($postmeta,'ids');
$temp   = doo_isset($postmeta,'temporada');
$clgnrt = doo_isset($postmeta,'clgnrt');
$tvshow = doo_get_tvpermalink($ids);
// Link generator
$addlink = wp_nonce_url(admin_url('admin-ajax.php?action=seasonsf_ajax','relative').'&se='.$ids.'&te='.$temp.'&link='.$post->ID ,'add_episodes', 'episodes_nonce');

$title_opti = cs_get_option('dbmvstitleseasons',__d('{name}: Season {season}'));
$title_data = array(
    'name'   => get_the_title($tvshow),
    'season' => $temp
);

// End PHP
?>

<!-- Start Single POST -->
<div id="single" class="dtsingle">

    <!-- Start Post -->
    <?php if (have_posts()) :while (have_posts()) : the_post(); doo_set_views($post->ID); ?>
    <div class="content">

        <!-- Heading Info Season -->
        <div class="sheader">
        	<div class="poster">
        		<a href="<?php echo get_permalink($tvshow); ?>">
        			<img src="<?php echo dbmovies_get_poster($post->ID); ?>" alt="<?php the_title(); ?>">
        		</a>
        	</div>
        	<div class="data">
        		<h1><?php echo dbmovies_title_tags($title_opti, $title_data); ?></h1>
        		<div class="extra">
        			<?php if($d = doo_isset($postmeta,'air_date')) echo '<span class="date">'.doo_date_compose($d,false).'</span>'; ?>
        		</div>
        		<?php echo do_shortcode('[starstruck_shortcode]'); ?>
        		<div class="sgeneros">
        			<a href="<?php echo get_permalink($tvshow); ?>"><?php echo get_the_title($tvshow); ?></a>
        		</div>
        	</div>
        </div>

        <!-- Single Post Ad -->
        <?php if($adsingle) echo '<div class="module_single_ads">'.$adsingle.'</div>'; ?>

        <!-- Content and Episodes list -->
        <div class="sbox">
            <?php if(get_the_content()){ ?>
            <div class="wp-content" style="margin-bottom: 10px;">
        	    <?php the_content(); ?>
        	</div>
            <?php } ?>
            <?php get_template_part('inc/parts/single/listas/seasons'); ?>
        </div>

        <!-- Season social links -->
    	<?php doo_social_sharelink($post->ID); ?>

        <!-- Season comments -->
        <?php get_template_part('inc/parts/comments'); ?>

    </div>
    <!-- End Post-->
    <?php endwhile; endif; ?>


    <!-- Season sidebar -->
    <div class="sidebar scrolling">
    	<?php dynamic_sidebar('sidebar-seasons'); ?>
    </div>


</div>
<!-- End Single -->
