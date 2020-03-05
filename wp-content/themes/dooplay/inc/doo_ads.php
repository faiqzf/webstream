<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
**************
* @since 2.1.8
*/

if(!class_exists('DooAds')){
    class DooAds{

        /**
         * @since 2.1.8
         * @version 1.0
         */
        public function __construct(){
            add_action('admin_menu', array($this,'admin_menu'));
            add_action('wp_ajax_dooadmanage', array($this,'save_option'));
        }


        /**
         * @since 2.1.8
         * @version 1.0
         */
        public function admin_menu(){
            add_submenu_page(
                'themes.php',
                __d('DooPlay Ad banners'),
                __d('DooPlay Ad banners'),
                'manage_options',
                'dooplay-ad',
                array($this,'admin_page')
            );
        }


        /**
         * @since 2.1.8
         * @version 1.0
         */
        public function admin_page(){
            // Security nonce
            $nonce = wp_create_nonce('dooadsaveoptions');
            // Get Options
            $headcode = get_option('_dooplay_header_code');
            $footcode = get_option('_dooplay_footer_code');
            $adhomedk = get_option('_dooplay_adhome');
            $adhomemb = get_option('_dooplay_adhome_mobile');
            $adsingdk = get_option('_dooplay_adsingle');
            $adsingmb = get_option('_dooplay_adsingle_mobile');
            $adplaydk = get_option('_dooplay_adplayer');
            $adplaymb = get_option('_dooplay_adplayer_mobile');
            $adlinktd = get_option('_dooplay_adlinktop');
            $adlinktm = get_option('_dooplay_adlinktop_mobile');
            $adlinkbd = get_option('_dooplay_adlinkbottom');
            $adlinkbm = get_option('_dooplay_adlinkbottom_mobile');
            require_once(DOO_DIR.'/inc/parts/admin/ads_tool.php');
        }


        /**
         * @since 2.1.8
         * @version 1.0
         */
        public function save_option(){
            $nonce = doo_isset($_POST,'nonce');
            if(wp_verify_nonce($nonce,'dooadsaveoptions')){
                $options = array(
                    '_dooplay_header_code',
                    '_dooplay_footer_code',
                    '_dooplay_adhome',
                    '_dooplay_adhome_mobile',
                    '_dooplay_adsingle',
                    '_dooplay_adsingle_mobile',
                    '_dooplay_adplayer',
                    '_dooplay_adplayer_mobile',
                    '_dooplay_adlinktop',
                    '_dooplay_adlinktop_mobile',
                    '_dooplay_adlinkbottom',
                    '_dooplay_adlinkbottom_mobile',
                );
                foreach ($options as $key) {
                    if($value = doo_isset($_POST,$key)){
                        update_option($key, $value);
                    } else {
                        update_option($key, false);
                    }
                }
            }
            wp_die();
        }

        private function textarea($id, $value, $placeholder = false){
            echo "<textarea id='unique{$id}' name='{$id}' rows='5' class='code' placeholder='{$placeholder}'>".esc_textarea(stripslashes($value))."</textarea>";
        }
    }

    new DooAds;
}
