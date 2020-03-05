<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2019 Doothemes. All rights reserved
* ----------------------------------------------------
* @since 2.2.6
*/


/**
 * @since 2.2.6
 * @version 1.0
 */
function dbmovies_get_poster($post_id = '', $thumb_size = 'dt_poster_a', $post_meta = 'dt_poster', $size = 'w185'){
    $thumb_id = get_post_thumbnail_id($post_id);
    $poster   = DOO_URI.'/assets/img/no/'.$post_meta.'.png';
    if($thumb_id){
        $thumb_url = wp_get_attachment_image_src($thumb_id, $thumb_size,true);
        $poster = isset($thumb_url[0]) ? $thumb_url[0] : false;
    }else{
        $image_meta = get_post_meta($post_id,$post_meta,true);
        if($image_meta && $image_meta != 'null'){
            if(substr($image_meta, 0, 1) == '/'){
                $poster = 'https://image.tmdb.org/t/p/'.$size.$image_meta;
            }elseif(filter_var($image_meta, FILTER_VALIDATE_URL)){
                $poster = $image_meta;
            }
        }
    }
    return esc_url($poster);
}



/**
 * @since 2.2.6
 * @version 1.0
 */
function dbmovies_get_backdrop($post_id = '', $size = 'w500'){
    $image_meta = get_post_meta($post_id,'dt_backdrop',true);
    $backdrop = DOO_URI.'/assets/img/no/dt_backdrop.png';
    if($image_meta && $image_meta != 'null'){
        if(substr($image_meta, 0, 1) == '/'){
            $backdrop = 'https://image.tmdb.org/t/p/'.$size.$image_meta;
        }elseif(filter_var($image_meta, FILTER_VALIDATE_URL)){
            $backdrop = $image_meta;
        }
    }
    return esc_url($backdrop);
}



/**
 * @since 2.2.6
 * @version 1.0
 */
function dbmovies_get_images($data = ''){
    if($data){
        $ititle = get_the_title();
        $images = explode("\n", $data);
        $icount = 0;
        $out_html = "<div id='dt_galery' class='galeria'>";
        foreach($images as $image) if($icount < 10){
            if(!empty($image)){
                if(substr($image, 0, 1) == '/'){
                    $out_html .= "<div class='g-item'>";
                    $out_html .= "<a href='https://image.tmdb.org/t/p/original{$image}' title='{$ititle}'>";
                    $out_html .= "<img src='https://image.tmdb.org/t/p/w300{$image}' alt='{$ititle}'>";
                    $out_html .= "</a></div>";
                }elseif(filter_var($image, FILTER_VALIDATE_URL)){
                    $out_html .= "<div class='g-item'>";
                    $out_html .= "<a href='{$image}' title='{$ititle}'>";
                    $out_html .= "<img src='{$image}' alt='{$ititle}'>";
                    $out_html .= "</a></div>";
                }
            }
            $icount++;
        }
        $out_html .= "</div>";
        // The View
        echo $out_html;
    }
}


/**
 * @since 2.2.6
 * @version 1.0
 */
function dbmovies_get_rand_image($data = ''){
    if($data){
        $urlimg = '';
        $images = explode("\n", $data);
        $icount = array_rand($images);
        if(!empty($images[$icount])){
            $image = $images[$icount];
        }else{
            $image = $images[0];
        }
        if(substr($image, 0, 1) == '/'){
            $urlimg = 'https://image.tmdb.org/t/p/original'.$image;
        }elseif(filter_var($image,FILTER_VALIDATE_URL)){
            $urlimg = $image;
        }
        if(!empty($urlimg)){
            return esc_url($urlimg);
        }
    }
}


/**
 * @since 2.2.6
 * @version 1.0
 */
function dbmovies_title_tags($option, $data){
    $option = str_replace('{name}', doo_isset($data,'name'),$option);
    $option = str_replace('{year}', doo_isset($data,'year'),$option);
    $option = str_replace('{season}', doo_isset($data,'season'),$option);
    $option = str_replace('{episode}', doo_isset($data,'episode'),$option);
    return apply_filters('dbmovies_title_tags',$option);
}


/**
 * @since 2.3
 * @version 1.0
 */
function dbmovies_clean_tile($tmdb){
    $files = glob(DBMOVIES_CACHE_DIR.'*.'.$tmdb);
    if(!empty($files)){
        foreach($files as $file){
            if(is_file($file)) unlink($file);
        }
    }
}


/**
 * @since 2.3
 * @version 1.0
 */
if(!function_exists('dbmovies_clean_tile_expired')){
    function dbmovies_clean_tile_expired(){
        foreach(glob(DBMOVIES_CACHE_DIR."*") as $file){
            if(is_file($file) && (filemtime($file) + DBMOVIES_CACHE_TIM <= time())) unlink($file);
        }
    }
    // Verificator
    if(!wp_next_scheduled('dbmovies_clean_cache_expires')) {
        wp_schedule_event(time(),'daily','dbmovies_clean_cache_expires');
    }
    // Schedule Action
    add_action('dbmovies_clean_cache_expires','dbmovies_clean_tile_expired');
}
