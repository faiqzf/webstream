<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
**************
* @since 2.2.6
*/

class DooDatabase{

    public $version = '2.1';
    public $options = '';


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function __construct(){
        if(is_admin()){
            // Ajax Actions
            add_action('wp_ajax_dooplaygeneratepage', array($this,'insert_pages_ajax'));
            add_action('wp_ajax_dooplaycleanerdatabase', array($this,'cleaner'));
            add_action('wp_ajax_dooplaydbtool', array($this,'tool'));
            add_action('admin_menu', array($this,'menu') );
            // More data
            $this->set_options();
        }
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function __destruct(){
        return false;
    }

    public function menu(){
        add_submenu_page(
            'tools.php',
            __d('DooPlay Database'),
            __d('DooPlay Database'),
            'manage_options',
            'dooplay-database',
            array($this,'tool_page')
        );
    }

    public function tool_page(){
        $newlink = get_option('dooplay_update_linksmodule');
        $lkey    = get_option('dooplay_license_key');
        $lstatus = get_option('dooplay_license_key_status');
        $timerun = get_option('_dooplay_database_tool_runs');
        $nonce   = wp_create_nonce('doodatabasetoolnonce');
        $never   = __d('this process was never executed');
        require_once(DOO_DIR.'/inc/parts/admin/database_tool.php');
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function insert_pages_ajax(){
        // Generator pages
        $this->insert_pages();
		// Redirect page
        wp_redirect($_SERVER['HTTP_REFERER'], 301 ); exit;
    }

    public function insert_pages(){
        // Compose pages
		$pages = array(

			'pagetrending' => array(
				'title' => __d('Trending'),
                'name' => false,
				'tpl' => 'trending'
			),

			'pageratings' => array(
				'title' => __d('Ratings'),
                'name' => false,
				'tpl' => 'rating'
			),

			'pageaccount' => array(
				'title' => __d('Account'),
                'name' => false,
				'tpl' => 'account'
			),

			'pagecontact' => array(
				'title' => __d('Contact'),
                'name' => false,
				'tpl' => 'contact'
			),

			'pageblog' => array(
				'title' => __d('Blog'),
                'name' => false,
				'tpl' => 'blog'
			),

			'pagetopimdb' => array(
				'title' => __d('TOP IMDb'),
				'name' => 'imdb',
				'tpl' => 'topimdb'
			),

			'jwpage' => array(
				'title' => __d('JW Player'),
				'name' => 'jwplayer',
				'tpl' => 'jwplayer'
			)
		);

		// Insert Pages
		foreach($pages as $key => $value){
            $post_id = wp_insert_post(array(
                'post_name' 	 => $value['name'] ? $value['name'] : $value['title'],
                'post_title' 	 => $value['title'],
                'post_status' 	 => 'publish',
                'post_type' 	 => 'page',
                'ping_status' 	 => 'closed',
                'comment_status' => 'closed',
                'page_template'  => 'pages/'.$value['tpl'].'.php'
            ));
            cs_set_option($key, $post_id);
		}
		// Update Option Pages
		update_option('dooplay_pages', true );
    }


    public function tool(){
        $run = doo_isset($_POST,'run');
        $noc = doo_isset($_POST,'noc');

        if($run && wp_verify_nonce($noc, 'doodatabasetoolnonce')){

            global $wpdb;

            $time = get_option('_dooplay_database_tool_runs');
            $time[$run] = time();

            switch ($run) {

                case 'genpages':
                    $this->insert_pages();
                    $remove = false;
                    break;

                case 'transients':
                    $wpdb->query("DELETE FROM {$wpdb->options} WHERE `option_name` LIKE (\"%\_transient\_%\")");
                    $remove = false;
                    break;

                case 'license':
                    delete_option('dooplay_license_key');
                    delete_option('dooplay_license_key_status');
                    delete_option('_transient_dooplay-update-response');
                    delete_option('_transient_dooplay_license_message');
                    delete_option('_transient_timeout_dooplay_license_message');
                    $remove = false;
                    break;

                case 'userfavorites':
                    $this->delete('usermeta','meta_key',$wpdb->base_prefix.'user_list_count');
                    $this->delete('postmeta','meta_key','_dt_list_users');
                    $remove = false;
                    break;

                case 'userviews':
                    $this->delete('usermeta','meta_key',$wpdb->base_prefix.'user_view_count');
                    $this->delete('postmeta','meta_key','_dt_views_users');
                    $remove = false;
                    break;

                case 'featured':
                    $this->delete('postmeta','meta_key','dt_featured_post');
                    $remove = false;
                    break;

                case 'reports':
                    $this->delete('postmeta','meta_key','numreport');
                    $remove = false;
                    break;

                case 'postviews':
                    $this->delete('postmeta','meta_key','dt_views_count');
                    $remove = false;
                    break;

                case 'ratings':
                    $this->delete('postmeta','meta_key','_starstruck_total');
                    $this->delete('postmeta','meta_key','_starstruck_avg');
                    $this->delete('postmeta','meta_key','_starstruck_data');
                    $remove = false;
                    break;

                case 'forcelicense':
                    update_option('dooplay_license_key_status','valid');
                    $remove = true;
                    break;
            }
        }
        update_option('_dooplay_database_tool_runs', $time );
        echo json_encode( array('response' => true, 'remove' => $remove, 'message' => __d('Just now')));
        wp_die();
    }




    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function set_options(){

        /* Converse Codestar Options
        -------------------------------------------------------------------------------
        */
        $converse_options = array(
            'iperpage' => 'posts_per_page'
        );

        foreach($converse_options as $csopt => $wpopt){
            $option_1 = cs_get_option($csopt);
            $option_2 = get_option($wpopt);
            if($option_1 !== $option_2){
                update_option($wpopt,$option_1);
            }
        }

        /* Data Base Options
        -------------------------------------------------------------------------------
        */
        if(empty(get_option('dooplay_database'))){
            update_option('dooplay_database', DOO_VERSION_DB);
            update_option('dooplay_update_linksmodule',true);
        }

        if(empty(get_option('dooplay_pages'))){
            update_option('dooplay_pages',false);
        }


        /* Slun Options
        -------------------------------------------------------------------------------
        */
        if(empty(get_option('dt_author_slug'))) {
        	update_option('dt_author_slug', 'profile');
        }

        if(empty(get_option('dt_movies_slug'))){
        	update_option('dt_movies_slug', 'movies');
        }

        if(empty(get_option('dt_requests_slug'))) {
        	update_option('dt_requests_slug', 'requests');
        }

        if(empty(get_option('dt_tvshows_slug'))){
        	update_option('dt_tvshows_slug', 'tvshows');
        }

        if(empty(get_option('dt_seasons_slug'))){
        	update_option('dt_seasons_slug', 'seasons');
        }

        if(empty(get_option('dt_episodes_slug'))){
        	update_option('dt_episodes_slug', 'episodes');
        }

        if(empty(get_option('dt_links_slug'))){
        	update_option('dt_links_slug', 'links');
        }

        if(empty(get_option('dt_genre_slug'))){
        	update_option('dt_genre_slug', 'genre');
        }

        if(empty(get_option('dt_release_slug'))){
        	update_option('dt_release_slug', 'release');
        }

        if(empty(get_option('dt_network_slug'))){
        	update_option('dt_network_slug', 'network');
        }

        if(empty(get_option('dt_studio_slug'))){
        	update_option('dt_studio_slug', 'studio');
        }

        if(empty(get_option('dt_cast_slug'))){
        	update_option('dt_cast_slug', 'cast');
        }

        if(empty(get_option('dt_creator_slug'))){
        	update_option('dt_creator_slug', 'creator');
        }

        if(empty(get_option('dt_director_slug'))){
        	update_option('dt_director_slug', 'director');
        }

        if(empty(get_option('dt_quality_slug'))){
        	update_option('dt_quality_slug', 'quality');
        }
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function cleaner(){

        global $wpdb;

        // Clean database
        $this->delete('postmeta', 'meta_key', 'status');
        $this->delete('postmeta', 'meta_key', '_user_liked');
        $this->delete('postmeta', 'meta_key', '_post_like_modified');
        $this->delete('postmeta', 'meta_key', '_post_like_count');
        $this->delete('usermeta', 'meta_key', $wpdb->base_prefix.'_user_like_count');

        // Get old config
        $oldnew = array(
            'dt_google_analytics'         => 'ganalytics',
            'dt_font_style'               => 'font',
            'dt_color_style'              => 'style',
            'color1'                      => 'maincolor',
            'color2'                      => 'bgcolor',
            'dt_custom_css'               => 'css',
            'dt_footer_copyright'         => 'footercopyright',
            'dt_footer_text'              => 'footertext',
            'dt_footer_tt1'               => 'footerc1',
            'dt_footer_tt2'               => 'footerc2',
            'dt_footer_tt3'               => 'footerc3',
            'dt_vplayer_timeout'          => 'playwait',
            'dt_jw_librarie'              => 'jwlibrary',
            'dt_jw_key'                   => 'jwkey',
            'dt_jw_abouttext'             => 'jwabout',
            'dt_jw_skinactive'            => 'jwcolor',
            'dt_welcome_mail_user'        => 'welcomemsg',
            'dt_app_id_facebook'          => 'fbappid',
            'dt_admin_facebook'           => 'fbadmin',
            'dt_app_language_facebook'    => 'fblang',
            'dt_scheme_color_facebook'    => 'fbscheme',
            'dt_number_comments_facebook' => 'fbnumber',
            'dt_ft_title'                 => 'featuredtitle',
            'dt_ft_number_items'          => 'featureditems',
            'dt_blo_title'                => 'blogtitle',
            'dt_blo_number_items'         => 'blogitems',
            'dt_slider_items'             => 'slideritems',
            'dt_slider_speed'             => 'sliderspeed',
            'dt_mm_title'                 => 'movietitle',
            'dt_mm_number_items'          => 'movieitems',
            'dt_topimdb_title'            => 'topimdbtitle',
            'dt_topimdb_number_items'     => 'topimdbitems',
            'dt_mt_title'                 => 'tvtitle',
            'dt_mt_number_items'          => 'tvitems',
            'dt_ms_title'                 => 'seasonstitle',
            'dt_ms_number_items'          => 'seasonsitems',
            'dt_me_title'                 => 'episodestitle',
            'dt_me_number_items'          => 'episodesitems',
            'dt_languages_post_link'      => 'linkslanguages',
            'dt_quality_post_link'        => 'linksquality',
            'dt_ountdown_link_redirect'   => 'linktimewait',
            'dt_alt_name'                 => 'seoname',
            'dt_main_keywords'            => 'seokeywords',
            'dt_metadescription'          => 'seodescription'
        );

        foreach ($oldnew as $old => $new) {
            $option = get_option($old);
            if($option){
                cs_set_option($new, $option);
            }
        }


        // Delete options
        $options = array(
            'dt_main_slider_items','dt_clear_database_time','dt_main_slider_speed','dt_main_slider_order','dt_main_slider_autoplay','dt_main_slider_radom',
            'dt_main_slider','dt_shorcode_home','dt_api_release_date','dt_api_upload_poster','dt_api_genres','dt_api_language',
            'dt_api_key','dt_activate_api','_site_register_in_dbmvs','dt_register_note','wp_app_dbmkey','minify_html_comments',
            'minify_html_active','dt_cleardb_date','dt_jw_skinbackground','dt_jw_skininactive','dt_jw_skinname','dt_jwplayer_page_gdrive',
            'dt_grprivate_key','dt_grpublic_key','dt_player_ads_300','dt_player_ads_time','dt_player_ads_hide_clic','dt_player_ads',
            'dt_player_views','dt_player_quality','dt_player_report','dt_player_luces','dt_google_analytics','posts_per_page_blog',
            'dt_posts_page','dt_account_page','dt_trending_page','dt_rating_page','dt_contact_page','dt_topimdb_page',
            'dt_top_imdb_items','dt_header_code','dt_footer_code','dt_play_trailer','dt_similiar_titles','dt_live_search',
            'dt_font_style','dt_color_style','color1','color2','dt_custom_css','dt_logo','ads_ss_1','ads_ss_2','ads_ss_3',
            'dt_favicon','dt_touch_icon','dt_logo_admin','dt_defaul_footer','dt_footer_copyright','dt_logo_footer',
            'dt_footer_text','dt_footer_tt1','dt_footer_tt2','dt_footer_tt3','dt_vplayer_autoload','dt_vplayer_width',
            'dt_vplayer_timeout','dt_vplayer_ads','dt_jw_librarie','dt_jwplayer_page','dt_jw_abouttext','dt_jw_skinactive',
            'dt_jw_logo','dt_jw_logo_position','dt_commets','dt_app_id_facebook','dt_admin_facebook','dt_app_language_facebook',
            'dt_scheme_color_facebook','dt_number_comments_facebook','dt_shortname_disqus','dt_home_sortable','dt_ft_title','dt_ft_number_items',
            'dt_featured_slider_ac','dt_blo_title','dt_blo_number_items','dt_blo_number_words','dt_slider_items','dt_slider_speed',
            'dt_slider_radom','dt_mm_title','dt_mm_number_items','dt_mm_activate_slider','dt_mt_title','dt_mt_number_items',
            'dt_mt_activate_slider','dt_ms_title','dt_ms_number_items','dt_me_title','dt_me_number_items','dt_topimdb_layout',
            'dt_topimdb_title','dt_topimdb_number_items','dt_activate_post_links','dt_languages_post_link','dt_quality_post_link','dt_ountdown_link_redirect',
            'dt_links_table_size','dt_links_table_added','dt_links_table_quality','dt_links_table_language','dt_links_table_user','dt_welcome_mail_user',
            'dt_site_titles','dt_alt_name','dt_main_keywords','dt_metadescription','dt_veri_google','dt_veri_alexa',
            'dt_veri_bing','dt_veri_yandex','ads_spot_home','ads_spot_300','ads_spot_468','ads_spot_single','ads_ss_4','dt_redirect_post_links',
            'dt_menu_framework_secion','dt_vplayer_autoplay_youtube','dt_vplayer_autoplay_jwplayer','dt_vplayer_autoplay','dt_remove_ver','dt_minify_html',
            'dt_minify_html_comments','dt_jw_key','dt_dynamic_bg','dt_register_user','dt_emoji_disable','dt_layout_full_width',
            'dt_autoplay_s','dt_autoplay_s_movies','dt_autoplay_s_tvshows','dt_mm_autoplay_slider','dt_mm_random_order','dt_featured_slider_ap',
            'dt_mt_autoplay_slider','dt_mt_random_order','dt_ms_autoplay_slider','dt_ms_random_order','dt_me_autoplay_slider','dt_me_random_order'
        );

        foreach ($options as $key) {
            delete_option($key);
        }

        // Update Option Pages
		update_option('dooplay_database', DOO_VERSION_DB );

        // Redirect page
		wp_redirect($_SERVER['HTTP_REFERER'], 301 ); exit;
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    private function delete($table, $row, $key){
        if($table && $row && $key){
            global $wpdb;
            $wpdb->delete($wpdb->prefix.$table, array($row => $key));
        }
    }

}

new DooDatabase;
