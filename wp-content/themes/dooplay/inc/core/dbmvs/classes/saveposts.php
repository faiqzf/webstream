<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/


class DDbmoviesSvePosts extends DDbmoviesHelpers{

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
        add_action('save_post', array(&$this,'save_movies'));
        add_action('save_post', array(&$this,'save_tvshows'));
        add_action('save_post', array(&$this,'save_seasons'));
        add_action('save_post', array(&$this,'save_episodes'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function save_movies($post_id){
        // Verificators
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
        if(!isset($_POST['movie_nonce']) || !wp_verify_nonce($_POST['movie_nonce'], '_movie_nonce')) return;
		if(!current_user_can('edit_post', $post_id)) return;
        // All Postmeta's
        $postmetas = array(
            'ids','dt_poster','dt_backdrop','imagenes','youtube_id','imdbRating','imdbVotes','original_title','Rated',
			'release_date','runtime','Country','vote_average','vote_count','tagline','dt_cast','dt_dir','idtmdb','dt_featured_post'
        );
        // Set Postmeta
        $this->SetPostMetas($postmetas,$post_id);
        // Set Genres
        $this->InsertGenres($post_id,'movie');
        // Set Featured Image
        $this->SetFeaturedImage($this->Disset($_POST,'dt_poster'),$post_id);
        // Delete Cache
        $this->DeleteCache($post_id);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function save_tvshows($post_id){
        // verification
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
		if(!isset($_POST['tvshows_nonce']) || !wp_verify_nonce($_POST['tvshows_nonce'],'_tvshows_nonce')) return;
		if(!current_user_can('edit_post', $post_id ) ) return;
        // All Postmeta's
        $postmetas = array(
            'ids','dt_poster','dt_backdrop','imagenes','youtube_id','number_of_episodes','number_of_seasons','original_name',
			'imdbRating','imdbVotes','episode_run_time','first_air_date','last_air_date','dt_cast','dt_creator','clgnrt','dt_featured_post'
        );
        // Set Postmeta
        $this->SetPostMetas($postmetas,$post_id);
        // Set Genres
        $this->InsertGenres($post_id,'tv');
        // Set Featured Image
        $this->SetFeaturedImage($this->Disset($_POST,'dt_poster'),$post_id);
        // Delete Cache
        $this->DeleteCache($post_id);
        dbmovies_clean_tile($this->Disset($_POST,'ids'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function save_seasons($post_id){
        // Verification
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
		if(!isset($_POST['seasons_nonce']) || ! wp_verify_nonce($_POST['seasons_nonce'],'_seasons_nonce')) return;
		if(!current_user_can('edit_post',$post_id)) return;
        // Clean cache
        dbmovies_clean_tile($this->Disset($_POST,'ids'));
        // All Postmeta's
        $postmetas = array('ids','temporada','dt_poster','serie','air_date','clgnrt');
        // Set Postmeta
        $this->SetPostMetas($postmetas,$post_id);
        // Set Featured Image
        $this->SetFeaturedImage($this->Disset($_POST,'dt_poster'),$post_id);
        // Delete Cache
        $this->DeleteCache($post_id);
        dbmovies_clean_tile($this->Disset($_POST,'ids'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function save_episodes($post_id){
        // Verification
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
		if(!isset($_POST['episodios_nonce']) || !wp_verify_nonce($_POST['episodios_nonce'],'_episodios_nonce')) return;
		if(!current_user_can('edit_post',$post_id)) return;
        // All Postmeta's
        $postmetas = array('ids','temporada','episodio','air_date','episode_name','dt_backdrop','imagenes','serie');
        // Set Postmeta
        $this->SetPostMetas($postmetas,$post_id);
        // Set Featured Image
        $this->SetFeaturedImage($this->Disset($_POST,'dt_backdrop'),$post_id);
        // Delete Cache
        $this->DeleteCache($post_id);
        dbmovies_clean_tile($this->Disset($_POST,'ids'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function SetPostMetas($postmetas = array(), $post_id = ''){
        if(is_array($postmetas) && $post_id){
            foreach($postmetas as $meta){
                if($this->Disset($_POST,$meta) === '0'){
                    update_post_meta($post_id, $meta,'0');
                }elseif($this->Disset($_POST,$meta)){
                    update_post_meta($post_id, $meta,$this->Disset($_POST,$meta));
                }  else {
                    delete_post_meta($post_id,$meta);
                }
    		}
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function SetFeaturedImage($image = '', $post_id = ''){
        if(!filter_var($image, FILTER_VALIDATE_URL)){
            $image_url = $image ? 'https://image.tmdb.org/t/p/w500'.$image : false;
            if($image_url != false && has_post_thumbnail() == false){
                $this->UploadImage($image_url, $post_id, true, false);
            }
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function DeleteCache($post_id = ''){
        if(!empty($post_id)){
            $cache = new DooPlayCache;
            $cache->delete($post_id.'_postmeta');
        }
    }
}

new DDbmoviesSvePosts;
