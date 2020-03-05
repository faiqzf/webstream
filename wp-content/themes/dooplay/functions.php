<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.3
*
*/

# Theme options
define('DOO_THEME_GLOSSARY',true);
define('DOO_THEME_DOWNLOAD_MOD',true);
define('DOO_THEME_PLAYER_MOD',true);
define('DOO_THEME_DBMOVIES',true);
define('DOO_THEME_USER_MOD',true);
define('DOO_THEME_VIEWS_COUNT',true);
define('DOO_THEME_RELATED',true);
define('DOO_THEME_SOCIAL_SHARE',true);
define('DOO_THEME_CACHE',true);
define('DOO_THEME_PLAYERSERNAM',true);
define('DOO_THEME_JSCOMPRESS',true);

# Repository data
define('DOO_COM','Doothemes');
define('DOO_VERSION','2.3.1');
define('DOO_VERSION_DB','2.8');
define('DOO_ITEM_ID','154');
define('DOO_PHP_REQUIRE','5.6');
define('DOO_THEME','Dooplay');
define('DOO_THEME_SLUG','dooplay');
define('DOO_SERVER','/');
define('DOO_GICO','https://s2.googleusercontent.com/s2/favicons?domain=');

# Define Logic data
define('DOO_TIME','M. d, Y');
define('DOO_MAIN_RATING','_starstruck_avg');
define('DOO_MAIN_VOTOS','_starstruck_total');

# Define template directory
define('DOO_URI',get_template_directory_uri());
define('DOO_DIR',get_template_directory());

# Translations
load_theme_textdomain('mtms', DOO_DIR.'/lang/');

# Codestar Framework
if(!function_exists('cs_framework_init') && !class_exists('CSFramework')) {
    get_template_part('inc/core/doothemes/codestar/cs-framework');
}

# Disabled Gutenberg Editor
add_filter('use_block_editor_for_post', '__return_false');

# Init
require get_parent_theme_file_path('/inc/doo_init.php');


/* Custom functions
========================================================
*/

	// Here your code
