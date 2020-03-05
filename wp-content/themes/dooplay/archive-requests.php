<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.1.7
*
*/
get_header(); ?>
<div class="requests">
	<nav class="requests_main_nav">
		<h1><?php _d('Requests List'); ?> <span><?php echo doo_total_count('requests'); ?></span></h1>
		<a id="discoverclic" for="iterm" class="add_request"><?php _d('+ Add new'); ?></a>
		<a id="closediscoverclic" class="add_request hidde"><?php _d('Go back'); ?></a>
		<ul class="requests_menu_filter hidde">
			<li class="filtermenu"><a data-type="movie" class="active"><?php _d('Movies'); ?></a></li>
			<li class="filtermenu"><a data-type="tv"><?php _d('TVShows'); ?></a></li>
		</ul>
		<ul class="requests_menu">
			<li class="rmenu"><a data-tab="listrequests" class="active"><?php _d('All'); ?></a></li>
		</ul>
	</nav>
	<div id="discover" class="discover hidde">
		<div class="fixbox">
			<div class="box animation-1">
				<form id="discover_requests">
					<input type="text" id="term" name="term" placeholder="<?php _d('Search a title..'); ?>" autocomplete="off">
					<input type="hidden" id="type" name="type" value="movie">
					<input type="hidden" id="nonce" name="nonce" value="<?php echo wp_create_nonce('dbmovies_requests_users'); ?>">
					<input type="hidden" id="action" name="action" value="dbmovies_requests_search">
					<input type="hidden" id="page" name="page" value="1">
					<button class="filter" id="get_requests" type="submit"><span class="icon-search2"></span></button>
				</form>
			</div>
		</div>
		<div id="discover_results" class="discover_results content">
			<div class="metainfo"><?php _d('Find a title you want to suggest'); ?></div>
		</div>
	</div>
    <div class="post_request">
		<div id="post_request_archive" class="box_post"></div>
	</div>
	<div id="requests" class="content">
		<div class="tabox current" id="listrequests">
			<div class="items">
            <?php if (have_posts()) { while (have_posts()) { the_post(); $meta = doo_get_postmeta('_dbmv_requests_post'); ?>
                    <article id="post-<?php the_ID(); ?>" class="item animation-1">
    					<div class="box">
    						<div data-id="<?php the_ID(); ?>" class="poster post-request">
                                <span class="status"><?php _d('Soon'); ?></span>
                                <img src="<?php echo 'https://image.tmdb.org/t/p/w185'. $meta['poster']; ?>" alt="<?php the_title(); ?>">
                            </div>
    						<h3><?php the_title(); ?></h3>
    					</div>
    				</article>
                <?php } } ?>
			</div>
		</div>
        <?php doo_pagination(); ?>
		<div class="tabox" id="addrequests"></div>
	</div>
</div>
<?php get_footer();
