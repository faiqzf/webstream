<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/


class DDbmoviesEnqueues extends DDbmoviesHelpers{

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
        add_action('admin_enqueue_scripts', array(&$this,'Enqueues'));
    }


    /**
     * @since 2.2.6
     * @version 3.0
     */
    public function Enqueues(){
        $parameters = array(
            'dapikey' => $this->get_option('dbmovies'),
            'tapikey' => $this->get_option('themoviedb',DBMOVIES_TMDBKEY),
            'apilang' => $this->get_option('language','en-US'),
            'extimer' => $this->get_option('delaytime','500'),
            'rscroll' => $this->get_option('autoscrollresults','200'),
            'inscrll' => $this->get_option('autoscroll'),
            'safemod' => $this->get_option('safemode'),
            'titmovi' => $this->get_option('titlemovies'),
            'tittvsh' => $this->get_option('titletvshows'),
            'titseas' => $this->get_option('titleseasons'),
            'titepis' => $this->get_option('titlepisodes'),
            'noposti' => $this->get_option('nospostimp'),
            'pupload' => $this->get_option('upload'),
            'csectin' => $this->Disset($_GET,'section'),
            'gerepis' => $this->Disset($_GET,'generate_episodes'),
            'ajaxurl' => admin_url('admin-ajax.php','relative'),
            'dapiurl' => esc_url(DBMOVIES_DBMVAPI),
            'tapiurl' => esc_url(DBMOVIES_TMDBAPI),
			'apisite' => preg_replace('#^https?://#', '', rtrim(get_option('siteurl'),'/')),
            'prsseng' => __d('Processing..'),
            'dbmverr' => __d('Our services are out of line, please try again later'),
            'tmdberr' => __d('The title does not exist or resources are not available at this time'),
            'misskey' => __d('You have not added an API key for Dbmovies'),
            'loading' => __d('Loading..'),
            'loadmor' => __d('Load More'),
            'import'  => __d('Import'),
            'save'    => __d('Save'),
            'savech'  => __d('Save Changes'),
            'saving'  => __d('Saving..'),
            'uerror'  => __d('Unknown error'),
            'nerror'  => __d('Connection error'),
            'aerror'  => __d('Api key invalid or blocked'),
            'nocrdt'  => __d('There are not enough credits to continue'),
            'complt'  => __d('Process Completed'),
            'welcom'  => __d('Service started')
        );

        // All Scripts
        wp_enqueue_style('dbmovies-app', DBMOVIES_DBMVAPI.'/assets/dbmovies.min.css?query=' .mt_rand(1,1000), array(), DBMOVIES_VERSION);
        wp_enqueue_script('dbmovies-app', DBMOVIES_DBMVAPI.'/assets/dbmovies.min.js', array('jquery'), DBMOVIES_VERSION);
        wp_localize_script('dbmovies-app', 'dbmovies', $parameters);
    }

}

new DDbmoviesEnqueues;
