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
$stus = get_post_status();
$atho = get_the_author_meta('nickname');
$gtpl = get_the_permalink($psid);
$prid = wp_get_post_parent_id($psid);
$ptit = get_the_title($prid);
$pprl = get_the_permalink($prid);
$murl = get_post_meta($psid,'_dool_url',true);
$type = get_post_meta($psid,'_dool_type',true);
$viws = get_post_meta($psid,'dt_views_count',true);
$date = human_time_diff(get_the_time('U',$psid), current_time('timestamp',$psid));
$viws = ($viws) ? $viws : '0';
$fico = ($type == __d('Torrent')) ? 'utorrent.com' : doo_compose_domainname($murl);
$domn = ($type == __d('Torrent')) ? 'Torrent' : doo_compose_domainname($murl);
$fico = '<img src="'.DOO_GICO.$fico.'" />';

// Compose View
$out  = "<tr id='adm-{$psid}'>";
$out .= "<td><a href='{$murl}' target='_blank'>{$fico} {$domn}</a></td>";
$out .= "<td><a href='{$pprl}' target='_blank'>{$ptit}</a></td>";
$out .= "<td>{$atho}</td>";
$out .= "<td class='views'>{$viws}</td>";
$out .= "<td class='metas status {$stus}'><i class='icon'></i></td>";
$out .= "<td class='status'>";
$out .= "<a href='#' class='edit_link' data-id='{$psid}'>".__d('Edit')."</a>";
if(current_user_can('administrator')){
    if($stus == 'publish'){
        $out .= " / <a href='#' class='control_admin_link' data-id='{$psid}' data-status='pending'>".__d('Disable')."</a> /";
    } else {
        $out .= " / <a href='#' class='control_admin_link' data-id='{$psid}' data-status='publish'>".__d('Enable')."</a> / ";
    }
    $out .= "<a href='#' class='control_admin_link' data-id='{$psid}' data-status='trash'>".__d('Delete')."</a>";
}
$out .= "</td></tr>";

// The view
echo $out;
