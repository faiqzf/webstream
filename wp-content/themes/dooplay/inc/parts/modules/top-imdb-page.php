<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.3.1
*
*/

// Compose Module Data
$mvote = cs_get_option('topimdbminvt','100');
$rangt = cs_get_option('topimdbrangt','12');
$items = cs_get_option('itopimdb','50');
$layou = cs_get_option('topimdblayout','movtv');
$date = date('Y-m-d', strtotime("-$rangt months"));

// Transient data
$page_topmovies = get_transient('dooplay_page_topmovies');
$page_toptvshow = get_transient('dooplay_page_toptvshow');

// Query for Movies
if(false === $page_topmovies){
    $query_movies = array(
        'post_type' => 'movies',
    	'showposts' => $items,
    	'meta_key'  => 'imdbRating',
    	'orderby'   => 'meta_value_num',
    	'order'     => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'release_date',
                'value' => $date,
                'compare' => '>='
            ),
            array(
                'key' => 'imdbVotes',
                'value' => $mvote,
                'type' => 'numeric',
                'compare' => '>='
            )
        )
    );
    // Get Post ID's
    $page_topmovies = new WP_Query($query_movies);
    $page_topmovies = wp_list_pluck($page_topmovies->posts,'ID');
    // Save Data in cache
    set_transient('dooplay_page_topmovies',$page_topmovies, 1 * HOUR_IN_SECONDS);
}

// Query for TV Shows
if(false === $page_toptvshow){
    $query_tvshows = array(
        'post_type'  => 'tvshows',
    	'showposts'  => $items,
    	'meta_key' 	 => 'imdbRating',
    	'orderby'    => 'meta_value_num',
    	'order'      => 'DESC',
        'meta_query' => array(
            array(
                'key' => 'last_air_date',
                'value' => $date,
                'compare' => '>='
            ),
            array(
                'key' => 'imdbVotes',
                'value' => $mvote,
                'type' => 'numeric',
                'compare' => '>='
            )
        )
    );
    // Get Post ID's
    $page_toptvshow = new WP_Query($query_tvshows);
    $page_toptvshow = wp_list_pluck($page_toptvshow->posts,'ID');
    // Save Data in cache
    set_transient('dooplay_page_toptvshow',$page_toptvshow, 1 * HOUR_IN_SECONDS);
}

// Compose Templates
switch($layou){
	case 'movtv':
		echo "<div class='top-imdb-list tleft'>";
		echo "<h3>".__d('Movies')."</h3>";
        if($page_topmovies){
            $num = 1;
            foreach($page_topmovies as $key => $post_id) {
                doo_topimdb_item($num, $post_id);
                $num++;
            }
        }
		echo "</div><div class='top-imdb-list tright'>";
		echo "<h3>".__d('TVShows')."</h3>";
        if($page_toptvshow){
            $num = 1;
            foreach($page_toptvshow as $key => $post_id) {
                doo_topimdb_item($num, $post_id);
                $num++;
            }
        }
		echo "</div>";
	break;

	case 'movie':
		echo "<div class='top-imdb-list fix-layout-top'>";
		echo "<h3>".__d('Movies')."</h3>";
        if($page_topmovies){
            $num = 1;
            foreach($page_topmovies as $key => $post_id) {
                doo_topimdb_item($num, $post_id);
                $num++;
            }
        }
		echo "</div>";
	break;

	case 'tvsho':
		echo "<div class='top-imdb-list fix-layout-top'>";
		echo "<h3>".__d('TVShows')."</h3>";
        if($page_toptvshow){
            $num = 1;
            foreach($page_toptvshow as $key => $post_id) {
                doo_topimdb_item($num, $post_id);
                $num++;
            }
        }
		echo "</div>";
	break;
}


// End Module TOP IMDb
