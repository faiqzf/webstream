<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/

class DDbmoviesAdminPage extends DDbmoviesHelpers{

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
        add_action('admin_menu',array(&$this,'DbmvMenu'));
        add_action('after_setup_theme',array(&$this,'Setup'));
    }


    /**
     * @since 2.2.6
     * @version 3.0
     */
    public function Setup(){
        // Dbmovies Options
        $settings = get_option(DBMOVIES_OPTIONS);
        $imdbdata = get_option(DBMOVIES_OPTIMDB);

        // Set Settings default
        if(!$settings){
            $data = array(
                'dbmovies'          => '',
                'themoviedb'        => DBMOVIES_TMDBKEY,
                'language'          => 'en-US',
                'upload'            => 1,
                'genres'            => 1,
                'release'           => 1,
                'autoscroll'        => 1,
                'nospostimp'        => 0,
                'repeated'          => 0,
                'safemode'          => 0,
                'autoscrollresults' => '200',
                'delaytime'         => '1000',
                'titlemovies'       => '{name}',
                'titletvshows'      => '{name}',
                'titleseasons'      => __d('{name}: Season {season}'),
                'titlepisodes'      => '{name}: {season}x{episode}',
                'request-email'     => '',
                'requestsunk'       => 0,
                'reqauto-adm'       => 1,
                'reqauto-edi'       => 1,
                'reqauto-aut'       => 1,
                'reqauto-con'       => 1,
                'reqauto-sub'       => 1,
                'reqauto-unk'       => 0,
                'phptimelimit'      => '300',
                'phpmemorylimit'    => '256',
                'orderseasons'      => 'ASC',
                'orderepisodes'     => 'ASC',
                'pstatusmovies'     => 'publish',
                'pstatustvshows'    => 'publish',
                'pstatusseasons'    => 'publish',
                'pstatusepisodes'   => 'publish',
                'gutenberg-movies'  => 1,
                'gutenberg-tvshows' => 1,
                'gutenberg-seasons' => 1,
                'gutenberg-episode' => 1,
                'gutenberg-links'   => 1,
            );
            // Update Option
            update_option(DBMOVIES_OPTIONS, $data);
        }

        // Set IMDb Data
        if(!$imdbdata){
            $data = array(
                'time' => time(),
                'page' => '1'
            );
            // Update Option
            update_option(DBMOVIES_OPTIMDB, $data);
        }
    }


    /**
     * @since 2.2.6
     * @version 3.0
     */
    public function DbmvMenu(){
        add_menu_page( __d('Dbmovies'), __d('Dbmovies'), 'manage_options', 'dbmvs', array(&$this,'DbmvApp'), 'dashicons-upload');
        add_submenu_page('dbmvs', __d('Dbmovies - Settings'), __d('Settings').$this->PendingNotice(), 'manage_options', 'dbmvs-settings',array(&$this,'DbmvSettings'));
    }


    /**
     * @since 2.2.6
     * @version 3.0
     */
    public function DbmvApp(){
        require_once(DBMOVIES_DIR.'/tpl/admin_app.php');
    }


    /**
     * @since 2.2.6
     * @version 3.0
     */
    public function DbmvSettings(){
        require_once(DBMOVIES_DIR.'/tpl/admin_settings.php');
    }


    /**
     * @since 2.2.6
     * @version 3.0
     */
    public function PendingNotice(){
        if(empty($this->get_option('dbmovies')) || empty($this->get_option('themoviedb'))){
            return "<span class='awaiting-mod' style='margin-left:10px'><span class='pending-count'>1</span></span>";
        }
    }

}

new DDbmoviesAdminPage;
