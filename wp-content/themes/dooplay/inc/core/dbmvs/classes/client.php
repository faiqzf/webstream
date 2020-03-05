<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/


class DDbmoviesClient extends DDbmoviesHelpers{


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
        add_action('init', array($this,'InsertData'));
        add_action('init', array($this,'Deactivation'));
        if(is_user_logged_in() && current_user_can('administrator')){
            add_action('admin_init', array($this,'DBMVSActivation'));
            add_action('admin_init', array($this,'TMDbActivation'));
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function InsertData(){
        $action = $this->Disset($_REQUEST,'dbmvs-action');
        if($action == 'import'){
            $type = $this->Disset($_REQUEST,'type');
            $data = array('id' => $this->Disset($_REQUEST,'id'));
            header('Access-Control-Allow-Origin: *');
            header('Content-type: application/json');
            new DDbmoviesImporters($type, $data);
            exit;
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function ApiRest(){
        // soon..
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function TMDbActivation(){
        $apikey = $this->get_option('themoviedb');
        $trasient = get_transient('themoviedb_activator');
        if($apikey){
            if($trasient === false){
                $args = array(
                    'api_key' => $apikey,
                );
                $rest = $this->RemoteJson($args, DBMOVIES_TMDBAPI.'/authentication/guest_session/new');
                if(!is_wp_error($rest) && $this->Disset($rest,'success') == true){
                    $data = array(
                        'response' => true,
                        'session' => $this->Disset($rest,'guest_session_id'),
                        'time' => time()
                    );
                    set_transient('themoviedb_activator', $data, 1 * HOUR_IN_SECONDS);
                }
            }
        }else{
            if($trasient){
                delete_transient('themoviedb_activator');
            }
        }
    }


    /**
     * @since 2.2.8
     * @version 1.0
     */
    public function DBMVSActivation(){
        $apikey = $this->get_option('dbmovies');
        $trasient = get_transient('dbmovies_activator');
        if($apikey){
            if($trasient === false){
                $post = array(
                    'body' => array(
                    'process' => 'activate',
                    'domain'   => 'localhost',
                    'license'  => $apikey,
                    'ipadress' => '127.0.0.1'
                    )
                );
                $rest = wp_remote_post(DBMOVIES_DBMVAPI,$post);
                $data = array('status' => 'verifying', 'apikey' => $apikey);
                if(!is_wp_error($rest)){
                    $data = wp_remote_retrieve_body($rest);
                    $data = maybe_unserialize($data);
                }
                // Set Action
                set_transient('dbmovies_activator', $data, 1 * HOUR_IN_SECONDS);
            }
        }else{
            if($trasient){
                delete_transient('dbmovies_activator');
            }
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Deactivation(){
        // Post Data
        $action = $this->Disset($_POST,'dbmvs-action');
        $apikey = $this->Disset($_POST,'dbmvs-apikey');
        // Verify Method and Action
        if($_SERVER['REQUEST_METHOD'] === 'POST' && $action == 'deactivate'){
            // Compose pre-response
            $response = array(
                'response' => false,
                'message' => 'no_access'
            );
            // Verify Api key
            if($apikey === $this->get_option('dbmovies')){
                // Delete Server Information
                $this->set_option('dbmovies','');
                delete_transient('dbmovies_activator');
                // The Response
                $response = array(
                    'response' => true,
                    'message' => 'completed'
                );
            }
            // Echo Json Response
            echo json_encode($response);
            exit();
        }
    }
}

new DDbmoviesClient;
