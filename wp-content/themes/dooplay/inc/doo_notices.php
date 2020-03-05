<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.1.8
*
*/

class DooNotices{

    public function __construct(){
        if(is_admin()){
            $dbmovies = get_option('_dbmovies_settings');
            $doopages = get_option('dooplay_pages');
            $database = get_option('dooplay_database');
            $updateml = get_option('dooplay_update_linksmodule');
            $licesenk = get_option('dooplay_license_key');
            $licenses = get_option('dooplay_license_key_status');
            $currpage = doo_isset($_GET,'page');

            if(version_compare(phpversion(), DOO_PHP_REQUIRE, '<')){
                add_action('admin_notices',array($this,'php_require'));
            }

            if($licenses !== 'valid'){
                add_action('admin_notices', array($this,'activate_license'));
            }elseif(!$doopages && $currpage != 'dooplay-database'){
                add_action('admin_notices',array($this,'generate_pages'));
            }elseif(empty(doo_isset($dbmovies,'dbmovies')) && $currpage != 'dbmvs-settings'){
                add_action('admin_notices',array($this,'activate_dbmovies'));
            }elseif(!$updateml && $currpage != 'dooplay-database'){
                add_action('admin_notices', array($this,'update_linksmodule'));
            }elseif($updateml && $database !== DOO_VERSION_DB && $currpage != 'dooplay-database'){
                add_action('admin_notices', array($this,'update_database'));
            }
        }
    }

    public function php_require(){
        $out  = '<div class="notice notice-warning is-dismissible"><p>';
        $out .= sprintf( __d('DooPlay requires <strong>PHP %1$s+</strong>. Please ask your webhost to upgrade to at least PHP %1$s. Recommended: <strong>PHP 7.2</strong>'), DOO_PHP_REQUIRE);
        $out .= '</p></div>';
        echo $out;
    }

    public function activate_license(){
        $out  = '<div class="notice notice-info is-dismissible"><p>';
    	$out .= '<span class="dashicons dashicons-warning" style="color: #00a0d2"></span> ';
        $out .= __d('Invalid license, it is possible that some of the options may not work correctly'). ', '.'<a href="'. admin_url('themes.php?page=dooplay-license').'"><strong>'. __d('here'). '</strong></a>';
        $out .= '</p></div>';
        echo $out;
    }

    public function update_database(){
        $out = '<div class="notice notice-info is-dismissible"><p id="cfg_dts">';
    	$out .= '<span class="dashicons dashicons-warning" style="color: #00a0d2"></span> ';
        $out .= __d('Dooplay requires you to update the database'). ' <a href="'.admin_url('admin-ajax.php?action=dooplaycleanerdatabase').'"><strong>'. __d('click here to update') .'</strong></a>';;
        $out .= '</p></div>';
        echo $out;
    }

    public function activate_dbmovies(){
        $out = '<div class="notice notice-info is-dismissible activate_dbmovies_true"><p id="ac_dbm_not">';
    	$out .= '<span class="dashicons dashicons-warning" style="color: #00a0d2"></span> ';
    	$out .= __d('Add API key for Dbmovies'). ' <a href="' .admin_url('admin.php?page=dbmvs-settings').'"><strong>'.__d('Click here').'</strong></a>';
        $out .= '</p></div>';
        echo $out;
    }

    public function generate_pages(){
        $out = '<div class="notice notice-info is-dismissible activate_dbmovies_true"><p id="ac_dbm_not">';
    	$out .= '<span class="dashicons dashicons-warning" style="color: #00a0d2"></span> ';
    	$out .= __d('Generate all the required pages'). ' <a href="'.admin_url('admin-ajax.php?action=dooplaygeneratepage').'"><strong>'. __d('click here') .'</strong></a>';
        $out .= '</p></div>';
        echo $out;
    }

    public function update_linksmodule(){
        $out = '<div class="notice notice-info is-dismissible activate_dbmovies_true"><p id="ac_dbm_not">';
    	$out .= '<span class="dashicons dashicons-warning" style="color: #00a0d2"></span> ';
    	$out .= __d('This version requires you to update the links module'). ' <a href="'.admin_url('tools.php?page=dooplay-database').'"><strong>'. __d('click here') .'</strong></a>';
        $out .= '</p></div>';
        echo $out;
    }

    public function __destruct(){
        return false;
    }

}

new DooNotices;


// End notificator..
