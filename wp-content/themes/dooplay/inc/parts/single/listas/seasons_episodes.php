<?php
/**
 * @author Doothemes (Erick Meza & Brendha Mayuri)
 * @since 2.2.6
 */

// Main data
$tmdb = get_post_meta($post->ID,'ids',true);
$ctrl = get_post_meta($post->ID,'clgnrt',true);
/*=====================================================*/
$query_seasons = DDbmoviesHelpers::GetAllSeasons($tmdb);
/*=====================================================*/
// Start Query
if($query_seasons && is_array($query_seasons) && $ctrl == true){
    $html_out = "<div id='episodes' class='sbox fixidtab'>";
    $html_out .="<h2>".__d('Seasons and episodes')."</h2>";
    $html_out .="<div id='serie_contenido'><div id='seasons'>";
    $numb = 0;
    foreach($query_seasons as $season){
        $senumb = get_post_meta($season,'temporada', true);
        $aidate = get_post_meta($season,'air_date', true);
        $rating = get_post_meta($season,'_starstruck_avg', true);
        /*=====================================================*/
        $query_episodes = DDbmoviesHelpers::GetAllEpisodes($tmdb,$senumb);
        /*=====================================================*/
        $mnseo = $numb == 0 ? ' se-o' : false;
        $dsply = $numb == 0 ? ' style="display:block"' : false;
        $title = $senumb == '0' ? __d('Specials') : sprintf( __d('Season %s %s'), $senumb, '<i>'.doo_date_compose($aidate, false).'</i>');
        $nseas = $senumb == '0' ? '<i class="icon-star"></i>' : $senumb;
        // Continue View HTML
        $html_out .="<div class='se-c'>";
        $html_out .="<div class='se-q'>";
        $html_out .="<span class='se-t{$mnseo}'>{$senumb}</span>";
        $html_out .="<span class='title'>{$title}";
        if($rating >= '1'){
            $html_out .="<div class='se_rating'>{$rating}</div>";
        }
        $html_out .="</span></div>";
        $html_out .="<div class='se-a'{$dsply}><ul class='episodios'>";
        if($query_episodes && is_array($query_episodes)){
            foreach($query_episodes as $episode){
                // Post Data
                $image = dbmovies_get_poster($episode,'dt_episode_a','dt_backdrop','w154');
                $title = get_post_meta($episode,'episode_name', true);
                $episo = get_post_meta($episode,'episodio', true);
                $edate = get_post_meta($episode,'air_date', true);
                $edate = doo_date_compose($edate, false);
                $plink = get_permalink($episode);
                // The View
                $html_out .= "<li class='mark-{$episo}'>";
                $html_out .= "<div class='imagen'><img src='{$image}'></div>";
                if($senumb !== '0'){
                    $html_out .= "<div class='numerando'>{$senumb} - {$episo}</div>";
                } else{
                    $html_out .= "<div class='numerando'><i class='icon-star'></i> - {$episo}</div>";
                }
                $html_out .= "<div class='episodiotitle'><a href='{$plink}'>{$title}</a> <span class='date'>{$edate}</span></div>";
                $html_out .= "</li>";
            }
        } else{
            $html_out .= "<li class='none'>".__d('There are still no episodes this season')."</li>";
        }
        $html_out .="</ul></div></div>";
        $numb++;
    }
    $html_out .="</div></div></div>";
    echo apply_filters('dooplay_list_seasons_episodes', $html_out, $tmdb);
}
