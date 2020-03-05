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
$items = cs_get_option('topimdbitems','10');
$layou = cs_get_option('topimdblayout','movtv');
$tpage = doo_compose_pagelink('pagetopimdb');

// Compose Data
$date = date('Y-m-d', strtotime("-$rangt months"));

// Transient data
$home_topmovies = get_transient('dooplay_home_topmovies');
$home_toptvshow = get_transient('dooplay_home_toptvshow');

// Query for Movies
if(false === $home_topmovies){
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
    $home_topmovies = new WP_Query($query_movies);
    $home_topmovies = wp_list_pluck($home_topmovies->posts,'ID');
    set_transient('dooplay_home_topmovies',$home_topmovies, 1 * HOUR_IN_SECONDS);
}

// Query for TV Shows
if(false === $home_toptvshow){
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
    $home_toptvshow = new WP_Query($query_tvshows);
    $home_toptvshow = wp_list_pluck($home_toptvshow->posts,'ID');
    set_transient('dooplay_home_toptvshow',$home_toptvshow, 1 * HOUR_IN_SECONDS);
}

// Compose Templates
switch($layou){

	case 'movtv':
		echo "<div class='top-imdb-list tleft'>";
		echo "<h3>".__d('TOP Movies')." <a class='see_all' href='{$tpage}'>".__d('See all')."</a></h3>";
        if($home_topmovies){
            $num = 1;
            foreach($home_topmovies as $key => $post_id) {
                doo_topimdb_item($num, $post_id);
                $num++;
            }
        }
		echo "</div><div class='top-imdb-list tright'>";
		echo "<h3>".__d('TOP TVShows')." <a class='see_all' href='{$tpage}'>".__d('See all')."</a></h3>";
        if($home_toptvshow){
            $num = 1;
            foreach($home_toptvshow as $key => $post_id) {
                doo_topimdb_item($num, $post_id);
                $num++;
            }
        }
		echo "</div>";
	break;

	case 'movie':
		echo "<div class='top-imdb-list fix-layout-top'>";
		echo "<h3>".__d('TOP Movies')." <a class='see_all' href='{$tpage}'>".__d('See all')."</a></h3>";
        if($home_topmovies){
            $num = 1;
            foreach($home_topmovies as $key => $post_id) {
                doo_topimdb_item($num, $post_id);
                $num++;
            }
        }
		echo "</div>";
	break;

	case 'tvsho':
		echo "<div class='top-imdb-list fix-layout-top'>";
		echo "<h3>".__d('TOP TVShows')." <a class='see_all' href='{$tpage}'>".__d('See all')."</a></h3>";
        if($home_toptvshow){
            $num = 1;
            foreach($home_toptvshow as $key => $post_id) {
                doo_topimdb_item($num, $post_id);
                $num++;
            }
        }
		echo "</div>";
	break;
}

// End Module TOP IMDb
