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


class DooPlayCache{


    /**
     * @since 2.1.8
     * @version 1.0
     */
    private $path;
    private $time;
    private $extn;
    private $blog;
    private $sche;


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function __construct(){
        // Cache data
        $this->path = WP_CONTENT_DIR.'/cache/dooplay/';
        $this->extn = '.cache';
        $this->time = cs_get_option('cachetime', 86400 );
        $this->sche = cs_get_option('cachescheduler','daily');
        $this->blog = get_current_blog_id();
        // Verify cache folder
        if(!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
        // Admin menu and actions..
        if(current_user_can('manage_options')){
            add_action('admin_bar_menu', array($this,'menu'), 99);
            add_action('wp_ajax_dooplay_cache', array($this,'ajax'));
        	add_action('wp_ajax_nopriv_dooplay_cache', array($this,'ajax'));
        }
        // Schedule Event
        if(!wp_next_scheduled('dooplay_clean_cache_expires')) {
            wp_schedule_event(time(), $this->sche,'dooplay_clean_cache_expires');
        }
        // Schedule Action
        add_action('dooplay_clean_cache_expires',array($this,'delete_expired'));
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function __destruct(){
        return true;
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function ajax(){
        $delet = doo_isset($_GET,'delete');
        $nonce = doo_isset($_GET,'nonce');
        $posti = doo_isset($_GET,'pid');
        if($nonce && wp_verify_nonce($nonce,'dooplay_cache_nonce')){
            $gdrive = new DooGdrive;
            switch ($delet) {
                case 'expired':
                    $gdrive->DeleteExpired();
                    $this->delete_expired();
                    break;

                case 'all':
                    $gdrive->DeleteAll();
                    $this->delete_all();
                    break;

                case 'post':
                    $this->delete($posti.'_postmeta');
                    break;
            }
        }
        wp_redirect(esc_url(doo_isset($_SERVER,'HTTP_REFERER')),302);
        exit;
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public static function menu(){
        global $wp_admin_bar, $post;
        $menus[] = array(
           'id'    => 'dooplay',
           'title' => __d('Dooplay options'),
           'href' => admin_url('themes.php?page=dooplay'),
           'meta' => array(
     	        'class'  => 'dt_dooplay_menu'
            )
        );
        if(is_single()){
            $menus[] = array(
                'id' => 'delete-post-cache',
                'parent' => 'dooplay',
                'title'  => __d('Delete cache this Entry'),
                'href'   => admin_url('admin-ajax.php?action=dooplay_cache&delete=post&pid='.$post->ID.'&nonce='.wp_create_nonce('dooplay_cache_nonce'))
            );
        }
     	$menus[] = array(
           'id'     => 'cache-expired',
           'parent' => 'dooplay',
           'title'  => __d('Delete cache expired'),
           'href'   => admin_url('admin-ajax.php?action=dooplay_cache&delete=expired&nonce='.wp_create_nonce('dooplay_cache_nonce'))
        );
        $menus[] = array(
           'id'     => 'delete-all-cache',
           'parent' => 'dooplay',
           'title'  => __d('Delete all cache'),
           'href'   => admin_url('admin-ajax.php?action=dooplay_cache&delete=all&nonce='.wp_create_nonce('dooplay_cache_nonce'))
       );
        foreach(apply_filters('dooplay_cache_menu',$menus) as $menu ){
            $wp_admin_bar->add_menu($menu);
        }
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function get($label){
        if($this->is($label)){
			return file_get_contents($this->path.$this->safename($label).$this->extn);
		}
		return false;
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function set($label, $data){
        file_put_contents($this->path.$this->safename($label).$this->extn, $data);
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function is($label){
        $filename = $this->path.$this->safename($label).$this->extn;
        if(file_exists($filename) && (filemtime($filename) + $this->time >= time())) return true;
		return false;
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function delete($label){
        $file = $this->path.$this->safename($label).$this->extn;
        if(file_exists($file)) unlink($file);
        return false;
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function delete_expired(){
        foreach(glob("{$this->path}/*{$this->extn}") as $file){
            if(is_file($file) && (filemtime($file) + $this->time <= time())) unlink($file);
        }
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function delete_all(){
        foreach(glob("{$this->path}/*{$this->extn}") as $file){
            if(is_file($file)) unlink($file);
        }
    }


    /**
     * @since 2.1.8
     * @version 1.0
     */
    public function safename($label){
        return md5($label);
    }
}

new DooPlayCache;
