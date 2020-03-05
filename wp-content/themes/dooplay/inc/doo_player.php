<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.2.3
*
*/

class DooPlayer{
	// Attributes
	public $postmeta;

    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function __construct(){

        // Main postmeta
        $this->postmeta = 'repeatable_fields';

        // Actions
        add_action('save_post', array($this,'save'));
        add_action('admin_init', array($this,'add_metabox'), 1);

        // Ajax Actions
        add_action('wp_ajax_doo_player_ajax', array($this,'ajax'));
    	add_action('wp_ajax_nopriv_doo_player_ajax', array($this,'ajax'));
	}



    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function languages(){
		return array(
			__d('---------')			=> null,
			__d('Chinese')				=> 'cn',
			__d('Denmark')				=> 'dk',
			__d('Dutch')				=> 'nl',
			__d('English')				=> 'en',
			__d('English British')		=> 'gb',
			__d('Egypt')				=> 'egt',
			__d('French')				=> 'fr',
			__d('German')				=> 'de',
			__d('Indonesian')			=> 'id',
			__d('Hindi')				=> 'in',
			__d('Italian')				=> 'it',
			__d('Japanese')				=> 'jp',
			__d('Korean')				=> 'kr',
			__d('Philippines')			=> 'ph',
			__d('Portuguese Portugal')	=> 'pt',
			__d('Portuguese Brazil')	=> 'br',
			__d('Polish')				=> 'pl',
			__d('Romanian')				=> 'td',
			__d('Scotland')				=> 'sco',
			__d('Spanish Spain')		=> 'es',
			__d('Spanish Mexico')		=> 'mx',
			__d('Spanish Argentina')	=> 'ar',
			__d('Spanish Peru')			=> 'pe',
			__d('Spanish Chile')		=> 'cl',
			__d('Spanish Colombia')		=> 'co',
			__d('Sweden')				=> 'se',
			__d('Turkish')				=> 'tr',
			__d('Rusian')				=> 'ru',
			__d('Vietnam')				=> 'vn'
		);
	}



    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function type_player(){
		return array(
			__d('URL Iframe')			  => 'iframe',
			__d('URL MP4')				  => 'mp4',
			__d('ID or URL Google Drive') => 'gdrive',
			__d('Shortcode or HTML')	  => 'dtshcode',
		);
	}



    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function add_metabox(){
		add_meta_box('repeatable-fields', __d('Video Player'), array($this,'view_metabox'), 'movies', 'normal', 'default');
		add_meta_box('repeatable-fields', __d('Video Player'), array($this,'view_metabox'), 'episodes', 'normal', 'default');
	}



    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function view_metabox(){
        global $post;
		$postmneta = get_post_meta($post->ID, $this->postmeta, true);
		wp_nonce_field('doo_player_editor_nonce', 'doo_player_editor_nonce');
        require get_parent_theme_file_path('/inc/parts/player_editor.php');
	}



    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function save($post_id){
		if(!isset($_POST['doo_player_editor_nonce']) || !wp_verify_nonce($_POST['doo_player_editor_nonce'], 'doo_player_editor_nonce')) return;
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if(!current_user_can('edit_post',$post_id)) return;

		// Meta data
		$antiguo = get_post_meta($post_id, $this->postmeta, true);
		$nuevo	 = array();
		$options = $this->type_player();
		$names	 = doo_isset($_POST,'name');
		$selects = doo_isset($_POST,'select');
		$idiomas = doo_isset($_POST,'idioma');
		$urls	 = doo_isset($_POST,'url');
		$count	 = count($names);

		// Serialized data
		for($i = 0; $i < $count; $i++){
			if ($names[$i] != ''):
				$nuevo[$i]['name'] = stripslashes(strip_tags($names[$i]));
				if(in_array($selects[$i], $options)) $nuevo[$i]['select'] = $selects[$i];
				else $nuevo[$i]['select'] = '';
				if(in_array($idiomas[$i], $idiomas)) $nuevo[$i]['idioma'] = $idiomas[$i];
				else $nuevo[$i]['idioma'] = '';
				if($urls[$i] == 'http://') $nuevo[$i]['url'] = '';
				else $nuevo[$i]['url'] = stripslashes($urls[$i]);
			endif;
		}
		if(!empty($nuevo) && $nuevo != $antiguo) update_post_meta($post_id, $this->postmeta, $nuevo);
		elseif (empty($nuevo) && $antiguo) delete_post_meta($post_id, $this->postmeta, $antiguo);
	}



    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function ajax(){
		// POST Data
        $post_id = doo_isset($_POST,'post');
        $post_ty = doo_isset($_POST,'type');
        $play_nm = doo_isset($_POST,'nume');
		// Verify data
        if($post_id && $play_nm){
            // Get post meta
            switch ($post_ty) {
                case 'movie':
                    $postmeta = doo_postmeta_movies($post_id);
                    break;
                case 'tv':
                    $postmeta = doo_postmeta_episodes($post_id);
                    break;
            }
            // Compose Player
            $player = doo_isset($postmeta,'players');
            $player = maybe_unserialize($player);
            // compose data
            $pag = doo_compose_pagelink('jwpage');
            $url = ($play_nm != 'trailer') ? $this->ajax_isset($player, ($play_nm-1),'url') : false;
            $typ = ($play_nm == 'trailer') ? 'trailer' : $this->ajax_isset($player, ($play_nm-1),'select');
            // verify data
            if($typ){
                switch($typ) {
                    case 'iframe':
                        $code = "<if"."rame class='metaframe rptss' src='{$url}' frameborder='0' scrolling='no' allow='autoplay; encrypted-media' allowfullscreen></ifr"."ame>";
                        break;

                    case 'mp4':
                    case 'gdrive':
                        $code = "<if"."rame class='metaframe rptss' src='{$pag}?source=".urlencode($url)."&id={$post_id}&type={$typ}' frameborder='0' scrolling='no' allow='autoplay; encrypted-media' allowfullscreen></ifr"."ame>";
                    	break;

                    case 'trailer':
                        $code = doo_trailer_iframe(doo_isset($postmeta,'youtube_id'),1);
                    	break;

                    case 'dtshcode':
                        $code = do_shortcode($url);
                    	break;
                }
                // Return Player
                echo apply_filters('doo_player_ajax',$code,$url,$typ);
            }
        }
        // End Action
        wp_die();
	}



    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function ajax_isset($data = array(), $n, $k){
		return (isset($data[$n][$k])) ? $data[$n][$k] : false;
	}



    /**
     * @since 2.2.3
     * @version 1.0
     */
    public static function viewer($post, $type, $players, $trailer, $size, $views, $ads = false, $image = false){
        if($size == 'regular'){
            self::fake($image, 'regular');
        }
        if($players OR $trailer){
            $ulclass = (!wp_is_mobile()) ? 'options scrolling' : 'options';
            $html ="<div class='dooplay_player'>";
            if($size === 'regular'){
                $html .="<div id='playcontainer' class='play'>";
                if(!empty($ads)){
                    $html .="<div class='asgdc'>{$ads}</div>";
                }
                $html .="<div id='dooplay_player_response'></div>";
                $html .="</div>";
            }
            $html .="<h2>".__d('Video Sources')." <span id='playernotice' data-text='{$views}'>{$views}</span></h2>";
            $html .="<div id='playeroptions' class='{$ulclass}'><ul id='playeroptionsul'>";
            if($trailer != false){
                $html .="<li id='player-option-trailer' class='dooplay_player_option' data-post='{$post}' data-type='{$type}' data-nume='trailer'>";
                $html .="<i class='icon-play3'></i>";
                $html .="<span class='title'>".__d('Watch trailer')."</span>";
                $html .="<span class='server'>youtube.com</span>";
                $html .="<span class='flag'><i class='yt icon-youtube2'></i></span>";
                $html .="<span class='loader'></span></li>";
            }
            $num = 1;
            if(!empty($players) && is_array($players)){
                foreach($players as $play){
                    $html .="<li id='player-option-{$num}' class='dooplay_player_option' data-type='{$type}' data-post='{$post}' data-nume='{$num}'>";
                    $html .="<i class='icon-play3'></i>";
                    $html .="<span class='title'>{$play['name']}</span>";
                    $html .="<span class='server'>".doo_compose_servername($play['url'], $play['select'])."</span>";
                    if(!empty($play['idioma'])){
                        $html .="<span class='flag'><img src='".DOO_URI."/assets/img/flags/{$play['idioma']}.png'></span>";
                    }
                    $html .="<span class='loader'></span></li>";
                    $num++;
                }
            }
            $html .="</ul></div>";
            $html .="</div>";
            echo apply_filters('doo_player_html', $html);
        }
    }



    /**
     * @since 2.2.3
     * @version 1.0
     */
    public static function viewer_big($size, $ads = false, $image = false){
        if($size === 'bigger'){
            self::fake($image, 'bigger');
            $html ="<div class='dooplay_player'>";
            $html .="<div id='playcontainer' class='play bigger'>";
            if(isset($ads)){
                $html .="<div class='asgdc'>{$ads}</div>";
            }
            $html .="<div id='dooplay_player_response'></div>";
            $html .="</div></div>";
            echo apply_filters('doo_big_player_html', $html);
        }
    }


    /**
     * @since 2.2.3
     * @version 1.0
     */
    private static function fake($image, $class = 'regular'){
        $autolo = cs_get_option('playautoload');
        $active = cs_get_option('fakeplayer');
        $pimage = isset($image) ? $image : cs_get_option('fakebackdrop');
        $flinks = self::fake_links();
        if($autolo !== true && $active === true && $flinks !== false){
            $html ="<div id='fakeplayer' class='fakeplayer {$class}'>";
            $html .="<a id='clickfakeplayer' rel='nofollow' href='{$flinks}' target='_blank'>";
            $html .="<div class='playbox'>";
            if(doo_is_true('fakeoptions','qua')) $html .="<span class='quality'>HD</span>";
            if(doo_is_true('fakeoptions','pla')) $html .="<span class='playbtm'><img src='".DOO_URI."/assets/img/play.svg'/></span>";
            if($pimage) $html .="<img class='cover' src='{$pimage}'/>";
            $html .="<section>";
            $html .="<div class='progressbar'></div>";
            $html .="<div class='controls'><div class='box'>";
            $html .="<i class='icon-play3'></i>";
            if(doo_is_true('fakeoptions','ads')) $html .="<i class='icon-monetization_on flashit'></i> <small>".__d('Advertisement')."</small>";
            $html .="<i class='icon-zoom_out_map right'></i>";
            $html .="<i class='icon-wb_sunny right'></i>";
            $html .="</div></div></section>";
            $html .="</div></a></div>";
            // Compose Fake Player
            echo apply_filters('doo_fake_player_html', $html);
        }
    }



    /**
     * @since 2.2.3
     * @version 1.0
     */
    private static function fake_links(){
        $flinks = cs_get_option('fakeplayerlinks');
        if(!empty($flinks) && is_array($flinks)){
            $numb = array_rand($flinks);
            $link = $flinks[$numb]['link'];
            return esc_url($link);
        } else {
            return false;
        }
    }


    /**
     * @since 2.2.1
     * @version 1.0
     */
	public function __destruct(){
		return false;
	}
}

new DooPlayer;
