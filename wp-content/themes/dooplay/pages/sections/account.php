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

global $current_user, $wp_roles, $wpdb;
wp_get_current_user();
$user_id	= get_current_user_id();
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name	= get_user_meta($user_id, 'last_name', true);
$about		= get_user_meta($user_id, 'description', true);
$list		= get_user_meta($user_id, $wpdb->prefix .'user_list_count', true);
$view		= get_user_meta($user_id, $wpdb->prefix .'user_view_count', true);
$display_name = $current_user->display_name;
get_header(); ?>
<div class="page_user">
	<div id="message"></div>
	<div id="edit_link"></div>
	<header class="user">
		<div class="box">
			<div class="gravatar"><a href="<?php echo get_author_posts_url( $user_id ); ?>"><?php doo_email_avatar_account(); ?></a></div>
			<div class="contenido">
				<div class="name">
					<h2 id="h2user"><?php echo $display_name; ?></h2>
					<p id="puser"><?php if($about) { echo $about; } else { echo __d("You haven't written anything about yourself"); } ?></p>
				</div>
				<div class="info">
					<span>
						<b class="num totalfavorites_user"><?php echo ( $list >= 1 ) ? $list : '0'; ?></b>
						<i class="text"><?php _d('Favorites'); ?></i>
					</span>
					<span>
						<b class="num totalviews_user"><?php echo ( $view >= 1 ) ? $view : '0'; ?></b>
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
			<li><a href="#favorites"><?php echo (!wp_is_mobile() ) ? __d('Favorites') : '<i class="icon-thumb_up"></i>'; ?></a></li>
			<li><a href="#views"><?php echo (!wp_is_mobile()) ? __d('Seen') : '<i class="icon-eye"></i>'; ?></a></li>
			<li><a href="#links"><?php _d('Links'); ?></a></li>
			<li><a href="#settings"><?php _d('Settings'); ?></a></li>
		</ul>
	</nav>
	<div class="content">

		<div class="upge" id="favorites">
			<h2><?php _d('My favorites'); ?></h2>
			<div id="items_movies">
				<?php doo_collections_items($user_id, array('movies','tvshows'), '18', '_dt_list_users', 'favorites'); ?>
			</div>
			<?php if( $list >= 19 ) { ?>
			<div class="paged">
				<a class="load_more load_list_favorites" data-page="1" data-user="<?php echo $user_id; ?>" data-type="_dt_list_users" data-template="favorites"><?php _d('Load more'); ?></a>
			</div>
			<?php } ?>
		</div>

		<div class="upge" id="views">
			<h2><?php _d('Marked as view'); ?></h2>
			<div id="items_views">
				<?php doo_collections_items($user_id, array('movies','tvshows'), '18', '_dt_views_users', 'views'); ?>
			</div>
			<?php if( $view >= 19 ) { ?>
			<div class="paged">
				<a class="load_more load_list_views" data-page="1" data-user="<?php echo $user_id; ?>" data-type="_dt_views_users" data-template="views"><?php _d('Load more'); ?></a>
			</div>
			<?php } ?>
		</div>


		<div class="upge" id="links">
			<h2>
				<strong id="text_link"><?php _d('Links Shared'); ?></strong>
				<?php if (current_user_can('administrator')) { $total = doo_total_count('dt_links', 'pending'); if($total >= 1) { ?>
				<span id="admin_pending_links" class="pending"><?php _d('pendings'); ?> <i><?php echo $total; ?></i></span>
				<span id="admin_back_links" class="pending" style="display:none"><?php _d('Go back'); ?></span>
				<?php } } ?>
			</h2>
			<div id="resultado_link"></div>
			<div id="mylinks" class="fix-table">
				<table class="account_links">
					<thead>
						<tr>
							<th><?php _d('Server'); ?></th>
							<th><?php _d('Title'); ?></th>
							<th class="views"><?php _d('Clicks'); ?></th>
                            <th class="views"><?php _d('Language'); ?></th>
                            <th class="views"><?php _d('Quality'); ?></th>
                            <th class="views"><?php _d('Added'); ?></th>
							<th class="status"><?php _d('Status'); ?></th>
							<th class="status"><?php _d('Manage'); ?></th>
						</tr>
					</thead>
					<tbody id="item_links">
						<?php doo_links_account($user_id, 10 ); ?>
					</tbody>
				</table>
				<div class="paged">
					<a class="load_more load_list_links" data-page="1" data-user="<?php echo $user_id; ?>"><?php _d('Load more'); ?></a>
				</div>
			</div>

			<?php if(current_user_can('administrator')) { ?>
			<div id="adminlinks" class="fix-table" style="display:none">
				<table class="account_links">
					<thead>
						<tr>
							<th><?php _d('Server'); ?></th>
							<th><?php _d('Title'); ?></th>
							<th><?php _d('User'); ?></th>
							<th class="views"><?php _d('Clicks'); ?></th>
							<th class="status"><?php _d('Status'); ?></th>
							<th class="status"><?php _d('Manage'); ?></th>
						</tr>
					</thead>
					<tbody id="item_links_admin">
						<?php doo_links_pending( 10 ); ?>
					</tbody>
				</table>
				<div class="paged">
					<a class="load_more load_admin_list_links" data-page="1"><?php _d('Load more'); ?></a>
				</div>
			</div>
			<?php } ?>

		</div>

		<div class="upge" id="settings">
			<div class="user_edit_control">
				<ul class="idTabs">
					<li><a href="#general"><?php _d('General'); ?></a></li>
					<li><a href="#about"><?php _d('About'); ?></a></li>
					<li><a href="#password"><?php _d('Password'); ?></a></li>
				</ul>
			</div>
			<form id="update_user_page" class="update_profile">
				<div id="general">
					<fieldset class="form-email">
						<label for="email"><?php _d('E-mail'); ?></label>
						<input type="text" id="email" name="email" value="<?php the_author_meta('user_email', $current_user->ID ); ?>" disabled />
					</fieldset>
					<fieldset class="from-first-name min fix">
						<label for="first-name"><?php _d('First name'); ?></label>
						<input type="text" id="first-name" name="first-name" value="<?php the_author_meta('first_name', $current_user->ID ); ?>" />
					</fieldset>
					<fieldset class="form-last-name min">
						<label for="last-name"><?php _d('Last name'); ?></label>
						<input type="text" id="last-name" name="last-name" value="<?php the_author_meta('last_name', $current_user->ID ); ?>" />
					</fieldset>
					<fieldset class="form-display_name">
						<label for="display_name"><?php _d('Display name publicly as'); ?></label>
						<select name="display_name" id="display_name"><br/>
						<?php if (!empty($current_user->first_name)): ?>
						<option <?php
						selected($display_name, $current_user->first_name); ?> value="<?php
						echo esc_attr($current_user->first_name); ?>"><?php
						echo esc_html($current_user->first_name); ?></option>
						<?php endif; ?>
						<option <?php selected($display_name, $current_user->user_nicename); ?> value="<?php
						echo esc_attr($current_user->user_nicename); ?>"><?php
						echo esc_html($current_user->user_nicename); ?></option>
						<?php if (!empty($current_user->last_name)): ?>
						<option <?php selected($display_name, $current_user->last_name); ?> value="<?php
						echo esc_attr($current_user->last_name); ?>"><?php
						echo esc_html($current_user->last_name); ?></option>
						<?php endif; ?>
						<?php if (!empty($current_user->first_name) && !empty($current_user->last_name)): ?>
						<option <?php selected($display_name, $current_user->first_name . ' ' . $current_user->last_name); ?> value="<?php
						echo esc_attr($current_user->first_name . ' ' . $current_user->last_name); ?>"><?php
						echo esc_html($current_user->first_name . ' ' . $current_user->last_name); ?></option>
						<option <?php selected($display_name, $current_user->last_name . ' ' . $current_user->first_name); ?> value="<?php
						echo esc_attr($current_user->last_name . ' ' . $current_user->first_name); ?>"><?php
						echo esc_html($current_user->last_name . ' ' . $current_user->first_name); ?></option>
						<?php endif; ?>
						</select>
					</fieldset>
					<fieldset class="form-url">
						<label for="url"><?php _d('Website'); ?></label>
						<input type="text" id="url" name="url" value="<?php the_author_meta('user_url', $current_user->ID ); ?>" />
					</fieldset>
					<fieldset class="form-url-twitter">
						<label for="facebook"><?php _d('Facebook url'); ?></label>
						<input type="text" id="facebook" name="facebook" value="<?php the_author_meta('dt_facebook', $current_user->ID ); ?>" />
					</fieldset>
					<fieldset class="form-url-facebook">
						<label for="twitter"><?php _d('Twitter url'); ?></label>
						<input type="text" id="twitter" name="twitter" value="<?php the_author_meta('dt_twitter', $current_user->ID ); ?>" />
					</fieldset>
					<fieldset class="form-url-gplus">
						<label for="gplus"><?php _d('Google+ url'); ?></label>
						<input type="text" id="gplus" name="gplus" value="<?php the_author_meta('dt_gplus', $current_user->ID ); ?>" />
					</fieldset>
				</div>
				<div id="about">
					<fieldset class="form-description">
						<label for="description"><?php _d('Description'); ?></label>
						<textarea id="description" name="description" rows="3" cols=""><?php the_author_meta('description', $current_user->ID ); ?></textarea>
					</fieldset>
				</div>
				<div id="password">
					<fieldset class="form-pass1 min fix">
						<label for="pass1"><?php _d('New password *'); ?></label>
						<input type="password" id="pass1" name="pass1" />
					</fieldset>

					<fieldset class="form-pass2 min">
						<label for="pass2"><?php _d('Repeat password *'); ?></label>
						<input type="password" id="pass2" name="pass2" />
					</fieldset>
				</div>
				<fieldset class="form-submit">
					<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _d('Update account'); ?>" />
					<?php wp_nonce_field('update-user','update-user-nonce')?>
				</fieldset>
			</form>
			<script type='text/javascript'>
				jQuery(document).ready(function($) {
					$('#update_user_page').submit(function(){
						$('#message').html('<div class="sms"><div class="updating"><i class="icons-spinner9 loading"></i> '+ dtAjax.updating + '</div></div>');
						$.ajax({
							type:'POST',
							url:dtAjax.url + '?action=dt_update_user',
							data:$(this).serialize()
						})
						.done(function(data){
							$('#message').html('<div class="sms">' + data + '</div>');
						});
						return false;
					});
					$('#description').bind('change', function(){
						$('#puser').text($(this).val());
					});
					$('#display_name').bind('change', function(){
						$('#h2user').text($(this).val());
					});
				});
			</script>
		</div>

	</div>
</div>
<?php get_footer(); ?>
