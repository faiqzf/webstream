
<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2019 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.2.6
*
*/
// Main Query
$episode_pagi = DDbmoviesHelpers::EpisodeNav($tmdbids,$temporad,$episode);
// Compose data
$prev_episode = doo_isset($episode_pagi,'prev');
$next_episode = doo_isset($episode_pagi,'next');
$tvshow_posts = doo_isset($episode_pagi,'tvsh');
// Compose Links
$link_prev = !empty($prev_episode) ? 'href="'.$prev_episode['permalink'].'" title="'.$prev_episode['title'].'"' : 'href="#" class="nonex"';
$link_next = !empty($next_episode) ? 'href="'.$next_episode['permalink'].'" title="'.$next_episode['title'].'"' : 'href="#" class="nonex"';
$link_tvsh = !empty($tvshow_posts) ? 'href="'.$tvshow_posts['permalink'].'" title="'.$tvshow_posts['title'].'"' : 'href="#" class="nonex"';
// View HTML
$out_html = "<div class='pag_episodes'>";
$out_html .= "<div class='item'>";
$out_html .= "<a {$link_prev}><i class='icon-chevron-left'></i> <span>".__d('previous episode')."</span></a>";
$out_html .= "</div><div class='item'>";
$out_html .= "<a {$link_tvsh}><i class='icon-bars'></i> <span>".__d('episodes list')."</span></a>";
$out_html .= "</div><div class='item'>";
$out_html .= "<a {$link_next}><span>".__d('next episode')."</span> <i class='icon-chevron-right'></i></a>";
$out_html .= "</div></div>";
// Echo And Filter Navigator
echo apply_filters('doo_episode_navigator', $out_html, $tmdbids.$temporad.$episode);
