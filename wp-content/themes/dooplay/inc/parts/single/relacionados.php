<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.1.3
*
*/

if(doo_is_true('permits','esst') == true){

    // Related content ( 3 relations )
	echo '<div class="sbox srelacionados">';
	echo '<h2>'. __d('Similar titles'). '</h2>';
	echo '<div id="single_relacionados">';
	global $post;
	$tags = wp_get_post_terms( $post->ID, 'genres');
	if ($tags) {

        // Get iTags
		$itag[1] = isset( $tags[0] ) ? $tags[0]->term_id : null;
		$itag[2] = isset( $tags[1] ) ? $tags[1]->term_id : null;
		$itag[3] = isset( $tags[2] ) ? $tags[2]->term_id : null;

        // The Args
        $args = array(
			'post_type'      => get_post_type($post->ID),
			'posts_per_page' => 12,
			'post__not_in'   => array( $post->ID ),
			'orderby'        => 'rand',
			'order'          => 'asc',
            // Check relationship
            'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'genres',
					'terms'    => $itag[1],
					'field'    => 'id',
					'operator' => 'IN'
				),
				array(
					'taxonomy' => 'genres',
					'terms'    => $itag[2],
					'field'    => 'id',
					'operator' => 'IN'
				),
				array(
					'taxonomy' => 'genres',
					'terms'    => $itag[3],
					'field'    => 'id',
					'operator' => 'IN'
				)
			)
		);

		$related = get_posts($args);
		$i = 0;
		if( $related ) {
			global $post;
			$temp_post = $post;
			foreach($related as $post) {
				setup_postdata($post);
                // The view
				echo '<article><a href="'. get_the_permalink( $post->ID ). '">';
				echo '<img src="'.dbmovies_get_poster($post->ID).'" alt="'. get_the_title( $post->ID ). '" />';
				echo '</a></article>';
			}
			$post = $temp_post;
		}
	}
	echo '</div></div>';
}
// End Script
