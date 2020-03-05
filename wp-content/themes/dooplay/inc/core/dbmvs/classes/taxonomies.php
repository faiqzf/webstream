<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/


class DDbmoviesTaxonomies extends DDbmoviesHelpers{

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){

        // All Taxonomies
        add_action('init', array(&$this,'Genres'), 0);
        add_action('init', array(&$this,'Quality'), 0);
        add_action('init', array(&$this,'Cast'), 0);
        add_action('init', array(&$this,'Director'), 0);
        add_action('init', array(&$this,'Creator'), 0);
        add_action('init', array(&$this,'Studio'), 0);
        add_action('init', array(&$this,'Network'), 0);
        add_action('init', array(&$this,'Year'), 0);
        // Support Tags
        add_action('pre_get_posts', array(&$this,'cpttags'));
        // Fixing
        add_action('after_switch_theme', array(&$this,'SwitchTheme'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Genres(){
        $taxonomy = array(
            'label'	  => __d('Genres'),
            'rewrite' => array(
                'slug' => get_option('dt_genre_slug','genre')
            ),
            'show_admin_column' => false,
            'hierarchical'		=> true,
            'show_in_rest'      => true
        );
        register_taxonomy('genres', array('tvshows','movies'), $taxonomy);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Quality(){
        $taxonomy = array(
            'label'	  => __d('Quality'),
            'rewrite' => array(
                'slug' => get_option('dt_quality_slug','quality')
            ),
            'show_admin_column' => false,
            'hierarchical'		=> true,
            'show_in_rest'      => true
        );
        register_taxonomy('dtquality', array('episodes','movies'), $taxonomy);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Cast(){
        $labels = array(
    		'name'          => __d('Cast'),
    		'singular_name' => __d('Cast'),
    		'menu_name'     => __d('Cast'),
    	);
    	$rewrite = array(
    		'slug'         => get_option('dt_cast_slug','cast'),
    		'with_front'   => true,
    		'hierarchical' => false,
    	);
    	$taxonomy = array(
    		'labels'            => $labels,
            'rewrite'           => $rewrite,
    		'hierarchical'      => false,
    		'public'            => true,
    		'show_ui'           => true,
            'show_in_rest'      => true,
    		'show_admin_column' => false,
    		'show_in_nav_menus' => false,
    		'show_tagcloud'     => true
    	);
    	register_taxonomy('dtcast', array('tvshows','movies'), $taxonomy);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Director(){
        $labels = array(
    		'name'          => __d('Director'),
    		'singular_name' => __d('Director'),
    		'menu_name'     => __d('Director'),
    	);
    	$rewrite = array(
    		'slug'         => get_option('dt_director_slug','director'),
    		'with_front'   => true,
    		'hierarchical' => false,
    	);
    	$taxonomy = array(
    		'labels'            => $labels,
            'rewrite'           => $rewrite,
    		'hierarchical'      => false,
    		'public'            => true,
    		'show_ui'           => true,
    		'show_admin_column' => false,
    		'show_in_nav_menus' => false,
            'show_in_rest'      => true,
    		'show_tagcloud'     => true
    	);
    	register_taxonomy('dtdirector', array('movies'), $taxonomy);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Creator(){
        $labels = array(
    		'name'          => __d('Creator'),
    		'singular_name' => __d('Creator'),
    		'menu_name'     => __d('Creator'),
    	);
    	$rewrite = array(
    		'slug'         => get_option('dt_creator_slug','creator'),
    		'with_front'   => true,
    		'hierarchical' => false,
    	);
    	$taxonomy = array(
    		'labels'            => $labels,
            'rewrite'           => $rewrite,
    		'hierarchical'      => false,
    		'public'            => true,
    		'show_ui'           => true,
            'show_in_rest'      => true,
    		'show_admin_column' => false,
    		'show_in_nav_menus' => false,
    		'show_tagcloud'     => true
    	);
    	register_taxonomy('dtcreator', array('tvshows'), $taxonomy);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Studio(){
        $labels = array(
    		'name'          => __d('Studio'),
    		'singular_name' => __d('Studio'),
    		'menu_name'     => __d('Studio'),
    	);
    	$rewrite = array(
    		'slug'         => get_option('dt_studio_slug','studio'),
    		'with_front'   => true,
    		'hierarchical' => false,
    	);
    	$taxonomy = array(
    		'labels'            => $labels,
            'rewrite'           => $rewrite,
    		'hierarchical'      => false,
    		'public'            => true,
    		'show_ui'           => true,
            'show_in_rest'      => true,
    		'show_admin_column' => false,
    		'show_in_nav_menus' => false,
    		'show_tagcloud'     => true
    	);
    	register_taxonomy('dtstudio', array('tvshows'), $taxonomy);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Network(){
        $labels = array(
    		'name'          => __d('Networks'),
    		'singular_name' => __d('Networks'),
    		'menu_name'     => __d('Networks'),
    	);
    	$rewrite = array(
    		'slug'         => get_option('dt_network_slug','network'),
    		'with_front'   => true,
    		'hierarchical' => false,
    	);
    	$taxonomy = array(
    		'labels'            => $labels,
            'rewrite'           => $rewrite,
    		'hierarchical'      => false,
    		'public'            => true,
    		'show_ui'           => true,
            'show_in_rest'      => true,
    		'show_admin_column' => false,
    		'show_in_nav_menus' => false,
    		'show_tagcloud'     => true
    	);
    	register_taxonomy('dtnetworks', array('tvshows'), $taxonomy);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function Year(){
        $labels = array(
    		'name'          => __d('Year'),
    		'singular_name' => __d('Year'),
    		'menu_name'     => __d('Year'),
    	);
    	$rewrite = array(
    		'slug'         => get_option('dt_release_slug','release'),
    		'with_front'   => true,
    		'hierarchical' => false,
    	);
    	$taxonomy = array(
    		'labels'            => $labels,
            'rewrite'           => $rewrite,
    		'hierarchical'      => false,
    		'public'            => true,
    		'show_ui'           => true,
            'show_in_rest'      => true,
    		'show_admin_column' => false,
    		'show_in_nav_menus' => false,
    		'show_tagcloud'     => true
    	);
    	register_taxonomy('dtyear', array('tvshows','movies'), $taxonomy);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function cpttags($query){
        if($query->is_tag() && $query->is_main_query()) {
            $query->set('post_type', array('movies','tvshows'));
        }
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function SwitchTheme(){
        flush_rewrite_rules();
    }
}

new DDbmoviesTaxonomies;
