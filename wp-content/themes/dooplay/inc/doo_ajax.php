<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.2.0
*
*/


/* POST Links Ajax
========================================================
*/
if(!function_exists('dt_main_ajax')){
	function dt_main_ajax() {
        wp_enqueue_script('dt_main_ajax', doo_compose_javascript('front.ajax'), array('jquery'), DOO_VERSION, false );
        wp_localize_script('dt_main_ajax', 'dtAjax', array(
            'url'		=>	admin_url('admin-ajax.php', 'relative'),
            'loading'	=> __d('Loading..'),
            'afavorites' => __d('Add to favorites'),
            'rfavorites' => __d('Remove of favorites'),
            'remove'	=> __d('Remove'),
            'isawit'	=> __d('I saw it'),
            'send'		=> __d('Data send..'),
            'updating'	=> __d('Updating data..'),
            'error'		=> __d('Error'),
            'pending'	=> __d('Pending review'),
            'ltipe'		=> __d('Download'),
            'sending'	=> __d('Sending data'),
            'enabled'	=> __d('Enable'),
            'disabled'	=> __d('Disable'),
            'trash'		=> __d('Delete'),
            'lshared'	=> __d('Links Shared'),
            'ladmin'	=> __d('Manage pending links'),
            'sendingrep'=> __d('Please wait, sending data..'),
            'ready'		=> __d('Ready'),
            'deletelin' => __d('Do you really want to delete this link?')
        ));
	}
	add_action('wp_enqueue_scripts','dt_main_ajax');
}


/* POST Reports AJAX
========================================================
*/
if( ! function_exists( 'dt_post_reports_ajax' ) ) {
	function dt_post_reports_ajax() {
		set_time_limit(30000);
        $nonce = doo_isset($_POST,'send-report-nonce');
        if(wp_verify_nonce($nonce, 'send-report')){
			$idpost		= doo_isset($_POST,'idpost');
			$mensaje	= doo_isset($_POST,'mensaje');
            $repy		= doo_isset($_POST,'reportmail');
			$permalink	= esc_url(get_permalink($idpost));
			$title		= esc_html(get_the_title($idpost));
			$ip			= doo_client_ipaddress();
			$num_report = get_post_meta($idpost, 'numreport', true);
			$name		= get_option('blogname');
			$asunto		= __d('BUG REPORT').": ". $title;
			$to			= get_option('admin_email');
			$url		= get_option('siteurl');
            if(!$num_report){
                $num_report = 1;
            } else{
                $num_report++;
            }
            update_post_meta($idpost, 'numreport', $num_report);
			$message	= "
			<strong>". $title ."</strong>
			<br>
			-------------------------------------<br>
			<br>
			<strong>". __d('Message') .":</strong><br>
			<br>
			". doo_clear_text($mensaje) ."<br>
			<br>
			-------------------------------------<br>
			<br>
			<strong>". __d('Permalink') .":</strong> ". $permalink ."<br>
			<strong>". __d('Edit post') .":</strong> ". $url ."/wp-admin/post.php?post=".$idpost."&action=edit<br>
			<br>
			-------------------------------------<br>
			<br>
			<strong>". __d('IP') .":</strong> ". $ip ."<br>
			";
			$headers[]	= 'Content-Type: text/html; charset=UTF-8';
			$headers[]	= 'From: '. $name .'  <'. $to .'>';
			$headers[]	= 'Reply-To: '. $repy;
			wp_mail( $to, $asunto , $message,  $headers );
			echo "<i class='icon-check_circle send'></i>\n";
			echo "<p>". __d('Thank you! Your report was submitted..'). "</p>\n";
		}
		wp_die();
	}
	add_action('wp_ajax_reports_ajax', 'dt_post_reports_ajax');
	add_action('wp_ajax_nopriv_reports_ajax', 'dt_post_reports_ajax');
}


/* Update user account page
========================================================
*/
if(!function_exists('dt_update_user_page')) {
	function dt_update_user_page() {
		set_time_limit(30);
		global $current_user, $wp_roles;

		$nonce = doo_isset($_POST,'update-user-nonce');
		$pass1 = doo_isset($_POST,'pass1');
		$pass2 = doo_isset($_POST,'pass2');
		$usurl = doo_isset($_POST,'url');
		$fname = doo_isset($_POST,'first-name');
		$lname = doo_isset($_POST,'last-name');
		$dname = doo_isset($_POST,'display_name');
		$descr = doo_isset($_POST,'description');
		$twitt = doo_isset($_POST,'twitter');
		$faceb = doo_isset($_POST,'facebook');
		$gplus = doo_isset($_POST,'gplus');

		if( isset($nonce ) and wp_verify_nonce($nonce, 'update-user') ) {
			$error = array();

			wp_get_current_user();

			// update password
			if (!empty($pass1) && !empty($pass2)) {
				if ($pass1 == $pass2) {
					wp_update_user( array('ID' => $current_user->ID, 'user_pass' => esc_attr($pass1) ) );
				} else {
					echo '<div class="error"><i class="icon-times-circle"></i> '. __d('The passwords you entered do not match.  Your password was not updated.'). '</div>';
					exit;
				}
			}

			if(!empty($usurl)) wp_update_user(array('ID' => $current_user->ID,'user_url' => esc_attr($usurl)));
			if(!empty($fname)) update_user_meta($current_user->ID, 'first_name', esc_attr($fname));
			if(!empty($lname)) update_user_meta($current_user->ID, 'last_name', esc_attr($lname));
			if(!empty($dname)) wp_update_user(array('ID' => $current_user->ID,'display_name' => esc_attr($dname)));

			update_user_meta($current_user->ID,'display_name', esc_attr($dname));
			update_user_meta($current_user->ID,'description', esc_attr($descr));
			update_user_meta($current_user->ID,'dt_twitter', esc_attr($twitt));
			update_user_meta($current_user->ID,'dt_facebook', esc_attr($faceb));
			update_user_meta($current_user->ID,'dt_gplus', esc_attr($gplus));

			if (count($error) == 0) {
				do_action('edit_user_profile_update', $current_user->ID);
				echo '<div class="sent"><i class="icon-check-circle"></i> '. __d('Your profile has been updated.'). '</div>';
				exit;
			}
		}
		die();
	}
	add_action('wp_ajax_dt_update_user', 'dt_update_user_page');
	add_action('wp_ajax_nopriv_dt_update_user', 'dt_update_user_page');
}

/* Page list account / Movies and TVShows
========================================================
*/
if(!function_exists( 'next_page_list')){
	function next_page_list() {

		$paged    = doo_isset($_POST,'page')+1;
		$type     = doo_isset($_POST,'typepost');
		$user     = doo_isset($_POST,'user');
		$template = doo_isset($_POST,'template');

		$args = array(
		  'paged'			=> $paged,
		  'numberposts'		=> -1,
		  'orderby'			=> 'date',
		  'order'			=> 'DESC',
		  'post_type'		=> array('movies','tvshows'),
		  'posts_per_page'	=> 18,
		  'meta_query'		=> array (
				array (
				  'key' => $type,
				  'value' => 'u'.$user. 'r',
				  'compare' => 'LIKE'
				)
			)
		);

		$sep = '';
		$list_query = new WP_Query( $args );
		if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
			 get_template_part('inc/parts/simple_item_'. $template);
		endwhile;
		else :
		echo '<div class="no_fav">'. __d('No more content to show.'). '</div>';
		endif; wp_reset_postdata();
		die();
	}
	add_action('wp_ajax_next_page_list', 'next_page_list');
	add_action('wp_ajax_nopriv_next_page_list', 'next_page_list');
}


/* Page list links
========================================================
*/
if(!function_exists('next_page_link')){
	function next_page_link() {
		$paged = doo_isset($_POST,'page')+1;
		$user  = doo_isset($_POST,'user');
		$args  = array(
		  'paged'          => $paged,
		  'orderby'        => 'date',
		  'order'          => 'DESC',
		  'post_type'      => 'dt_links',
		  'posts_per_page' => 10,
		  'post_status'    => array('pending', 'publish', 'trash'),
		  'author'         => $user,
		  );
		$list_query = new WP_Query( $args );
		if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
			 get_template_part('inc/parts/item_links');
		endwhile;
		else :
		echo '<tr><td colspan="8">'.__d('No content').'</td></tr>';
		endif; wp_reset_postdata();
		die();
	}
	add_action('wp_ajax_next_page_link', 'next_page_link');
	add_action('wp_ajax_nopriv_next_page_link', 'next_page_link');
}

/* Page list links profile
========================================================
*/
if(!function_exists('next_page_link_profile')){
	function next_page_link_profile() {
		$paged = doo_isset($_POST,'page')+1;
		$user  = doo_isset($_POST,'user');
		$args  = array(
		  'paged'          => $paged,
		  'orderby'        => 'date',
		  'order'          => 'DESC',
		  'post_type'      => 'dt_links',
		  'posts_per_page' => 10,
		  'post_status'    => array('pending', 'publish', 'trash'),
		  'author'         => $user,
		  );
		$list_query = new WP_Query( $args );
		if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
			 get_template_part('inc/parts/item_links_profile');
		endwhile;
		else :
		echo '<tr><td colspan="7">'.__d('No content').'</td></tr>';
		endif; wp_reset_postdata();
		die();
	}
	add_action('wp_ajax_next_page_link_profile', 'next_page_link_profile');
	add_action('wp_ajax_nopriv_next_page_link_profile', 'next_page_link_profile');
}

/* Page list Admin links
========================================================
*/
if(!function_exists('next_page_link_admin')){
	function next_page_link_admin() {
		$paged = doo_isset($_POST,'page')+1;
		$args  = array(
		  'paged'          => $paged,
		  'orderby'        => 'date',
		  'order'          => 'DESC',
		  'post_type'      => 'dt_links',
		  'posts_per_page' => 10,
		  'post_status'    => array('pending'),
		  );
		$list_query = new WP_Query( $args );
		if ( $list_query->have_posts() ) : while ( $list_query->have_posts() ) : $list_query->the_post();
			 get_template_part('inc/parts/item_links_admin');
		endwhile;
		else :
		echo '<tr><td colspan="6">'.__d('No content').'</td></tr>';
		endif; wp_reset_postdata();
		die();
	}
	add_action('wp_ajax_next_page_link_admin', 'next_page_link_admin');
	add_action('wp_ajax_nopriv_next_page_link_admin', 'next_page_link_admin');
}

/* Control post link
========================================================
*/
if(!function_exists('control_link_user')){
	function control_link_user() {

		$post_id = doo_isset($_POST,'post_id');
		$user_id = doo_isset($_POST,'user_id');
		$status	 = doo_isset($_POST,'status');

		$auhor_id = get_current_user_id();
		if($auhor_id) {
		$args = array('ID' => $post_id,'post_status'=> $status);
			wp_update_post( $args );
			if($status == 'publish'){
				echo __d('Link enabled');
			}elseif($status == 'pending'){
				echo __d('Link disabled');
			}elseif($status == 'trash'){
				echo __d('Link moved to trash');
			}
		}
		die();
	}
	add_action('wp_ajax_control_link_user', 'control_link_user');
	add_action('wp_ajax_nopriv_control_link_user', 'control_link_user');
}


/* Live Search
========================================================
*/
if(!function_exists('dooplay_live_search')){
	function dooplay_live_search( $request_data ) {
	   	$parameters = $request_data->get_params();
	    $keyword    = isset($parameters['keyword']) ? doo_clear_text($parameters['keyword']) : false;
	    $nonce      = isset($parameters['nonce']) ? doo_clear_text($parameters['nonce']) : false;
		$types      = array('movies','tvshows');
		if(!dooplay_verify_nonce('dooplay-search-nonce', $nonce)) return array('error' => 'no_verify_nonce', 'title' => __d('No data nonce') );
		if(!isset( $keyword ) || empty($keyword)) return array('error' => 'no_parameter_given');
		if(strlen( $keyword ) <= 2 ) return array('error' => 'keyword_not_long_enough', 'title' => false);
		$args = array(
			's'              => $keyword,
			'post_type'      => $types,
			'posts_per_page' => 5
		);
	    $query = new WP_Query( $args );
	    if ( $query->have_posts() ) {
	    	$data = array();
	        while ( $query->have_posts() ) {
	            $query->the_post();
	            global $post;
	            $data[$post->ID]['title'] = $post->post_title;
	            $data[$post->ID]['url'] = get_the_permalink();
                $data[$post->ID]['img'] = dbmovies_get_poster($post->ID,'dt_poster_b','dt_poster','w92');
				if($dato = doo_get_postmeta('release_date')) {
					$data[$post->ID]['extra']['date'] = substr($dato, 0, 4);
				}
				if($dato = doo_get_postmeta('first_air_date')) {
					$data[$post->ID]['extra']['date'] = substr($dato, 0, 4);
				}
				$data[$post->ID]['extra']['imdb'] = doo_get_postmeta('imdbRating');
	        }
	        return $data;
	    } else {
	    	return array('error' => 'no_posts', 'title' => __d('No results') );
	    }
	    wp_reset_postdata();
	}
}

/* Live Glossary
========================================================
*/
if(!function_exists('dooplay_live_glossary')){
	function dooplay_live_glossary( $request_data ) {
	    $parameters = $request_data->get_params();
	    $term	    = isset($parameters['term']) ? doo_clear_text($parameters['term']) : false;
		$nonce	    = isset($parameters['nonce']) ? doo_clear_text($parameters['nonce']) : false;
	    $type       = isset($parameters['type']) ? doo_clear_text($parameters['type']) : false;
		if( !dooplay_verify_nonce('dooplay-search-nonce', $nonce ) ) return array('error' => 'no_verify_nonce', 'title' => __d('No data nonce') );
	    if( !isset( $term ) || empty($term) ) return array('error' => 'no_parameter_given');
	    if( $type == 'all' )  $post_types = array('movies','tvshows'); else $post_types = $type;
	    $args = array(
	        'doo_first_letter' => $term,
	        'post_type'        => $post_types,
			'post_status'      => 'publish',
	        'posts_per_page'   => 18,
	    	'orderby'          => 'rand',
	    );
	    query_posts( $args );
	    if(have_posts()){
	        $data = array();
	        while ( have_posts() ) {
	            the_post();
	            global $post;
	            $data[$post->ID]['title'] = $post->post_title;
	            $data[$post->ID]['url']   = get_the_permalink();
	            $data[$post->ID]['img']   = dbmovies_get_poster($post->ID,'dt_poster_b','dt_poster','w92');
	            if($dato = doo_get_postmeta('release_date')) $data[$post->ID]['year'] = substr($dato, 0, 4);

				if($dato = doo_get_postmeta('first_air_date')) $data[$post->ID]['year'] = substr($dato, 0, 4);

				$data[$post->ID]['imdb'] = doo_get_postmeta('imdbRating');
	        }
	        return $data;

	    } else {
	        return array('error' => 'no_posts', 'title' => __d('No results') );
	    }
	    wp_reset_query();
	}
}

/* Add Post featured
========================================================
*/
if(!function_exists('dt_add_featured')){
	function dt_add_featured(){
        $postid	 = doo_isset($_REQUEST,'postid');
		$nonce	 = doo_isset($_REQUEST,'nonce');
		$newdate = date("Y-m-d H:i:s");
		if($postid AND wp_verify_nonce( $nonce,'dt-featured-'.$postid)) {
            update_post_meta($postid, 'dt_featured_post','1');
            $post = array(
                'ID'                => $postid,
                'post_modified'     => $newdate,
                'post_modified_gmt' => $newdate
            );
            wp_update_post($post);
		}
		die();
	}
	add_action('wp_ajax_dt_add_featured', 'dt_add_featured');
	add_action('wp_ajax_nopriv_dt_add_featured', 'dt_add_featured');
}

/* Delete Post featured
========================================================
*/
if(!function_exists('dt_remove_featured')){
	function dt_remove_featured(){
		$postid	= doo_isset($_REQUEST,'postid');
		$nonce	= doo_isset($_REQUEST,'nonce');
		if($postid AND wp_verify_nonce($nonce, 'dt-featured-'.$postid)) {
			delete_post_meta( $postid, 'dt_featured_post');
		}
		die();
	}
	add_action('wp_ajax_dt_remove_featured', 'dt_remove_featured');
	add_action('wp_ajax_nopriv_dt_remove_featured', 'dt_remove_featured');
}


/* Filter all content
========================================================
*/
if(!function_exists('dt_social_count')) {
	function dt_social_count() {
		$idpost = doo_isset($_POST,'id');
		$meta   = get_post_meta($idpost,'dt_social_count',true);
        $meta   = isset($meta) ? $meta : '0';
		$meta++;
		update_post_meta( $idpost,'dt_social_count', $meta );
		echo doo_comvert_number($meta);
		die();
	}
	add_action('wp_ajax_dt_social_count', 'dt_social_count');
	add_action('wp_ajax_nopriv_dt_social_count', 'dt_social_count');
}


/* Delete count report
========================================================
*/
if(!function_exists('delete_notice_report')) {
	function delete_notice_report() {
		$id = doo_isset($_GET,'id');
		if(current_user_can('administrator')) {
			update_post_meta($id,'numreport','0');
		}
		wp_redirect($_SERVER['HTTP_REFERER'], 302); exit;
	}
	add_action('wp_ajax_delete_notice_report', 'delete_notice_report');
	add_action('wp_ajax_nopriv_delete_notice_report', 'delete_notice_report');
}
