<?php
/*
Template Name: DT - Account page
*/


if(!current_user_can('subscriber') OR doo_is_true('permits','eusr') == true) {

    if(is_user_logged_in()):
    	get_template_part('pages/sections/account');
    else:
    	get_template_part('pages/sections/dt_head');
    	if(isset($_GET['action']) and $_GET['action'] =='sign-in'):
    		get_template_part('pages/sections/register');
    	else:
    		get_template_part('pages/sections/login');
    	endif;
    	get_template_part('pages/sections/dt_foot');
    endif;

} else {

    wp_die( __d('You do not have permission to access this page'), __d('Module disabled'));

}
