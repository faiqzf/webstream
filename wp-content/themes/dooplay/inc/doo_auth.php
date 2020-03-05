<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
**************
* @since 2.2.3
*/

class DooAuth{

    /**
     * @since 2.2.2
     * @version 1.0
     */
    public function __construct(){
        // Log Out
        add_action('wp_ajax_dooplay_logout', array($this, 'Action_LogoutUser') );
		add_action('wp_ajax_nopriv_dooplay_logout', array($this, 'Action_LogoutUser'));

        // Login
        add_action('wp_ajax_dooplay_login', array($this, 'Action_LoginUser') );
		add_action('wp_ajax_nopriv_dooplay_login', array($this, 'Action_LoginUser'));

        // Register
        add_action('wp_ajax_dooplay_register', array($this, 'Action_RegisterUser'));
		add_action('wp_ajax_nopriv_dooplay_register', array($this, 'Action_RegisterUser'));
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    public function __destruct(){
		return false;
	}



    /**
     * @since 2.2.2
     * @version 1.0
     */
    public static function LoginForm(){
        $redirect = ( is_ssl() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $register = doo_compose_pagelink('pageaccount'). '?action=sign-in';
        $lostpassword = esc_url(site_url('wp-login.php?action=lostpassword','login_post'));
        require_once(DOO_DIR.'/inc/parts/login_form.php');
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    public function Action_LogoutUser(){
        wp_destroy_current_session();
        wp_clear_auth_cookie();
        $this->JsonHeader();
        echo json_encode(array('response' => true));
        wp_die();
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    public function Action_LoginUser(){
        $response = array();
        $username = doo_isset($_POST,'log');
        $password = doo_isset($_POST,'pwd');
        $redirect = doo_isset($_POST,'red');
        $remember = doo_isset($_POST,'rmb') ? true : false;
        $loginuser = $this->LoginUser($username, $password, $remember);
        if($loginuser){
            $response = array(
                'response' => true,
                'redirect' => esc_url($redirect),
                'message'  => __d('Welcome, reloading page')
            );
        }else{
            $response = array(
                'response' => false,
                'message'  => __d('Wrong username or password')
            );
        }
        // Compose response in Json
        $this->JsonHeader();
        echo json_encode($response);
        // End Action
        wp_die();
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    public function Action_RegisterUser(){
        $response = array();
        if($this->GooglereCAPTCHA() === true){
            $data = array(
                'username'  => doo_isset($_POST,'username'),
                'password'  => doo_isset($_POST,'spassword'),
                'firstname' => doo_isset($_POST,'firstname'),
                'lastname'  => doo_isset($_POST,'lastname'),
                'email'     => doo_isset($_POST,'email')
            );
            if(!doo_isset($data,'username'))
                $response = array('response' => false,'message' => __d('A username is required for registration'));
            elseif(username_exists(doo_isset($data,'username')))
                $response = array('response' => false,'message' => __d('Sorry, that username already exists'));
            elseif(!is_email(doo_isset($data,'email')))
                $response = array('response' => false,'message' => __d('You must enter a valid email address'));
            elseif(email_exists(doo_isset($data,'email')))
                $response = array('response' => false,'message' => __d('Sorry, that email address is already used'));
            elseif(!$this->RegisterUser($data))
                $response = array('response' => false,'message' => __d('Unknown error'));
            else{
                $this->LoginUser( doo_isset($data,'username'), doo_isset($data,'password'), true);
                $response = array('response' => true,'message' => __d('Registration completed successfully'), 'redirect' => doo_compose_pagelink('pageaccount'));
            }
        } else {
            $response = array('response' => false,'message' => __d('Google reCAPTCHA Error'));
        }
        // Compose response in Json
        $this->JsonHeader();
        echo json_encode($response);
        // End Action
        wp_die();
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    private function LoginUser($username, $password, $remember = true){
        $auth = array();
        $auth['user_login']    = $username;
        $auth['user_password'] = $password;
        $auth['remember']      = $remember;
        $login = wp_signon($auth, false);
        if(!is_wp_error($login)){
            return true;
        }else{
            return false;
        }
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    private function RegisterUser($data){
        if(is_array($data)){
            $new_user = array(
                'user_pass'  => doo_isset($data,'password'),
                'user_login' => esc_attr(doo_isset($data,'username')) ,
                'user_email' => esc_attr(doo_isset($data,'email')) ,
                'first_name' => doo_isset($data,'firstname'),
                'last_name'	 => doo_isset($data,'lastname'),
                'role'		 => 'subscriber',
            );
            return wp_insert_user($new_user);
        }
    }

    /**
     * @since 2.2.2
     * @version 1.0
     */
    private function GooglereCAPTCHA(){
        // Google data
        $sitekey = cs_get_option('gcaptchasitekey');
        $secretk = cs_get_option('gcaptchasecret');
        // Verify data
        if($sitekey && $secretk){
            $args = array(
                'secret'   => $secretk,
                'response' => doo_isset($_POST,'g-recaptcha-response')
            );
            $escurl = esc_url_raw(add_query_arg($args,'https://www.google.com/recaptcha/api/siteverify'));
            $remote = wp_remote_retrieve_body(wp_remote_get($escurl));
        	$gojson = json_decode($remote);

            // Google response
            return $gojson->success;

        } else {
            // Wildcard
            return true;
        }
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    private function ChangePasswordUser($user_id, $new_password){
        // soon..
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    private function ChangeEmailUser($user_id, $new_email){
        // soon..
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    private function NotifyLogin($user_id){
        // soon..
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    private function NotifyChanges($user_id, $notice_type){
        // soon..
    }


    /**
     * @since 2.2.3
     * @version 1.0
     */
    public static function DbmvServer(){
        // Compose formulate
        //** <+?p+h+p **//
        $output  = "Ly8qKiB7e1JFUFNUfX0gPT4gaHR0cHM6XC9"."cL2Ridm12cy5jb21cLyAqKi8vCi8vKioge3";
        $output .= "tTSVRFX0lTX0xPQ0FMfX0g"."KiovLwovLyoqID09PiB7e1NJVEVfVkFMSURBVEV9fSAqKi8v";
        $output .= "Ci8vKioge3tFTFNFX0lGX0xJVkVfU0lURX19ICoqLy8KLy8q"."KiA9PT4ge3tSRVNQT05TRX";
        $output .= "19ID09PiB7e1JFUFNUfX0gKyI/c"."2l0ZT0iKyB7e1NJVEVfUkVRVUlSRURfQVBJX0tFWX19";
        $output .= "ICoqLy8KLy8qKiB7e0lGX1JFU1BPTlNFfX0gPT09ICJ2Y"."WxpZCIgKiovLwovLyoqID09Pi";
        $output .= "BmYWxzZSAq i8vCi8vKioge3tFT"."FNFfX0gKiovLwovLyoqI"."D09PiBleGl0ICoqLy8=";
        //** ?+> **//
        // Filter formulate
        return apply_filters('doo_auth_validator', $output);
    }


    /**
     * @since 2.2.2
     * @version 1.0
     */
    private function JsonHeader(){
        header('Access-Control-Allow-Origin:*');
        header('Content-type: application/json');
    }
}

new DooAuth;
