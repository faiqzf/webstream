<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.1.3
*
*/


/* User likes
========================================================
*/

if(!function_exists('dt_process_list')) {
	function dt_process_list(){
		$post_users = false;
		$nonce		= isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
		$total		= isset( $_REQUEST['total'] ) ? true : false;
		if( isset( $_REQUEST['post_id'] ) AND wp_verify_nonce( $nonce, 'dt-list-noce') AND is_user_logged_in() ) {
			$post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : null;
			if ( !dt_already_listed( $post_id ) ) {
				$user_id	= get_current_user_id();
				$post_users = dt_get_user_lists( $user_id, $post_id );

				$user_list_count = get_user_option("user_list_count", $user_id );
				$user_list_count =  ( isset( $user_list_count ) && is_numeric( $user_list_count ) ) ? $user_list_count : 0;
				update_user_option( $user_id, "user_list_count", ++$user_list_count );

				if ( $post_users ) {
					update_post_meta( $post_id, "_dt_list_users", $post_users );
				}
			} else {
				$user_id = get_current_user_id();
				$post_users = dt_get_user_lists( $user_id, $post_id );

				$user_list_count = get_user_option("user_list_count", $user_id );
				$user_list_count =  ( isset( $user_list_count ) && is_numeric( $user_list_count ) ) ? $user_list_count : 0;
				if ( $user_list_count > 0 ) {
					update_user_option( $user_id, 'user_list_count', --$user_list_count );
				}

				if ( $post_users ) {
					$uid_key = array_search( $user_id, $post_users );
					unset( $post_users[$uid_key] );
					update_post_meta( $post_id, "_dt_list_users", $post_users );
				}
			}
			$meta = get_post_meta( $post_id, "_dt_list_users", TRUE);
			$count = count($meta, COUNT_RECURSIVE);
			$usertotal = get_user_option("user_list_count", $user_id );
			if ($total == true ) echo $usertotal;
			if($total == false) echo $count;
		}
		die();
	}
	add_action('wp_ajax_nopriv_dt_process_list', 'dt_process_list');
	add_action('wp_ajax_dt_process_list', 'dt_process_list');
}

// The button(1)
if(!function_exists('dt_list_button')){
	function dt_list_button($post_id){
        if(DOO_THEME_USER_MOD == true) {
    		$nonce = wp_create_nonce('dt-list-noce');
    		$class = ( dt_already_listed( $post_id ) ) ? ' in-list' : false;
    		$tooltip = ( dt_already_listed( $post_id ) ) ? __d('Remove of favorites') : __d('Add to favorites');
    		$tooltiphtml = ( !wp_is_mobile() ) ? '<div class="tooltiptext tooltip-right">'.$tooltip.'</div>' : null;
    		$meta = get_post_meta( $post_id, "_dt_list_users", TRUE);
    		$count =  ($meta != null) ? count($meta, COUNT_RECURSIVE) : 0;
    		$process = (is_user_logged_in()) ? 'process_list' : 'clicklogin';

    		echo '<a class="'.$process.$class.' tooltip" data-post-id="'. $post_id.'" data-nonce="'.$nonce.'"><i class="ucico icon-thumb_up"></i> <span class="list-count-'.$post_id.'">'.$count.'</span>'.$tooltiphtml.'</a>';
        }
    }
}


// Verify POST
if(!function_exists('dt_already_listed')){
	function dt_already_listed($post_id){
		$post_users = null;
		$user_id	= null;
		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$post_meta_users = get_post_meta( $post_id, "_dt_list_users");
			if ( count( $post_meta_users ) != 0 ) {
				$post_users = $post_meta_users[0];
			}
		}
		if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
			return true;
		} else {
			return false;
		}
	}
}

// Get user listed
if(!function_exists('dt_get_user_lists')){
	function dt_get_user_lists($user_id, $post_id){
		$post_users = '';
		$post_meta_users = get_post_meta( $post_id, "_dt_list_users");
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}
		if ( !in_array( $user_id, $post_users ) ) {
			$post_users['u' . $user_id . 'r'] = $user_id;
		}
		return $post_users;
	}
}




/* User views
========================================================
*/
if(!function_exists('dt_process_views')){
	function dt_process_views(){
		$post_users = null;
		$nonce		= isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
		$total		= isset( $_REQUEST['total'] ) ? true : false;
		if( isset( $_REQUEST['post_id'] ) AND wp_verify_nonce( $nonce, 'dt-view-noce') AND is_user_logged_in() ) {
			$post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : null;
			if ( !dt_already_viewed( $post_id ) ) {
				$user_id	= get_current_user_id();
				$post_users = dt_get_user_views( $user_id, $post_id );

				$user_view_count = get_user_option("user_view_count", $user_id );
				$user_view_count =  ( isset( $user_view_count ) && is_numeric( $user_view_count ) ) ? $user_view_count : 0;
				update_user_option( $user_id, "user_view_count", ++$user_view_count );

				if ( $post_users ) {
					update_post_meta( $post_id, "_dt_views_users", $post_users );
				}
			} else {
				$user_id = get_current_user_id();
				$post_users = dt_get_user_views( $user_id, $post_id );

				$user_view_count = get_user_option("user_view_count", $user_id );
				$user_view_count =  ( isset( $user_view_count ) && is_numeric( $user_view_count ) ) ? $user_view_count : 0;
				if ( $user_view_count > 0 ) {
					update_user_option( $user_id, 'user_view_count', --$user_view_count );
				}

				if ( $post_users ) {
					$uid_key = array_search( $user_id, $post_users );
					unset( $post_users[$uid_key] );
					update_post_meta( $post_id, "_dt_views_users", $post_users );
				}
			}
			$meta = get_post_meta( $post_id, "_dt_views_users", TRUE);
			$count = count($meta, COUNT_RECURSIVE);
			$usertotal = get_user_option("user_view_count", $user_id );
			if ($total == true ) echo $usertotal;
			if ($total == false ) echo $count;
		}
		die();
	}
	add_action('wp_ajax_nopriv_dt_process_views', 'dt_process_views');
	add_action('wp_ajax_dt_process_views', 'dt_process_views');
}

// The button(1)
if(!function_exists('dt_views_button')){
	function dt_views_button($post_id){
        if( DOO_THEME_USER_MOD == true ) {
    		$nonce = wp_create_nonce('dt-view-noce');
    		$class = ( dt_already_viewed( $post_id ) ) ? ' in-views' : false;
    		$tooltip = ( dt_already_viewed( $post_id ) ) ? __d('Remove') : __d('I saw it');
    		$tooltiphtml = ( !wp_is_mobile() ) ? '<div class="tooltiptext tooltip-right">'.$tooltip.'</div>' : null;
    		$meta = get_post_meta( $post_id, "_dt_views_users", TRUE);
    		$count =  ($meta != null) ? count($meta, COUNT_RECURSIVE) : 0;
    		$process = (is_user_logged_in()) ? 'process_views' : 'clicklogin';
    		echo '<a class="'.$process.$class.' tooltip" data-post-id="'. $post_id.'" data-nonce="'.$nonce.'"><i class="uvcico icon-eye"></i> <span class="views-count-'.$post_id.'">'.$count.'</span>'.$tooltiphtml.'</a>';
    	}
    }
}


// Verify POST
if(!function_exists('dt_already_viewed')){
	function dt_already_viewed($post_id){
		$post_users = null;
		$user_id	= null;
		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$post_meta_users = get_post_meta( $post_id, "_dt_views_users");
			if ( count( $post_meta_users ) != 0 ) {
				$post_users = $post_meta_users[0];
			}
		}
		if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
			return true;
		} else {
			return false;
		}
	}
}

// Get user listed
if(!function_exists('dt_get_user_views')){
	function dt_get_user_views($user_id, $post_id){
		$post_users = '';
		$post_meta_users = get_post_meta( $post_id, "_dt_views_users");
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
		if ( !is_array( $post_users ) ) {
			$post_users = array();
		}
		if ( !in_array( $user_id, $post_users ) ) {
			$post_users['u'.$user_id.'r'] = $user_id;
		}
		return $post_users;
	}
}
