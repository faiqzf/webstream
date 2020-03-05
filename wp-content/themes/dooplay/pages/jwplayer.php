<?php
/* ----------------------------------------------------
* Template Name: DT - jwplayer
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.1.9
*
*/

// Libraries and dynamic data
$google = new DooGdrive;
$source = urldecode(doo_isset($_GET,'source'));
$typeso = doo_isset($_GET,'type');
$postid = doo_isset($_GET,'id');
$images = get_post_meta($postid,'imagenes', true);
$jwpkey = cs_get_option('jwkey','IMtAJf5X9E17C1gol8B45QJL5vWOCxYUDyznpA==');
$jw8key = cs_get_option('jw8key','64HPbvSQorQcd52B8XFuhMtEoitbvY/EXJmMBfKcXZQU2Rnn');
$libray = cs_get_option('player','plyr');
$mp4fle = ($typeso == 'gdrive') ? $google->GetUrl($source) : $source;
$prvimg = dbmovies_get_rand_image($images);
$plyrcl = cs_get_option('playercolor','#0b7ef4');

// Compose data for Json
$data = array(
    'file'  => $mp4fle,
    'image' => $prvimg,
    'color' => $plyrcl,
    'link'  => esc_url(home_url()),
    'logo'  => doo_compose_image_option('jwlogo'),
    'auto'  => doo_is_true('playauto','jwp') ? 'true' : 'false',
    'text'  => cs_get_option('jwabout','DooPlay Theme WordPress'),
    'lposi' => cs_get_option('jwposition','top-right'),
    'flash' =>  DOO_URI.'/assets/jwplayer/jwplayer.flash.swf'
);

// Render JW Player
require_once(DOO_DIR.'/pages/sections/'.$libray.'.php');
