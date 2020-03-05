<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/

class DDbmoviesMetaboxes extends DDbmoviesHelpers{

    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function __construct(){
        add_action('add_meta_boxes',array(&$this,'metaboxes'));
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function metaboxes(){
        add_meta_box('dt_metabox',__d('Movie Info'),array(&$this,'meta_movies'),'movies','normal','high');
        add_meta_box('dt_metabox',__d('TVShow Info'),array(&$this,'meta_tvshows'),'tvshows','normal','high');
        add_meta_box('dt_metabox',__d('Season Info'),array(&$this,'meta_seasons'),'seasons','normal','high');
        add_meta_box('dt_metabox',__d('Episode Info'),array(&$this,'meta_episodes'),'episodes','normal','high');
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function meta_movies(){
        // Nonce security
	    wp_nonce_field('_movie_nonce', 'movie_nonce');
		// Metabox options
		$options = array(
	        array(
	            'id'            => 'ids',
				'id2'		    => null,
				'id3'		    => null,
	            'type'          => 'generator',
	            'style'         => 'style="background: #f7f7f7"',
	            'class'         => 'regular-text',
	            'placeholder'   => 'tt2911666',
	            'label'         => __d('Generate data'),
	            'desc'          => __d('Generate data from <strong>imdb.com</strong>'),
	            'fdesc'         => __d('E.g. http://www.imdb.com/title/<strong>tt2911666</strong>/'),
                'requireupdate' => true,
                'previewpost'   => false
	        ),
	        array(
	            'id'     => 'dt_featured_post',
	            'type'   => 'checkbox',
	            'label'  => __d('Featured Title'),
	            'clabel' => __d('Do you want to mark this title as a featured item?')
	        ),
	        array(
	            'type'    => 'heading',
	            'colspan' => 2,
	            'text'    => __d('Images and trailer')
	        ),
	        array(
	            'id'    => 'dt_poster',
	            'type'  => 'upload',
	            'label' => __d('Poster'),
	            'desc'  => __d('Add url image'),
	            'aid'   => 'up_images_poster',
	            'ajax'  => false
	        ),
	        array(
	            'id'      => 'dt_backdrop',
	            'type'    => 'upload',
	            'label'   => __d('Main Backdrop'),
	            'desc'    => __d('Add url image'),
	            'aid'     => 'up_images_backdrop',
	            'prelink' => 'https://image.tmdb.org/t/p/w500',
	            'ajax'    => true
	        ),
	        array(
	            'id'     => 'imagenes',
	            'type'   => 'textarea',
	            'rows'   => 5,
	            'upload' => true,
	            'aid'    => 'up_images_images',
	            'label'  => __d('Backdrops'),
	            'desc'   => __d('Place each image url below another')
	        ),
	        array(
	            'id'    => 'youtube_id',
	            'type'  => 'text',
	            'class' => 'small-text',
	            'label' => __d('Video trailer'),
	            'desc'  => __d('Add id Youtube video'),
	            'fdesc' => '[id_video_youtube]',
				'double' => null,
	        ),
	        array(
	            'type'    => 'heading',
	            'colspan' => 2,
	            'text'    => __d('IMDb.com data')
	        ),
	        array(
	            'double' => true,
	            'id'     => 'imdbRating',
	            'id2'    => 'imdbVotes',
	            'type'   => 'text',
	            'label'  => __d('Rating IMDb'),
	            'desc'   => __d('Average / votes')
	        ),
	        array(
	            'id'    => 'Rated',
	            'type'  => 'text',
	            'class' => 'small-text',
				'double' => null,
				'fdesc'	=> null,
	            'label' => __d('Rated')
	        ),
	        array(
	            'id'    => 'Country',
	            'type'  => 'text',
	            'class' => 'small-text',
				'fdesc'	=> null,
				'desc'	=> null,
				'double' => null,
	            'label' => __d('Country')
	        ),
	        array(
	            'type'    => 'heading',
	            'colspan' => 2,
	            'text' => __d('Themoviedb.org data')
	        ),
	        array(
	            'id'    => 'idtmdb',
	            'type'  => 'text',
	            'class' => 'small-text',
				'fdesc'	=> null,
				'desc'	=> null,
				'double' => null,
				'class' => null,
	            'label' => __d('ID TMDb')
	        ),
	        array(
	            'id'    => 'original_title',
	            'type'  => 'text',
	            'class' => 'small-text',
				'fdesc'	=> null,
				'double' => null,
				'class' => null,
				'desc' => null,
	            'label' => __d('Original title')
	        ),
	        array(
	            'id'    => 'tagline',
	            'type'  => 'text',
	            'class' => 'small-text',
				'fdesc'	=> null,
				'double' => null,
				'desc' => null,
	            'label' => __d('Tag line')
	        ),
	        array(
	            'id'    => 'release_date',
	            'type'  => 'date',
	            'label' => __d('Release Date')
	        ),
	        array(
	            'double' => true,
	            'id'     => 'vote_average',
	            'id2'    => 'vote_count',
	            'type'   => 'text',
	            'label'  => __d('Rating TMDb'),
	            'desc'   => __d('Average / votes')
	        ),
	        array(
	            'id'    => 'runtime',
	            'type'  => 'text',
	            'class' => 'small-text',
	            'label' => __d('Runtime')
	        ),
	        array(
	            'id' => 'dt_cast',
	            'type' => 'textarea',
	            'rows' => 5,
				'upload' => false,
	            'label' => __d('Cast')
	        ),
	        array(
	            'id'    => 'dt_dir',
	            'type'  => 'text',
	            'label' => __d('Director')
	        )
	    );
	    $this->ViewMeta($options);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function meta_tvshows(){
        // Nonce security
	    wp_nonce_field('_tvshows_nonce', 'tvshows_nonce');
		// Metabox options
	    $options = array(
	        array(
	            'id'            => 'ids',
	            'type'          => 'generator',
	            'style'         => 'style="background: #f7f7f7"',
	            'class'         => 'regular-text',
	            'placeholder'   => '1402',
	            'label'         => __d('Generate data'),
	            'desc'          => __d('Generate data from <strong>themoviedb.org</strong>'),
	            'fdesc'         => __d('E.g. https://www.themoviedb.org/tv/<strong>1402</strong>-the-walking-dead'),
                'requireupdate' => true,
                'previewpost'   => false
	        ),
	        array(
	            'id'     => 'clgnrt',
	            'type'   => 'checkbox',
	            'label'  => __d('Seasons control'),
	            'clabel' => __d('I have generated seasons or I will manually')
	        ),
	        array(
	            'id'     => 'dt_featured_post',
	            'type'   => 'checkbox',
	            'label'  => __d('Featured Title'),
	            'clabel' => __d('Do you want to mark this title as a featured item?')
	        ),
	        array(
	            'type'    => 'heading',
	            'colspan' => 2,
	            'text'    => __d('Images and trailer')
	        ),
	        array(
	            'id'    => 'dt_poster',
	            'type'  => 'upload',
	            'label' => __d('Poster'),
	            'desc'  => __d('Add url image'),
	            'aid'   => 'up_images_poster',
	            'ajax'  => false
	        ),
	        array(
	            'id'      => 'dt_backdrop',
	            'type'    => 'upload',
	            'label'   => __d('Main Backdrop'),
	            'desc'    => __d('Add url image'),
	            'aid'     => 'up_images_backdrop',
	            'prelink' => 'https://image.tmdb.org/t/p/w500',
	            'ajax'    => true
	        ),
	        array(
	            'id'     => 'imagenes',
	            'type'   => 'textarea',
	            'rows'   => 5,
	            'upload' => true,
	            'aid'    => 'up_images_images',
	            'label'  => __d('Backdrops'),
	            'desc'   => __d('Place each image url below another')
	        ),
	        array(
	            'id'    => 'youtube_id',
	            'type'  => 'text',
	            'class' => 'small-text',
	            'label' => __d('Video trailer'),
	            'desc'  => __d('Add id Youtube video'),
	            'fdesc' => '[id_video_youtube]'
	        ),
	        array(
	            'type'    => 'heading',
	            'colspan' => 2,
	            'text'    => __d('More data')
	        ),
	        array(
	            'id'    => 'original_name',
	            'type'  => 'text',
	            'class' => 'small-text',
	            'label' => __d('Original Name')
	        ),
	        array(
	            'id'    => 'first_air_date',
	            'type'  => 'date',
	            'label' => __d('Firt air date')
	        ),
	        array(
	            'id'    => 'last_air_date',
	            'type'  => 'date',
	            'label' => __d('Last air date')
	        ),
	        array(
	            'double' => true,
	            'id'     => 'number_of_seasons',
	            'id2'    => 'number_of_episodes',
	            'type'   => 'text',
	            'label'  => __d('Content total posted'),
	            'desc'   => __d('Seasons / Episodes')
	        ),
	        array(
	            'double' => true,
	            'id'     => 'imdbRating',
	            'id2'    => 'imdbVotes',
	            'type'   => 'text',
	            'label'  => __d('Rating TMDb'),
	            'desc'   => __d('Average / votes')
	        ),
	        array(
	            'id'    => 'episode_run_time',
	            'type'  => 'text',
	            'class' => 'small-text',
	            'label' => __d('Episode runtime')
	        ),
	        array(
	            'id' => 'dt_cast',
	            'type' => 'textarea',
	            'rows' => 5,
	            'label' => __d('Cast')
	        ),
	        array(
	            'id'    => 'dt_creator',
	            'type'  => 'text',
	            'label' => __d('Creator')
	        )
	    );
	    $this->ViewMeta($options);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function meta_seasons(){
        // Nonce security
	    wp_nonce_field('_seasons_nonce', 'seasons_nonce');
	    // Metabox options
	    $options = array(
	        array(
	            'id'           => 'ids',
	            'id2'          => 'temporada',
	            'type'         => 'generator',
	            'style'        => 'style="background: #f7f7f7"',
	            'class'        => 'extra-small-text',
	            'placeholder'  => '1402',
	            'placeholder2' => '1',
	            'label'        => __d('Generate data'),
	            'desc'         => __d('Generate data from <strong>themoviedb.org</strong>'),
	            'fdesc'        => __d('E.g. https://www.themoviedb.org/tv/<strong>1402</strong>-the-walking-dead/season/<strong>1</strong>/'),
                'requireupdate' => true,
                'previewpost'   => $this->get_option('nospostimp')
	        ),
	        array(
	            'id'     => 'clgnrt',
	            'type'   => 'checkbox',
	            'label'  => __d('Episodes control'),
	            'clabel' => __d('I generated episodes or add manually')
	        ),
	        array(
	            'id'    => 'serie',
	            'type'  => 'text',
	            'class' => 'regular-text',
	            'label' => __d('Serie name')
	        ),
	        array(
	            'id'    => 'dt_poster',
	            'type'  => 'upload',
	            'label' => __d('Poster'),
	            'desc'  => __d('Add url image'),
	            'aid'   => 'up_images_poster',
	            'ajax'  => false
	        ),
	        array(
	            'id'    => 'air_date',
	            'type'  => 'date',
	            'label' => __d('Air date')
	        )
	    );
	    $this->ViewMeta($options);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    public function meta_episodes(){
        // Nonce security
	    wp_nonce_field('_episodios_nonce','episodios_nonce');
	    // Metabox options
	    $options = array(
	        array(
	            'id'           => 'ids',
	            'id2'          => 'temporada',
	            'id3'          => 'episodio',
	            'type'         => 'generator',
	            'style'        => 'style="background: #f7f7f7"',
	            'class'        => 'extra-small-text',
	            'placeholder'  => '1402',
	            'placeholder2' => '1',
	            'placeholder3' => '2',
	            'label'        => __d('Generate data'),
	            'desc'         => __d('Generate data from <strong>themoviedb.org</strong>'),
	            'fdesc'        => __d('E.g. https://www.themoviedb.org/tv/<strong>1402</strong>-the-walking-dead/season/<strong>1</strong>/episode/<strong>2</strong>'),
                'requireupdate' => true,
                'previewpost'   => $this->get_option('nospostimp')
	        ),
	        array(
	            'id'    => 'episode_name',
	            'type'  => 'text',
	            'class' => 'regular-text',
	            'label' => __d('Episode title')
	        ),
	        array(
	            'id'    => 'serie',
	            'type'  => 'text',
	            'class' => 'regular-text',
	            'label' => __d('Serie name')
	        ),
	        array(
	            'id'      => 'dt_backdrop',
	            'type'    => 'upload',
	            'label'   => __d('Main Backdrop'),
	            'desc'    => __d('Add url image'),
	            'aid'     => 'up_images_backdrop',
	            'prelink' => 'https://image.tmdb.org/t/p/w500',
	            'ajax'    => false
	        ),
	        array(
	            'id'     => 'imagenes',
	            'type'   => 'textarea',
	            'rows'   => 5,
	            'upload' => true,
	            'aid'    => 'up_images_images',
	            'label'  => __d('Backdrops'),
	            'desc'   => __d('Place each image url below another')
	        ),
	        array(
	            'id'    => 'air_date',
	            'type'  => 'date',
	            'label' => __d('Air date')
	        )
	    );
	    $this->ViewMeta($options);
    }


    /**
     * @since 2.2.6
     * @version 1.0
     */
    private function ViewMeta($options){
        echo '<div id="loading_api"></div>';
	    echo '<div id="api_table"><table class="options-table-responsive dt-options-table"><tbody>';
		new Doofields($options);
	    echo '</tbody></table></div>';
    }
}

new DDbmoviesMetaboxes;
