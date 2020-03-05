<?php
/**
 *
 * Class: Dootheme_updater
 * @since 2.1.3
 *
 */

class Doothemes_updater {

	// Define in private
	private $remote_api_url;
	private $request_data;
	private $response_key;
	private $theme_slug;
	private $license_key;
	private $version;
	private $author;
	protected $strings = null;

	// Construct
	function __construct( $args = array(), $strings = array() ) {
		$args = wp_parse_args( $args, array(
			'remote_api_url'	=> 'https://doothemes.com',
			'request_data'		=> array(),
			'theme_slug'		=> get_template(),
			'item_name'			=> '',
			'license'			=> '',
			'version'			=> '',
			'author'			=> ''
		) );

		extract( $args );

		$this->license			= $license;
		$this->item_name		= $item_name;
		$this->version			= $version;
		$this->theme_slug		= sanitize_key( $theme_slug );
		$this->author			= $author;
		$this->remote_api_url	= $remote_api_url;
		$this->response_key		= $this->theme_slug . '-update-response';
		$this->strings			= $strings;

		add_filter('site_transient_update_themes', 			array( &$this, 'theme_update_transient') );
		add_filter('delete_site_transient_update_themes', 	array( &$this, 'delete_theme_update_transient') );
		add_action('load-update-core.php', 					array( &$this, 'delete_theme_update_transient') );
		add_action('load-themes.php', 						array( &$this, 'delete_theme_update_transient') );
	}

	// Theme Update Transient
	function theme_update_transient( $value ) {
		$update_data = $this->check_for_update();
		if ( $update_data ) {
			$value->response[ $this->theme_slug ] = $update_data;
		}
		return $value;
	}

	// Delete theme update transient
	function delete_theme_update_transient() {
		delete_transient( $this->response_key );
	}

	// Check for Update
	function check_for_update() {
		$update_data = get_transient( $this->response_key );
		if ( false === $update_data ) {

			$failed = false;

			$api_params = array(
				'edd_action' 	=> 'get_version',
				'license' 		=> $this->license,
				'name' 			=> $this->item_name,
				'slug' 			=> $this->theme_slug,
				'author'		=> $this->author
			);

			$response = wp_remote_post( $this->remote_api_url, array('timeout' => 15, 'body' => $api_params ) );
			if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
				$failed = true;
			}

			$update_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( ! is_object( $update_data ) ) {
				$failed = true;
			}

			if ( $failed ) {
				$data = new stdClass;
				$data->new_version = $this->version;
				set_transient( $this->response_key, $data, strtotime('+30 minutes') );
				return false;
			}

			if ( ! $failed ) {
				$update_data->sections = maybe_unserialize( $update_data->sections );
				set_transient( $this->response_key, $update_data, strtotime('+12 hours') );
			}
		}

		if ( version_compare( $this->version, $update_data->new_version, '>=') ) {
			return false;
		}

		return (array) $update_data;
	}
}
