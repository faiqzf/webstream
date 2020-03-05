<?php
/**
 * @author Doothemes (Erick Meza & Brendha Mayuri)
 * @since 2.2.6
 */

// Main Data
$itmdb = get_post_meta($post->ID,'ids',true);
$seaso = get_post_meta($post->ID,'temporada',true);
/*=====================================================*/
$query = DDbmoviesHelpers::GetAllEpisodes($itmdb,$seaso);
/*=====================================================*/
// Start Query
$html_out = "<div id='serie_contenido' style='padding-top:0'>";
$html_out .= "<div id='seasons'><div class='se-c'><div class='se-a' style='display:block'><ul class='episodios'>";
if($query && is_array($query)){
    foreach($query as $post_id){
        // Post Data
        $image = dbmovies_get_poster($post_id,'dt_episode_a','dt_backdrop','w154');
        $title = get_post_meta($post_id,'episode_name', true);
        $episo = get_post_meta($post_id,'episodio', true);
        $edate = get_post_meta($post_id,'air_date', true);
        $edate = doo_date_compose($edate, false);
        $plink = get_permalink($post_id);
        // The View
        $html_out .= "<li class='mark-{$episo}'>";
        $html_out .= "<div class='imagen'><img src='{$image}'></div>";
        if($seaso !== '0'){
            $html_out .= "<div class='numerando'>{$seaso} - {$episo}</div>";
        } else{
            $html_out .= "<div class='numerando'><i class='icon-star'></i> - {$episo}</div>";
        }
        $html_out .= "<div class='episodiotitle'><a href='{$plink}'>{$title}</a> <span class='date'>{$edate}</span></div>";
        $html_out .= "</li>";
    }
}else{
    $html_out .= "<li class='none'>".__d('There are still no episodes this season')."</li>";
}
$html_out .= "</ul></div></div></div></div>";
// Compose viewer HTML
echo apply_filters('dooplay_list_seasons', $html_out, $itmdb);
