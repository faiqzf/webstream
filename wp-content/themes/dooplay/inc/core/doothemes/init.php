<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.2.6
*
*/


/* Dbmovies Plugin
========================================================
*/
require_once(DOO_DIR.'/inc/core/dbmvs/init.php');

/* Doothemes class
========================================================
*/
if(!class_exists('Doothemes')){
	get_template_part('inc/core/doothemes/class');
}

/* Theme Updater
========================================================
*/
new Doothemes(

	// Main data
	$config = array(
		'item_name'		 => DOO_THEME,
		'theme_slug'	 => DOO_THEME_SLUG,
		'version'		 => DOO_VERSION,
		'author'		 => DOO_COM,
		'download_id'	 => DOO_ITEM_ID,
        'remote_api_url' => 'https://doothemes.com',
		'renew_url'		 => 'https://doothemes.com/items/dooplay/'
	),

	// Texts
	$strings = array(
    	'theme-license'				=> DOO_THEME .' '. __d('license'),
    	'enter-key'					=> __d('Enter your theme license key.'),
    	'license-key'				=> __d('License Key'),
    	'license-action'			=> __d('License Action'),
    	'deactivate-license'		=> __d('Deactivate License'),
    	'activate-license'			=> __d('Activate License'),
    	'status-unknown'			=> __d('License status is unknown.'),
    	'renew'						=> __d('Renew?'),
    	'unlimited'					=> __d('unlimited'),
    	'license-key-is-active'		=> __d('License key is active'),
    	'expires%s'					=> __d('since %s.'),
    	'%1$s/%2$-sites'			=> __d('You have %1$s / %2$s sites activated.'),
    	'license-key-expired-%s'	=> __d('License key expired %s.'),
    	'license-key-expired'		=> __d('License key has expired.'),
    	'license-keys-do-not-match' => __d('License keys do not match.'),
    	'license-is-inactive'		=> __d('License is inactive.'),
    	'license-key-is-disabled'	=> __d('License key is disabled.'),
    	'site-is-inactive'			=> __d('Please activate a valid license.'),
    	'license-status-unknown'	=> __d('License status is unknown.'),
    	'update-notice'				=> __d('Updating this theme will lose any customizations you have made. \'Cancel\' to stop, \'OK\' to update.'),
    	'update-available'			=> __d('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.')
	)
);
