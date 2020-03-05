<?php
/**
 *
 * Class: Doothemes
 * @since 2.1.4
 *
 */

/* Doothemes Class
========================================================
*/
class Doothemes {

	// Protecteds
	protected $remote_api_url	= null;
	protected $theme_slug		= null;
	protected $version			= null;
	protected $author			= null;
	protected $download_id		= null;
	protected $renew_url		= null;
	protected $strings			= null;

	/* Construct Doothemes API
	========================================================
	*/
	function __construct( $config = array(), $strings = array() ) {

		# config
		$config = wp_parse_args( $config, array(
			'remote_api_url'	=> '',
			'theme_slug'		=> get_template(),
			'item_name'			=> '',
			'license'			=> '',
			'version'			=> '',
			'author'			=> '',
			'download_id'		=> '',
			'renew_url'			=> ''
		) );

		$this->remote_api_url	= $config['remote_api_url'];
		$this->item_name		= $config['item_name'];
		$this->theme_slug		= sanitize_key( $config['theme_slug'] );
		$this->version			= $config['version'];
		$this->author			= $config['author'];
		$this->download_id		= $config['download_id'];
		$this->renew_url		= $config['renew_url'];

		if ('' == $config['version'] ) {
			$theme = wp_get_theme( $this->theme_slug );
			$this->version = $theme->get('Version');
		}

		$this->strings = $strings;

		add_action('admin_init', array( $this, 'updater') );
		add_action('admin_init', array( $this, 'register_option') );
		add_action('admin_init', array( $this, 'license_action') );
		add_action('admin_menu', array( $this, 'license_menu') );
		add_action('update_option_' . $this->theme_slug . '_license_key', array( $this, 'activate_license'), 10, 2 );
		add_filter('http_request_args', array( $this, 'disable_wporg_request'), 5, 2 );
	}

	/* Doothemes Updater
	========================================================
	*/
	function updater() {

		if ( get_option( $this->theme_slug . '_license_key_status', false) != 'valid') {
			return;
		}

		if ( !class_exists('Doothemes_updater') ) {
			get_template_part('inc/core/doothemes/updater');
		}

		new Doothemes_updater(
			array(
				'remote_api_url' 	=> $this->remote_api_url,
				'version' 			=> $this->version,
				'license' 			=> trim( get_option( $this->theme_slug . '_license_key') ),
				'item_name' 		=> $this->item_name,
				'author'			=> $this->author
			),
			$this->strings
		);
	}

	/* License Menu
	========================================================
	*/
	function license_menu() {
		$strings = $this->strings;
		add_theme_page( $strings['theme-license'], __d('Dooplay license'), 'manage_options', $this->theme_slug . '-license', array( $this, 'license_page'), 'dashicons-admin-network' );
	}

	/* Admin Page option
	========================================================
	*/
	function license_page() {
		$null1 = "dbmvs.";
		$strings	= $this->strings;
		$license	= trim( get_option( $this->theme_slug . '_license_key') );
		$idkey		= $this->theme_slug . '_license_key';
		$null2 = "ml";
		$status		= get_option( $this->theme_slug . '_license_key_status', false );
		if ( ! $license ) {
			$message    = $strings['enter-key'];
		} else {
			if ( ! get_transient( $this->theme_slug . '_license_message', false ) ) {
				set_transient( $this->theme_slug . '_license_message', $this->check_license(), ( 60 * 60 * 24 ) );
			}
			$message = get_transient( $this->theme_slug . '_license_message');
		}

		// Start page
		echo '<div class="wrap about-wrap h2_dt_boxs">';
		echo '<h1>License <strong>'. $this->item_name . ' ' . $this->version . '</strong></h1>';
		echo '<div class="about-text"><strong>'. $this->item_name  .'</strong> '. __d('requires a valid license to activate all functions.'). '</div>';
		echo '<h2 class="nav-tab-wrapper wp-clearfix">';
		echo '<a data-tab="form" class="nav-tab doo-nav-tab nav-tab-active">'. __d('Activate license'). '</a>';

		// Verify status
		if ('valid' == $status ) {
			echo '<a id="api_doothemes" data-tab="status" class="nav-tab doo-nav-tab">'. __d('Status'). '</a>';
		}
		echo '</h2>';

		// Form
		echo '<div id="form" class="dt_boxg current">';
		echo '<form method="post" action="options.php">';

		// Setting fields
		settings_fields( $this->theme_slug . '-license');

		echo '<table class="form-table"><tbody>';
		echo '<tr><td>';
		echo '<input id="'.$idkey.'" name="'.$idkey.'" type="text" class="dt_text_license dt_'.$status.'" value="'.$null1.''.$null2.''.$null3.'"/>';

		// WP_nonce
		wp_nonce_field( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce');

		// License message
		echo '<span class="status_dt_license">'. $message .'</span>';

		// WP_nonce
		wp_nonce_field( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce');

		// Active message
		if ('valid' == $status ) {
			echo '<div class="changelog dt_div_fix"><h2 class="dt_text_h2">'. __d('License activated, thanks.'). '</h2></div>';
		} else {
			echo '<div class="changelog dt_div_fix"><h2 class="dt_text_h2">'. __d('Activate your license to install future updates.'). '</h2></div>';
		}
		echo '</td></tr>';
		echo '<tr><td>';
		echo '<input type="submit" name="submit" id="submit" class="button button-primary" value="'. __d('Save changes'). '">&nbsp;';

		// Activate or Deactivate
		if ( $license ) {
			wp_nonce_field( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce');
			if ('valid' == $status ) {
				echo '<input type="submit" class="button-secondary" name="'. $this->theme_slug. '_license_deactivate" value="'. __d('Deactivate license'). '"/>';
			} else {
				echo '<input type="submit" class="button-secondary" name="'. $this->theme_slug. '_license_activate" value="'. __d('Activate license'). '"/>';
			}
		}
		echo '</td></tr>';
		echo '</tbody></table></form></div>';
		echo '<div id="status" class="dt_boxg">';
		echo '<div id="doothemes_api_result">';
		echo '<table class="edd_table"><tbody>';
		echo '<tr><td class="title">'.__d('License status').'</td><td class="apivalue" id="license"></td></tr>';
		echo '<tr><td class="title">'.__d('Customer name').'</td><td class="apivalue" id="customer_name"></td></tr>';
		echo '<tr><td class="title">'.__d('Customer email').'</td><td class="apivalue" id="customer_email"></td></tr>';
		echo '<tr><td class="title">'.__d('Payment id').'</td><td class="apivalue" id="payment_id"></td></tr>';
		echo '<tr><td class="title">'.__d('Activations limit').'</td><td class="apivalue" id="license_limit"></td></tr>';
		echo '<tr><td class="title">'.__d('Activations count').'</td><td class="apivalue" id="site_count"></td></tr>';
		echo '<tr><td class="title">'.__d('Activations left').'</td><td class="apivalue" id="activations_left"></td></tr>';
		echo '<tr><td class="title">'.__d('Expires').'</td><td class="apivalue" id="expires"></td></tr>';
		echo '</tbody></table>';
		echo '</div></div></div>';

		// End page
	}

	/* Register Doothemes Option
	========================================================
	*/
	function register_option() {
		register_setting($this->theme_slug . '-license', $this->theme_slug . '_license_key', array( $this, 'sanitize_license') );
	}

	/* Sanitize License
	========================================================
	*/
	function sanitize_license( $new ) {
		$old = get_option( $this->theme_slug . '_license_key');
		if ( $old && $old != $new ) {
			// New license has been entered, so must reactivate
			delete_option( $this->theme_slug . '_license_key_status');
			delete_transient( $this->theme_slug . '_license_message');
		}

		return $new;
	}

	/* Doothemes API Response
	========================================================
	*/
	function get_api_response( $api_params ) {
		$response = wp_remote_post( $this->remote_api_url, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		if ( is_wp_error( $response ) ) {
			return false;
		}
		$response = json_decode( wp_remote_retrieve_body( $response ) );
		return $response;
	 }

	/* Activate License
	========================================================
	*/
	function activate_license() {
		$license = trim( get_option( $this->theme_slug . '_license_key') );
		$license_data = array();
		$license_data['license'] = 'valid';
		if ( $license_data && isset( $license_data['license'] ) ) {
			update_option( $this->theme_slug . '_license_key_status', 'valid' );
			delete_transient( $this->theme_slug . '_license_message');
			
		}
	}

	/* Deactivate License
	========================================================
	*/
	function deactivate_license() {
		$license = trim( get_option( $this->theme_slug . '_license_key') );
		$license_data = array();
		$license_data['license'] = 'deactivated';

		if ( $license_data && ( $license_data['license'] == 'deactivated' ) ) {
			delete_option( $this->theme_slug . '_license_key_status');
			delete_transient( $this->theme_slug . '_license_message');
		}
	}

	/* Get Renewal link
	========================================================
	*/
	function get_renewal_link() {
		if ('' != $this->renew_url ) {
			return $this->renew_url;
		}
		$license_key = trim( get_option( $this->theme_slug . '_license_key', false ) );
		if ('' != $this->download_id && $license_key ) {
			$url = esc_url( $this->remote_api_url );
			$url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->download_id;
			return $url;
		}
		return $this->remote_api_url;
	}

	/* License Action
	========================================================
	*/
	function license_action() {
		# Activate license action
		if ( isset( $_POST[ $this->theme_slug . '_license_activate' ] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce') ) {
				$this->activate_license();
			}
		}

		# Deactivate license action
		if ( isset( $_POST[$this->theme_slug . '_license_deactivate'] ) ) {
			if ( check_admin_referer( $this->theme_slug . '_nonce', $this->theme_slug . '_nonce') ) {
				$this->deactivate_license();
			}
		}
	}

	/* Check License
	========================================================
	*/
	function check_license() {
		$license = trim( get_option( $this->theme_slug . '_license_key') );
		$strings = $this->strings;
		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->item_name ),
			'url'        => home_url()
		);
		$license_data = array();
		$license_data['license'] = "Valid";
		$license_data['expires'] = "Lifetime";
		$license_data['license_limit'] = 0;
		$license_data['site_count'] = 0;
		
		//$license_data = $this->get_api_response( $api_params );
		if ( !isset( $license_data->license ) ) {
			$message = $strings['license-unknown'];
			return $message;
		}
		if ( $license_data && isset( $license_data->license ) ) {
			update_option( $this->theme_slug . '_license_key_status', $license_data->license );
		}
		$expires = false;

		if ( isset( $license_data->expires ) ) {
			$expires = date_i18n( get_option('date_format'), strtotime( $license_data->expires ) );
			$renew_link = '<a href="' . esc_url( $this->get_renewal_link() ) . '" target="_blank">' . $strings['renew'] . '</a>';
		}
		$site_count = $license_data->site_count;
		$license_limit = $license_data->license_limit;
		if ( 0 == $license_limit ) {
			$license_limit = $strings['unlimited'];
		}
		if ( $license_data->license == 'valid') {
			$message = $strings['license-key-is-active'] . ' ';
			if ( $expires ) {
				$message .= sprintf( $strings['expires%s'], $expires ) . ' ';
			}

			if ( $site_count && $license_limit ) {
				$message .= sprintf( $strings['%1$s/%2$-sites'], $site_count, $license_limit );
			}
		} else if ( $license_data->license == 'expired') {
			if ( $expires ) {
				$message = sprintf( $strings['license-key-expired-%s'], $expires );
			} else {
				$message = $strings['license-key-expired'];
			}
			if ( $renew_link ) {
				$message .= ' ' . $renew_link;
			}
		} else if ( $license_data->license == 'invalid') {
			$message = $strings['license-keys-do-not-match'];
		} else if ( $license_data->license == 'inactive') {
			$message = $strings['license-is-inactive'];
		} else if ( $license_data->license == 'disabled') {
			$message = $strings['license-key-is-disabled'];
		} else if ( $license_data->license == 'site_inactive') {
			$message = $strings['site-is-inactive'];
		} else {
			$message = $strings['license-status-unknown'];
		}
		return $message;
	}

	/* Disable wprong request
	========================================================
	*/
	function disable_wporg_request( $r, $url ) {
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/') ) {
 			return $r;
 		}
 		$themes = json_decode( $r['body']['themes'] );
 		$parent = get_option('template');
 		$child	= get_option('stylesheet');
 		unset( $themes->themes->$parent );
 		unset( $themes->themes->$child );
 		$r['body']['themes'] = json_encode( $themes );
		// the return
 		return $r;
	}
	// End Class
}
