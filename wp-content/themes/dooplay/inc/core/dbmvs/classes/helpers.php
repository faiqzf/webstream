<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/


class DDbmoviesHelpers{


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function TimeExe($time = ''){
        $micro	= microtime(TRUE);
		return number_format($micro - $time, 2);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function DBMVStatus(){
        $key = $this->get_option('dbmovies');
        $sta = get_transient('dbmovies_activator');
        $eco = 'jump status empty';
        if($key){
            if($sta){
                if(isset($sta['status']) && $sta['status'] == 'active'){
                    $eco = 'status valid';
                } else {
                    $eco = 'jump status invalid';
                }
            } else {
                $eco = 'verifying';
            }
        }
        return $eco;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function TMDbStatus(){
        $key = $this->get_option('themoviedb');
        $sta = get_transient('themoviedb_activator');
        $eco = 'jump status empty';
        if($key){
            if($sta){
                if(isset($sta['response']) && $sta['response'] == true){
                    $eco = 'status valid';
                } else {
                    $eco = 'jump status invalid';
                }
            } else {
                $eco = 'verifying';
            }
        }
        return $eco;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function InsertGenres($post_id = '', $type = ''){
        $tmdb = $this->Disset($_POST,'ids');
        $term = get_the_term_list($post_id,'genres');
        if($this->get_option('genres') == true && !empty($tmdb) && $term == false){
            $args = array(
                'language' => $this->get_option('language','en-US'),
                'api_key'  => $this->get_option('themoviedb',DBMOVIES_TMDBKEY),
            );
            $rmtapi = $this->RemoteJson($args, DBMOVIES_TMDBAPI.'/'.$type.'/'.$tmdb);
            $genres = $this->Disset($rmtapi,'genres');
            $insert = array();
            foreach($genres as $genre){
                $insert[] = $this->Disset($genre,'name');
            }
            wp_set_object_terms($post_id,$insert,'genres',false);
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Compose_Title_ID($string = ''){
        // It is a valid link
        if(filter_var($string, FILTER_VALIDATE_URL)){
            // Set counters at zero
            $icount = 0;
            $tcount = 0;
            // Verify link
            str_replace('imdb.com', null, $string, $icount);
            str_replace('themoviedb.org', null, $string, $tcount);
            if(isset($tcount) OR isset($icount)){
                // Is Themoviedb.org
                if($tcount){
                    $formt1 = explode('/tv/',$string);
                    $formt2 = explode('/movie/',$string);
                    if($this->Disset($formt1,1)){
                        $theid = explode('-',$this->Disset($formt1,1));
                        $theid = $this->Disset($theid,0);
                    }
                    if($this->Disset($formt2,1)){
                        $theid = explode('-',$this->Disset($formt2,1));
                        $theid = $this->Disset($theid,0);
                    }
                    return $theid;
                }
                // Is IMDb.com
                if($icount){
                    $theid = explode('/title/',$string);
                    $theid = explode('/',$this->Disset($theid,1));
                    return $this->Disset($theid,0);
                }
            } else {
                return false;
            }
        } else {
            // Is a simple ID
            return $string;
        }
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function get_option($option_name = '', $default = ''){
        $options = apply_filters('dmovies_get_option', get_option(DBMOVIES_OPTIONS), $option_name, $default);
        if(!empty($option_name) && !empty($options[$option_name])){
            return $options[$option_name];
        } else {
            return (!empty($default)) ? $default : null;
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function st_get_option($option_name = '', $default = ''){
        $options = apply_filters('dmovies_get_option', get_option(DBMOVIES_OPTIONS), $option_name, $default);
        if(!empty($option_name) && !empty($options[$option_name])){
            return $options[$option_name];
        } else {
            return (!empty($default)) ? $default : null;
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function set_option($option_name = '', $new_value = ''){
        $options = apply_filters('dbmovies_set_option', get_option(DBMOVIES_OPTIONS), $option_name, $new_value );
        if(!empty($option_name)){
            $options[$option_name] = $new_value;
            update_option(DBMOVIES_OPTIONS, $options);
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function st_set_option($option_name = '', $new_value = ''){
        $options = apply_filters('dbmovies_set_option', get_option(DBMOVIES_OPTIONS), $option_name, $new_value );
        if(!empty($option_name)){
            $options[$option_name] = $new_value;
            update_option(DBMOVIES_OPTIONS, $options);
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function field_text($id = '', $default = '', $desc = '', $placeholder = ''){
        $option = $this->get_option($id, $default);
        $sedesc = !empty($desc) ? '<p>'.$desc.'</p>' : false;
        echo "<fieldset><input id='dbmv-input-$id' type='text' name='dbmvsettings[$id]' value='$option' placeholder='$placeholder'>$sedesc</fieldset>";
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function field_number($id = '', $default = '', $desc = '', $placeholder = ''){
        $option = $this->get_option($id, $default);
        $sedesc = !empty($desc) ? '<p>'.$desc.'</p>' : false;
        echo "<fieldset><input id='dbmv-input-$id' type='number' name='dbmvsettings[$id]' value='$option' placeholder='$placeholder'>$sedesc</fieldset>";
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function field_checkbox($id = '', $text = ''){
        $checked = checked($this->get_option($id), true, false);
        $out_html  = "<fieldset><label for=checkbox-$id>";
        $out_html .= "<input id='checkbox-$id' name='dbmvsettings[$id]' type='checkbox' value='1' $checked> <span>$text</span>";
        $out_html .= "</label></fieldset>";
        echo $out_html;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function field_radio($id = '', $options = '', $default = ''){
        $option = $this->get_option($id,$default);
        $out_html = "";
        foreach($options as $key => $val){
            $checked = checked($option, $key, false);
            $out_html .= "<fieldset class='radio'><label for=checkbox-$id-$key>";
            $out_html .= "<input id='checkbox-$id-$key' name='dbmvsettings[$id]' type='radio' value='$key' $checked> <span>$val</span>";
            $out_html .= "</label></fieldset>";
        }
        echo $out_html;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function field_select($id = '', $options ='', $default = '', $desc = ''){
        $option = $this->get_option($id, $default);
        $sedesc = !empty($desc) ? '<p>'.$desc.'</p>' : false;
        $out_html = "<fieldset><select id='select-$id' name='dbmvsettings[$id]'>";
        foreach($options as $key => $val) {
            $out_html .= "<option value='$key' ".selected($option, $key, false).">$val</option>";
        }
        $out_html .= "</select>$sedesc</fieldset>";
        echo $out_html;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function ResponseJson($data = array()){
        if(is_array($data)){
            return json_encode($data);
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function SetUserPost(){
        return is_user_logged_in() ? get_current_user_id() : '1';
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function RemoteJson($args = array(), $api = ''){
        $sapi = esc_url_raw(add_query_arg($args,$api));
        $json = wp_remote_retrieve_body(wp_remote_get($sapi));
        return json_decode($json,true);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function SRemoteJson($args = array(), $api = ''){
        $sapi = esc_url_raw(add_query_arg($args,$api));
        $json = wp_remote_retrieve_body(wp_remote_get($sapi));
        return json_decode($json,true);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Disset($data ='', $key = ''){
        return isset($data[$key]) ? $data[$key] : null;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Tags($option ='', $data =''){
        $option = str_replace('{name}', $this->Disset($data,'name'), $option);
        $option = str_replace('{year}', $this->Disset($data,'year'), $option);
        $option = str_replace('{season}', $this->Disset($data,'season'), $option);
        $option = str_replace('{episode}', $this->Disset($data,'episode'), $option);
        return apply_filters('dbmovies_title_tags',$option, $data);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function TextCleaner($text = ''){
        return wp_strip_all_tags(html_entity_decode($text));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function VeryTMDb($meta_key = '', $tmdb_id = '', $post_type = ''){
        $query = array(
            'post_type' => $post_type,
            'meta_query' => array(
                array(
                    'key'   => $meta_key,
                    'value' => $tmdb_id
                )
            ),
            'posts_per_page' => 1
        );
        $query = new WP_Query($query);
        $query = wp_list_pluck($query->posts,'ID');
        return $this->Disset($query,0);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function VeryTMDbSE($tmdb = '', $season =''){
        $query = array(
            'post_type'  => 'seasons',
            'meta_query' => array(
                array('key' => 'ids', 'value' => $tmdb),
                array('key' => 'temporada', 'value' => $season)
            ),
            'posts_per_page' => 1
        );
        $query = new WP_Query($query);
        $query = wp_list_pluck($query->posts,'ID');
        return $this->Disset($query,0);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function VeryTMDbEP($tmdb = '', $season = '', $episode = ''){
        $query = array(
            'post_type'  => 'episodes',
            'meta_query' => array(
                array('key' => 'ids','value' => $tmdb),
                array('key' => 'temporada','value' => $season),
                array('key' => 'episodio','value' => $episode)
            ),
            'posts_per_page' => 1
        );
        $query = new WP_Query($query);
        $query = wp_list_pluck($query->posts,'ID');
        return $this->Disset($query,0);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function UploadImage($url = '', $post = '', $thumbnail = false, $showurl = false ){
        if($this->get_option('upload') == true && !empty($url)){
            // WordPress Lib
            require_once(ABSPATH.'wp-admin/includes/file.php');
			require_once(ABSPATH.'wp-admin/includes/image.php');
            // File System
            global $wp_filesystem;
            WP_Filesystem();
			// Get Image
			$upload_dir	  = wp_upload_dir();
			$image_remote = wp_remote_get($url);
			$image_data	  = wp_remote_retrieve_body($image_remote);
			$filename	  = wp_basename($url);
            if(!is_wp_error($image_data)){
                // Path folder
    			if(wp_mkdir_p($upload_dir['path'])) {
    				$file = $upload_dir['path'] . '/' . $filename;
    			} else {
    				$file = $upload_dir['basedir'] . '/' . $filename;
    			}
    			$wp_filesystem->put_contents($file, $image_data);
    			$wp_filetype = wp_check_filetype($filename, null);
    			// Compose attachment Post
    			$attachment = array(
    				'post_mime_type' => $wp_filetype['type'],
    				'post_title' => sanitize_file_name($filename),
    				'post_content' => false,
    				'post_status' => 'inherit'
    			);
    			// Insert Attachment
    			$attach_id	 = wp_insert_attachment($attachment, $file, $post);
    			$attach_data = wp_generate_attachment_metadata($attach_id, $file);
    			wp_update_attachment_metadata($attach_id, $attach_data );
    			// Featured Image
    			if($thumbnail == true) set_post_thumbnail($post, $attach_id);
    			if($showurl == true) return wp_get_attachment_url($attach_id);
            }
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function PostOrder(){
        return array(
            'ASC'  => __('Ascending'),
            'DESC' => __('Descending')
        );
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function PostStatus(){
        return array(
            'publish' => __('Publish'),
            'pending' => __('Pending'),
            'draft'   => __('Draft')
        );
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function Languages(){
        $languages = array(
			"ar-AR" => __d('Arabic'),
			"bs-BS" => __d('Bosnian'),
			"bg-BG" => __d('Bulgarian'),
			"hr-HR" => __d('Croatian'),
			"cs-CZ" => __d('Czech'),
			"da-DK" => __d('Danish'),
			"nl-NL" => __d('Dutch'),
			"en-US" => __d('English'),
			"fi-FI" => __d('Finnish'),
			"fr-FR" => __d('French'),
			"de-DE" => __d('German'),
			"el-GR" => __d('Greek'),
			"he-IL" => __d('Hebrew'),
			"hu-HU" => __d('Hungarian'),
			"is-IS" => __d('Icelandic'),
			"id-ID" => __d('Indonesian'),
			"it-IT" => __d('Italian'),
			"ko-KR" => __d('Korean'),
			"lb-LB" => __d('Letzeburgesch'),
			"lt-LT" => __d('Lithuanian'),
			"zh-CN" => __d('Mandarin'),
			"fa-IR" => __d('Persian'),
			"pl-PL" => __d('Polish'),
			"pt-PT" => __d('Portuguese'),
			"pt-BR" => __d('Brazilian Portuguese'),
			"ro-RO" => __d('Romanian'),
			"ru-RU" => __d('Russian'),
			"sk-SK" => __d('Slovak'),
			"es-ES" => __d('Spanish'),
			"es-MX" => __d('Spanish LA'),
			"sv-SE" => __d('Swedish'),
			"th-TH" => __d('Thai'),
			"tr-TR" => __d('Turkish'),
			"tw-TW" => __d('Twi'),
			"uk-UA" => __d('Ukrainian'),
			"vi-VN" => __d('Vietnamese')
		);
        return apply_filters('dbmovies_tmdb_languages',$languages);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function GenresMovies(){
        $genres = array(
			null	=> __d('All genres'),
			'28'	=> __d('Action'),
			'12'	=> __d('Adventure'),
			'16'	=> __d('Animation'),
			'35'	=> __d('Comedy'),
			'80'	=> __d('Crime'),
			'99'	=> __d('Documentary'),
			'18'	=> __d('Drama'),
			'10751' => __d('Family'),
			'14'	=> __d('Fantasy'),
			'36'	=> __d('History'),
			'27'	=> __d('Horror'),
			'10402' => __d('Music'),
			'9648'	=> __d('Mystery'),
			'10749' => __d('Romance'),
			'878'	=> __d('Science Fiction'),
			'10770' => __d('TV Movie'),
			'53'	=> __d('Thriller'),
			'10752' => __d('War'),
			'37'	=> __d('Western')
		);
        $html_out ='';
        foreach($genres as $key => $name){
            $html_out .="<option value='$key'>$name</option>\n";
        }
        return apply_filters('dbmovies_tmdb_genres_movies',$html_out);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function GenresTVShows(){
        $genres = array(
			null	=> __d('All genres'),
			'10759'	=> __d('Action & Adventure'),
			'16'	=> __d('Animation'),
			'35'	=> __d('Comedy'),
			'80'	=> __d('Crime'),
			'99'	=> __d('Documentary'),
			'18'	=> __d('Drama'),
			'10751'	=> __d('Family'),
			'10762'	=> __d('Kids'),
			'9648'	=> __d('Mystery'),
			'10763'	=> __d('News'),
			'10764'	=> __d('Reality'),
			'10765'	=> __d('Sci-Fi & Fantasy'),
			'10766'	=> __d('Soap'),
			'10767'	=> __d('Talk'),
			'10768'	=> __d('War & Politics'),
			'37'	=> __d('Western'),
		);
        $html_out ='';
        foreach($genres as $key => $name){
            $html_out .="<option value='$key'>$name</option>\n";
        }
        return apply_filters('dbmovies_tmdb_genres_tvshows',$html_out);
    }


/**
 * @since 2.2.6
 * @version 1.0
 */
public static function GetAllSeasons($tmdb = ''){
    $query = '';
    $cfile = DBMOVIES_CACHE_DIR.'seasons.'.$tmdb;
    if(file_exists($cfile) && filemtime($cfile) + DBMOVIES_CACHE_TIM >= time()){
        $query = file_get_contents($cfile);
        $query = maybe_unserialize($query);
    }else{
        $query = array(
            'post_type'      => 'seasons',
            'post_status'    => 'publish',
            'posts_per_page' => 1000,
            'paged'          => 1,
            'meta_query' => array(
                array(
                    'key'   => 'ids',
                    'value' => $tmdb
                )
            ),
            'meta_key' => 'temporada',
            'orderby'  => 'meta_value_num',
            'order'    => self::st_get_option('orderseasons','ASC')
        );
        $query = new WP_Query($query);
        $query = wp_list_pluck($query->posts,'ID');
        file_put_contents($cfile,serialize($query));
    }
    return apply_filters('dbmovies_get_static_seasons', $query, $tmdb);
}


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function GetAllEpisodes($tmdb = '', $season = ''){
        $query = '';
        $cfile = DBMOVIES_CACHE_DIR.'episodes_'.$season.'.'.$tmdb;
        if(file_exists($cfile) && filemtime($cfile) + DBMOVIES_CACHE_TIM >= time()){
            $query = file_get_contents($cfile);
            $query = maybe_unserialize($query);
        }else{
            $query = array(
                'post_type'      => 'episodes',
                'post_status'    => 'publish',
                'posts_per_page' => 1000,
                'paged'          => 1,
                'meta_query' => array(
                    array(
                        'key'   => 'ids',
                        'value' => $tmdb
                    ),
                    array(
                        'key' => 'temporada',
                        'value' => $season
                    )
                ),
                'meta_key' => 'episodio',
                'orderby'  => 'meta_value_num',
                'order'    => self::st_get_option('orderepisodes','ASC')
            );
            $query = new WP_Query($query);
            $query = wp_list_pluck($query->posts,'ID');
            file_put_contents($cfile,serialize($query));
        }
        return apply_filters('dbmovies_get_static_episodes', $query, $tmdb.$season);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function EpisodeNav($tmdb ='', $season ='', $episode =''){
        return array(
            'prev' => self::EpisodeData($tmdb, $season, $episode-1),
            'next' => self::EpisodeData($tmdb, $season, $episode+1),
            'tvsh' => self::TVShowData($tmdb)
        );
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function EpisodeData($tmdb ='', $season ='', $episode =''){
        $query = array(
            'post_type'      => 'episodes',
            'post_status'    => 'publish',
            'meta_query' => array(
                array(
                    'key'   => 'ids',
                    'value' => $tmdb
                ),
                array(
                    'key' => 'temporada',
                    'value' => $season,
                ),
                array(
                    'key' => 'episodio',
                    'value' => $episode,
                )
            ),
            'paged' => 1,
            'posts_per_page' => 1,
        );
        $query = new WP_Query($query);
        $query = wp_list_pluck($query->posts,'ID');
        if(isset($query[0])){
            return array(
                'title'     => get_the_title($query[0]),
                'permalink' => get_permalink($query[0])
            );
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function SeasonData($tmdb ='', $season =''){
        $query = array(
            'post_type'      => 'seasons',
            'post_status'    => 'publish',
            'meta_query' => array(
                array(
                    'key'   => 'ids',
                    'value' => $tmdb
                ),
                array(
                    'key' => 'temporada',
                    'value' => $season,
                )
            ),
            'paged' => 1,
            'posts_per_page' => 1,
        );
        $query = new WP_Query($query);
        $query = wp_list_pluck($query->posts,'ID');
        if(isset($query[0])){
            return array(
                'title'     => get_the_title($query[0]),
                'permalink' => get_permalink($query[0])
            );
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function TVShowData($tmdb = ''){
        $query = array(
            'post_type'   => 'tvshows',
            'post_status' => 'publish',
            'meta_query' => array(
                array(
                    'key'   => 'ids',
                    'value' => $tmdb
                )
            ),
            'paged' => 1,
            'posts_per_page' => 1,
        );
        $query = new WP_Query($query);
        $query = wp_list_pluck($query->posts,'ID');
        if(isset($query[0])){
            return array(
                'post_id'   => $query[0],
                'title'     => get_the_title($query[0]),
                'permalink' => get_permalink($query[0]),
                'editlink'  => admin_url('post.php?action=edit&post='.$query[0])
            );
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function GetIMDbID($page = 1, $per_page = 5){
        $imdb  = array();
        $query = array(
            'post_type' => 'movies',
            'post_status' => 'publish',
            'paged' => $page,
            'posts_per_page' => $per_page,
        );
        $query = new WP_Query($query);
        $query = wp_list_pluck($query->posts,'ID');
        if($query){
            self::UpdateIMDbSett($page);
            foreach($query as $id){
                $meta = get_post_meta($id,'ids',true);
                $imdb[] = self::UpdateIMDb($meta,$id);
            }
        }else{
            update_option(DBMOVIES_OPTIMDB, array('time' => time(), 'page' => '1'));
        }
        return $imdb;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function UpdateIMDb($imdb = '', $post_id = ''){
        // Response
        $response = array();
        // Dbmvs Api Key
        $dbmv = self::st_get_option('dbmovies');
        // IMDb Parameters
        $imdb_args = array(
            'key'  => $dbmv,
            'imdb' => $imdb
        );
        // Json Remote
        $json_imdb = self::SRemoteJson($imdb_args,DBMOVIES_DBMVAPI);
        // Verify Response
        if(isset($json_imdb['response']) && $json_imdb['response'] == true){
            // Cache
            $cache = new DooPlayCache;
            // Get Rating
            $imdb_rating = isset($json_imdb['rating']) ? $json_imdb['rating'] : false;
            $imdb_countr = isset($json_imdb['country']) ? $json_imdb['country'] : false;
            $imdb_rated  = isset($json_imdb['rated']) ? $json_imdb['rated'] : false;
            $imdb_votes  = isset($json_imdb['votes']) ? $json_imdb['votes'] : false;

            // Update Options
            if($imdb_rating) update_post_meta($post_id, 'imdbRating', sanitize_text_field($imdb_rating));
            if($imdb_votes) update_post_meta($post_id, 'imdbVotes', sanitize_text_field($imdb_votes));
            if($imdb_rated) update_post_meta($post_id, 'Rated', sanitize_text_field($imdb_rated));
            if($imdb_countr) update_post_meta($post_id, 'Country', sanitize_text_field($imdb_countr));
            // Delete Cache
            $cache->delete($post_id.'_postmeta');
            // Response
            $response = array(
                'imdb'   => $imdb,
                'rating' => $imdb_rating,
                'votes'  => $imdb_votes,
                'title'  => get_the_title($post_id),
                'plink'  => get_permalink($post_id)
            );
        }else{
            $response = array(
                'imdb' => false,
                'message' => isset($json_imdb['error']) ? $json_imdb['error'] : __d('Pending process')
            );
        }
        // Response
        return $response;
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public static function UpdateIMDbSett($page = ''){
        $option = get_option(DBMOVIES_OPTIMDB);
        $optime = isset($option['time']) ? $option['time'] : time();
        $oppage = isset($option['page']) ? $option['page'] : '1';
        $sepage = !empty($page) ? ($page+1) : $oppage;
        if(($optime+172800) >= time()){
            $new_data = array(
                'time' => time(),
                'page' => $sepage
            );
        }else{
            $new_data = array(
                'time' => time(),
                'page' => '1'
            );
        }
        if($page){
            update_option(DBMOVIES_OPTIMDB,$new_data);
        } else{
            return $new_data['page'];
        }
    }
}
