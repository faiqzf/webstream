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

get_header();
global $wp_query, $wpdb;
$user_data = $wp_query->get_queried_object();
$user_id = $user_data->ID;
$actual_id  = get_current_user_id();
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name	= get_user_meta($user_id, 'last_name', true);
$about		= get_user_meta($user_id, 'description', true);
$list		= get_user_meta($user_id, $wpdb->prefix .'user_list_count', true);
$view		= get_user_meta($user_id, $wpdb->prefix .'user_view_count', true);
$display_name = get_user_meta($user_id, 'display_name', true);
$email = $user_data->user_email;
?>
<div class="page_user">
	<div id="message"></div>
	<div id="edit_link"></div>
	<header class="user">
		<div class="box">
			<div class="gravatar"><?php echo get_avatar( $email, 90 ); ?></div>
			<div class="contenido">
				<div class="name">
					<h2 id="h2user"><?php echo $display_name; ?></h2>
					<p id="puser"><?php if($about) { echo $about; } else { echo __d("You haven't written anything about yourself"); } ?></p>
				</div>
				<div class="info">
					<span>
						<b class="num"><?php echo ( $list >= 1 ) ? $list : '0'; ?></b>
						<i class="text"><?php _d('Favorites'); ?></i>
					</span>
					<span>
						<b class="num"><?php echo ( $view >= 1 ) ? $view : '0'; ?></b>
						<i class="text"><?php _d('Views'); ?></i>
					</span>
					<span>
						<b class="num"><?php echo count_user_posts( $user_id, 'dt_links'); ?></b>
						<i class="text"><?php _d('Links'); ?></i>
					</span>
					<span>
						<b class="num"><?php $args = array('user_id' => $user_id,'count' => true); $comments = get_comments($args); echo $comments ?></b>
						<i class="text"><?php _d('Comments'); ?></i>
					</span>
				</div>
			</div>
		</div>
	</header>
	<nav class="user">
		<ul class="idTabs">
			<li><a href="#favorites"><?php _d('Favorites'); ?></a></li>
			<li><a href="#links"><?php _d( 'Links' ); ?></a></li>
			<?php if (is_user_logged_in()): if($user_id == $actual_id) { ?>
			<li class="rrt"><a href="<?php echo doo_compose_pagelink('pageaccount'); ?>"><?php _d('Edit Profile'); ?></a></li>
			<?php } endif; ?>
		</ul>
	</nav>
	<div class="content">
		<div class="upge" id="favorites">
			<div id="items_movies">
				<?php doo_collections_items($user_id, array('movies','tvshows'), '18', '_dt_list_users', 'profile'); ?>
			</div>
			<?php if( $list >= 19 ) { ?>
			<div class="paged">
				<a class="load_more load_list_favorites" data-page="1" data-user="<?php echo $user_id; ?>" data-type="_dt_list_users" data-template="profile"><?php _d('Load more'); ?></a>
			</div>
			<?php } ?>
		</div>
		<div class="upge" id="links">
			<div id="mylinks" class="fix-table">
				<table class="account_links">
					<thead>
						<tr>
							<th><?php _d('Type'); ?></th>
							<th><?php _d('Server'); ?></th>
							<th><?php _d('Title'); ?></th>
							<th class="views"><?php _d('Views'); ?></th>
							<th class="views"><?php _d('Quality'); ?></th>
							<th class="views"><?php _d('Language'); ?></th>
							<th class="views"><?php _d('Added'); ?></th>
						</tr>
					</thead>
					<tbody id="item_links">
						<?php doo_links_profile($user_id, 10 ); ?>
					</tbody>
				</table>
				<div class="paged">
					<a class="load_more load_list_links_profile" data-page="1" data-user="<?php echo $user_id; ?>"><?php _d('Load more'); ?></a>
				</div>
			</div>
		</div>

	</div>
</div>
<?php get_footer(); ?>
