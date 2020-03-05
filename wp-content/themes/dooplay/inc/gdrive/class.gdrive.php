<?php if(!defined('ABSPATH')) exit;
/**
 * @author Doothemes (Erick Meza & Brendha Mayuri)
 * @since 2.2.4
 */

class DooGdrive{

    // Protected Vars
    protected $path_cache;
    protected $time_cache;
    protected $file_cokie;
    protected $link_drive;

    /**
     * @since 1.0
     * @version 1.0
     */
    public function __construct(){
        // Vars
        $this->link_drive = 'https://drive.google.com';
        $this->file_cokie = DOO_DIR.'/inc/gdrive/gdrive.cookie';
        $this->path_cache = DOO_DIR.'/inc/gdrive/cache/';
        $this->time_cache = 900;
        // Clean files in cache
        if(!wp_next_scheduled('google_drive_expired')) {
            wp_schedule_event(time(),'daily','google_drive_expired');
        }
        // Schedule Action
        add_action('google_drive_expired',array($this,'DeleteExpired'));
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function DeleteExpired(){
        foreach(glob("{$this->path_cache}*") as $file){
            if(is_file($file) && (filemtime($file) + $this->time_cache <= time())) unlink($file);
        }
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function DeleteAll(){
        foreach(glob("{$this->path_cache}*") as $file){
            if(is_file($file)) unlink($file);
        }
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function GetUrl($string){
        $idgd = $this->GetID($string);
        $file = $this->path_cache.$idgd;
        if(file_exists($file) && filemtime($file) + $this->time_cache >= time()){
            $download = file_get_contents($file);
        } else {
            $download = $this->GetPage($idgd);
            file_put_contents($file,$download);
        }
        return apply_filters('google_drive_url', esc_url($download), $idgd);
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function GetID($string){
        $gdid = $string;
        if(wp_http_validate_url($gdid)) {
            $formt1 = explode('file/d/', $string);
            $formt2 = explode('open?id=', $string);
            if(isset($formt1[1])){
                $temp = explode('d/', $formt1[1]);
                $gdid = isset($temp[0]) ? $temp[0] : false;
            }elseif(isset($formt2[1])){
                $temp = explode('d=', $formt2[1]);
                $gdid = isset($temp[0]) ? $temp[0] : false;
            }
        }
        return apply_filters('google_drive_id', $gdid, $string);
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function GetPage($google_id){
        $ip = array(
            'REMOTE_ADDR: 127.0.0.1',
            'HTTP_X_FORWARDED_FOR: 127.0.0.1'
        );
        $ap = $this->link_drive.'/uc?export=download&id='.$google_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$ap);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ip);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->file_cokie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->file_cokie);
        $page = curl_exec($ch);
        $download = $this->Download($page);
        $filer = explode('webhp?tab=',$download);
        $filrr = isset($filer[1]) ? $filer[1] : false;
        if($filrr){
            $confirm = $this->Confirm($page);
            curl_setopt($ch, CURLOPT_URL,$ap.'&confirm='.$confirm);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $ip);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->file_cokie);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $this->file_cokie);
            $page = curl_exec($ch);
            $download = $this->Download($page);
        }
        curl_close($ch);
        return apply_filters('google_drive_page', $download, $google_id);
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function Download($content){
        $result = '';
        preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $content, $result);
        if(!empty($result)) {
            return $result['href'][0];
        }
    }


    /**
     * @since 1.0
     * @version 1.0
     */
    public function Confirm($content){
        $result = '';
        preg_match_all('/<a id="uc-download-link"[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $content, $result);
        if(!empty($result)) {
            $pre1 = explode('confirm=', $result['href'][0]);
            $pre2 = explode('&',$pre1[1]);
            return $pre2[0];
        }
    }
}

new DooGdrive;
