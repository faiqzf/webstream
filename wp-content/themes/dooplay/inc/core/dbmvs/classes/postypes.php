<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/


class DDbmoviesPosTypes extends DDbmoviesHelpers{


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
        add_action('init', array(&$this,'movies'), 0);
        add_action('init', array(&$this,'tvshows'), 0);
        add_action('init', array(&$this,'seasons'), 0);
        add_action('init', array(&$this,'episodes'), 0);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function movies(){

        $labels = array(
			'name'           => __d('Movies'),
			'singular_name'  => __d('Movie'),
			'menu_name'      => __d('Movies'),
			'name_admin_bar' => __d('Movies'),
			'all_items'      => __d('Movies')
		);

        $rewrite = array(
			'slug'       => get_option('dt_movies_slug','movies'),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true
		);

		$type_args = array(
            'labels'              => $labels,
            'rewrite'             => $rewrite,
			'label'               => __d('Movies'),
			'description'         => __d('Movies manage'),
			'supports'            => array('title', 'editor','comments','thumbnail','author'),
			'taxonomies'          => array('genres','dtquality','post_tag'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
            'show_in_rest'        => false,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-editor-video',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post'
		);
		register_post_type('movies', $type_args);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function tvshows(){

        $labels = array(
            'name'           => __d('TV Shows'),
			'singular_name'  => __d('TV Shows'),
			'menu_name'      => __d('TV Shows'),
			'name_admin_bar' => __d('TV Shows'),
			'all_items'      => __d('TV Shows')
		);

        $rewrite = array(
			'slug'       => get_option('dt_tvshows_slug','tvshows'),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true
		);

		$type_args = array(
            'labels'              => $labels,
            'rewrite'             => $rewrite,
			'label'               => __d('TV Show'),
			'description'         => __d('TV series manage'),
			'supports'            => array('title', 'editor','comments','thumbnail','author'),
			'taxonomies'          => array('genres','post_tag'),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
            'show_in_rest'        => false,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-welcome-view-site',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post'
		);
		register_post_type('tvshows', $type_args);
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function seasons(){

        $labels = array(
            'name'           => __d('Seasons'),
			'singular_name'  => __d('Seasons'),
			'menu_name'      => __d('Seasons'),
			'name_admin_bar' => __d('Seasons'),
			'all_items'      => __d('Seasons')
		);

        $rewrite = array(
			'slug'       => get_option('dt_seasons_slug','seasons'),
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$type_args = array(
            'labels'              => $labels,
            'rewrite'             => $rewrite,
			'label'               => __d('Seasons'),
			'description'         => __d('Seasons manage'),
			'supports'            => array('title', 'editor','comments','thumbnail','author'),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
            'show_in_rest'        => false,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_menu'        => 'edit.php?post_type=tvshows',
			'menu_position'       => 20,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type('seasons', $type_args);
    }



    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function episodes(){

        $labels = array(
            'name'           => __d('Episodes'),
			'singular_name'  => __d('Episodes'),
			'menu_name'      => __d('Episodes'),
			'name_admin_bar' => __d('Episodes'),
			'all_items'      => __d('Episodes')
    	);

        $rewrite = array(
    		'slug'       => get_option('dt_episodes_slug','episodes'),
    		'with_front' => true,
    		'pages'      => true,
    		'feeds'      => true,
    	);

    	$type_args = array(
            'labels'              => $labels,
            'rewrite'             => $rewrite,
    		'label'               => __d('Episodes'),
    		'description'         => __d('Episodes manage'),
    		'supports'            => array('title', 'editor','comments','thumbnail','author'),
    		'taxonomies'          => array('dtquality'),
    		'hierarchical'        => false,
    		'public'              => true,
    		'show_ui'             => true,
            'show_in_rest'        => false,
    		'show_in_menu'        => true,
    		'menu_position'       => 5,
    		'show_in_menu'        => 'edit.php?post_type=tvshows',
    		'menu_position'       => 20,
    		'show_in_nav_menus'   => false,
    		'can_export'          => true,
    		'has_archive'         => true,
    		'exclude_from_search' => true,
    		'publicly_queryable'  => true,
    		'capability_type'     => 'post',
    	);
    	register_post_type('episodes', $type_args);
    }
}

new DDbmoviesPosTypes;
