<?php
/*
* -------------------------------------------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @aopyright: (c) 2018 Doothemes. All rights reserved
* -------------------------------------------------------------------------------------
*
* @since 2.1.8
*
*/

// Link all data
$psid = $post->ID;
$gtpl = get_the_permalink($psid);
$prid = wp_get_post_parent_id($psid);
$ptit = get_the_title($prid);
$pprl = get_the_permalink($prid);
$murl = get_post_meta($psid, '_dool_url', true);
$type = get_post_meta($psid, '_dool_type', true);
$lang = get_post_meta($psid, '_dool_lang', true);
$qual = get_post_meta($psid, '_dool_quality', true);
$viws = get_post_meta($psid, 'dt_views_count', true);
$date = human_time_diff(get_the_time('U',$psid), current_time('timestamp',$psid));
$viws = ($viws) ? $viws : '0';
$fico = ($type == __d('Torrent')) ? 'utorrent.com' : doo_compose_domainname($murl);
$domn = ($type == __d('Torrent')) ? 'Torrent' : doo_compose_domainname($murl);
$fico = '<img src="'.DOO_GICO.$fico.'" />';

// Compose View
$out  = "<tr id='{$psid}'>";
$out .= "<td><strong>{$type}</strong></td>";
$out .= "<td><a href='{$gtpl}' target='_blank'>{$fico} {$domn}</a></td>";
$out .= "<td><a href='{$pprl}' target='_blank'>{$ptit}</a>";
$out .= "<td class='views'>{$viws}</td>";
$out .= "<td class='views'><strong class='quality'>{$qual}</strong></td>";
$out .= "<td class='views'>{$lang}</td>";
$out .= "<td class='views'>{$date}</td>";
$out .= "</tr>";

// The view
echo $out;
