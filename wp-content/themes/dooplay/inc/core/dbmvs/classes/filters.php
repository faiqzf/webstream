<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/


class DDbmoviesFilters extends DDbmoviesHelpers{

    /**
     * @since 2.2.6
     * @version 1.0
     */
    protected $tmdbkey = '';
    protected $dbmvkey = '';
    protected $apilang = '';


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
        // Properties
        $this->apilang = $this->get_option('language','en-US');
        $this->tmdbkey = $this->get_option('themoviedb',DBMOVIES_TMDBKEY);
        $this->dbmvkey = $this->get_option('dbmovies');
        // Actions
        add_action('wp_ajax_dbmovies_app_upimdb', array(&$this,'upimdb'));
        add_action('wp_ajax_dbmovies_app_filter', array(&$this,'filter'));
        add_action('wp_ajax_dbmovies_app_search', array(&$this,'search'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function upimdb(){
        // Start timer
        $mtime = microtime(TRUE);
        // Perpage
        $ppage = 1;
        // Data
        $paged = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $total = wp_count_posts('movies')->publish;
        $pages = ceil($total/$ppage);
        $prgss = number_format(($paged/$pages*100),2);
        $query = self::GetIMDbID($paged,$ppage);
        // Compose Data
        if($query){
            $response = array(
                'response' => true,
                'prgss' => $prgss,
                'pages' => $pages,
                'paged' => $paged,
                'total' => $total,
                'mtime' => $this->TimeExe($mtime),
                'imdb'  => $query
            );
        } else {
            $response = array(
                'response' => false,
                'message' => __d('Process Completed')
            );
        }
        // Header
        header('Content-type: application/json');
        // The Response
        echo $this->ResponseJson($response);
        // Kill action
        wp_die();
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function filter(){
        // Start timer
        $mtime = microtime(TRUE);
        // Post Data
        $type = $this->Disset($_REQUEST,'type');
        $page = $this->Disset($_REQUEST,'page');
        $year = $this->Disset($_REQUEST,'year');
        $popu = $this->Disset($_REQUEST,'popu');
        $genr = $this->Disset($_REQUEST,'genres-'.$type);
        // Compose TMDb parameters
        $tmdbpar['api_key']  = $this->tmdbkey;
        $tmdbpar['language'] = $this->apilang;
        if($popu) $tmdbpar['sort_by'] = $popu;
        if($page) $tmdbpar['page'] = $page;
        if($year) $tmdbpar[$this->datetypeapi($type)] = $year;
        if($genr) $tmdbpar['with_genres'] = $genr;
        // Get Remote Data
        $json_tmdb = $this->RemoteJson($tmdbpar, DBMOVIES_TMDBAPI.'/discover/'.$type);
        // Verify Status codes
        if(!$this->Disset($json_tmdb,'status_code')){
            // Verify Errors
            if(!$this->Disset($json_tmdb,'errors')){
                // Compose TMDb Data
                $tmdb_page    = $this->Disset($json_tmdb,'page');
                $tmdb_pages   = $this->Disset($json_tmdb,'total_pages');
                $tmdb_results = $this->Disset($json_tmdb,'results');
                $tmdb_total   = $this->Disset($json_tmdb,'total_results');

                // Compose Response
                $response = array(
                    'response' => true,
                    'type'     => 'Filter',
                    'year'     => $year,
                    'page'     => $tmdb_page,
                    'pages'    => $tmdb_pages,
                    'items'    => $tmdb_page*20,
                    'total'    => $tmdb_total,
                    'results'  => $this->results($tmdb_results,$type),
                    'mtime'    => $this->TimeExe($mtime)
                );
            } else{
                $response = array(
                    'response' => false,
                    'message' => $json_tmdb['errors'][0]
                );
            }
        } else{
            $response = array(
                'response' => false,
                'message' => $this->Disset($json_tmdb,'status_message')
            );
        }
        // Header
        header('Content-type: application/json');
        // The Response
        echo $this->ResponseJson($response);
        // Kill action
        wp_die();
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function search(){
        // Start timer
        $mtime = microtime(TRUE);
        // Post Data
        $type = $this->Disset($_REQUEST,'searchtype');
        $page = $this->Disset($_REQUEST,'searchpage');
        $term = $this->Disset($_REQUEST,'searchterm');
        // Compose API Parameters
        $tmdbpar['api_key']  = $this->tmdbkey;
        $tmdbpar['language'] = $this->apilang;
        if($term) $tmdbpar['query'] = $term;
        if($page) $tmdbpar['page']  = $page;
        // Get Remote Data
        $json_tmdb = $this->RemoteJson($tmdbpar,DBMOVIES_TMDBAPI.'/search/'.$type);
        // Verify Status codes
        if(!$this->Disset($json_tmdb,'status_code')){
            // Verify Errors
            if(!$this->Disset($json_tmdb,'errors')){
                // Compose TMDb Data
                $tmdb_page    = $this->Disset($json_tmdb,'page');
                $tmdb_pages   = $this->Disset($json_tmdb,'total_pages');
                $tmdb_results = $this->Disset($json_tmdb,'results');
                $tmdb_total   = $this->Disset($json_tmdb,'total_results');

                // Compose Response
                $response = array(
                    'response' => true,
                    'type'     => 'Search',
                    'page'     => $tmdb_page,
                    'pages'    => $tmdb_pages,
                    'items'    => $tmdb_page*20,
                    'total'    => $tmdb_total,
                    'results'  => $this->results($tmdb_results,$type),
                    'mtime'    => $this->TimeExe($mtime)
                );
            } else{
                $response = array(
                    'response' => false,
                    'message' => $json_tmdb['errors'][0]
                );
            }
        } else{
            $response = array(
                'response' => false,
                'message' => $this->Disset($json_tmdb,'status_message')
            );
        }
        // Header
        header('Content-type: application/json');
        // The Response
        echo $this->ResponseJson($response);
        // Kill action
        wp_die();
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function results($results = array(), $type =''){
        if(is_array($results) && isset($type)){
            $data = array();
            foreach($results as $tmdb){
                $idtmdb = $this->Disset($tmdb,'id');
                $data[] = array(
                    'tp' => $type,
                    'id' => $idtmdb,
                    'ti' => $this->Disset($tmdb,$this->titletype($type)),
                    'im' => $tmdb['poster_path'] ? 'https://image.tmdb.org/t/p/w185'.$tmdb['poster_path'] : DBMOVIES_URI.'/assets/no_img_185.png',
                    'dt' => $tmdb[$this->datetype($type)] ? doo_date_compose($tmdb[$this->datetype($type)], false) : __d('No date'),
                    'db' => $this->verificator($idtmdb, $type) ? 'existent' : 'non-existent'
                );
            }
            return apply_filters('dbmovies-filters-results', $data, $type);
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function verificator($idtmdb = '', $type = ''){
        if($type == 'movie'){
            return $this->VeryTMDb('idtmdb', $idtmdb,'movies');
        }elseif($type == 'tv'){
            return $this->VeryTMDb('ids', $idtmdb, 'tvshows');
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function datetype($type){
        if($type == 'movie'){
            return 'release_date';
        }elseif($type == 'tv'){
            return 'first_air_date';
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function datetypeapi($type){
        if($type == 'movie'){
            return 'primary_release_year';
        }elseif($type == 'tv'){
            return 'first_air_date_year';
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function titletype($type){
        if($type == 'movie'){
            return 'title';
        }elseif($type == 'tv'){
            return 'original_name';
        }
    }
}

new DDbmoviesFilters;
