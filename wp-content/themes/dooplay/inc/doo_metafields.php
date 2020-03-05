<?php
/*
* ----------------------------------------------------
* @author: Doothemes
* @author URI: https://doothemes.com/
* @copyright: (c) 2018 Doothemes. All rights reserved
* ----------------------------------------------------
*
* @since 2.2.2
*
*/

if(!class_exists('Doofields')){

    /* The class
	========================================================
	*/
    class Doofields {

        // Attributes
        public $args = false;


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function __construct($args) {
            // Generate fields
            if(is_array($args)){
                foreach($args as $item ){
                    $this->fields_html($item);
                }
            }
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function meta($meta_key) {
            global $post;
            $field = get_post_meta($post->ID, $meta_key, true);
            return esc_attr($field);
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function fields_html($item) {
            if(is_array($item)){
                // Get Type
                $type = doo_isset($item,'type');
                // Compose field from type
                switch($type){
                    case 'text':
                        $output = $this->text($item);
                        break;
                    case 'textarea':
                        $output = $this->textarea($item);
                        break;
                    case 'date':
                        $output = $this->tdate($item);
                        break;
                    case 'generator':
                        $output = $this->generator($item);
                        break;
                    case 'checkbox':
                        $output = $this->checkbox($item);
                        break;
                    case 'upload':
                        $output = $this->upload($item);
                        break;
                    case 'heading':
                        $output = $this->heading($item);
                        break;
                }
                // Compose view
                $response = apply_filters('dooplay_metafields', $output, $type);
                // Echo View
                echo $response;
            }
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function text($args){
            // Parameters
            $label = doo_isset($args,'label');
            $id    = doo_isset($args,'id');
            $id2   = doo_isset($args,'id2');
            $class = doo_isset($args,'class');
            $fdesc = doo_isset($args,'fdesc');
            $desc  = doo_isset($args,'desc');
            $doubl = doo_isset($args,'double');
            // Values
            $value1 = $id ? $this->meta($id) : false;
            $value2 = $id2 ? $this->meta($id2) : false;
            // View
            $output  = "<tr id='{$id}_box'><td class='label'><label for='{$id}'>{$label}</label>";
    		$output .= "<p class='description'>{$desc}</p></td>";
    		$output .= "<td class='field'>";
            if(!empty($doubl)){
                $output .= "<input class='extra-small-text' type='text' name='{$id}' id='{$id}' value='{$value1}'> - ";
                $output .= "<input class='extra-small-text' type='text' name='{$id2}' id='{$id2}' value='{$value2}'>";
            } else {
                $output .= "<input class='{$class}' type='text' name='{$id}' id='{$id}' value='{$value1}'>";
            }
            if(!empty($fdesc)) $output .= "<p class='description'>{$fdesc}</p>";

            $output .= "</td></tr>";
            // Compose view
            return $output;
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function textarea($args) {
            // Parameters
            $id     = doo_isset($args,'id');
            $desc   = doo_isset($args,'desc');
            $upload = doo_isset($args,'upload');
            $aid    = doo_isset($args,'aid');
            $label  = doo_isset($args,'label');
            $rows   = doo_isset($args,'rows');
            $value  = $id ? $this->meta($id) : false;
            $btnt   = $upload ? __d('Upload') : false;
            // View
            $output  = "<tr id='{$id}_box'><td class='label'><label for='{$id}'>{$label}</label>";
    		$output .= "<p class='description'>{$desc}</p></td>";
    		$output .= "<td class='field'><textarea name='{$id}' id='{$id}' rows='{$rows}'>{$value}</textarea>";
            if(!empty($upload)) $output .= "<input class='{$aid} button-secondary' type='button' value='{$btnt}' />";
    		$output .= "</td></tr>";
            // Compose view
            return $output;
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function tdate($args){
            // Parameters
            $id    = doo_isset($args,'id');
            $label = doo_isset($args,'label');
            $fdesc = doo_isset($args,'fdesc');
            $value = $id ? $this->meta($id) : false;
            // View
            $output  = "<tr id='{$id}_box'>";
    		$output .= "<td class='label'><label for='{$id}'>{$label}</label></td>";
    		$output .= "<td class='field'>";
            $output .= "<input class='small-text' type='date' name='{$id}' id='{$id}' value='{$value}'>";
            if(!empty($fdesc)) $output .= "<p class='description'>{$fdesc}</p>";
            $output .= "</td></tr>";
            // Compose view
            return $output;
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function generator($args) {
            // Parameters
            $id           = doo_isset($args,'id');
            $id2          = doo_isset($args,'id2');
            $id3          = doo_isset($args,'id3');
            $label        = doo_isset($args,'label');
            $desc         = doo_isset($args,'desc');
            $style        = doo_isset($args,'style');
            $fdesc        = doo_isset($args,'fdesc');
            $class        = doo_isset($args,'class');
            $placeholder  = doo_isset($args,'placeholder');
            $placeholder2 = doo_isset($args,'placeholder2');
            $placeholder3 = doo_isset($args,'placeholder3');
            $requireupdat = doo_isset($args,'requireupdate');
            $onlyupdatepo = doo_isset($args,'previewpost');
            $editoraction = doo_isset($_GET,'action');
            $text_buttom  = ($editoraction == 'edit') ? __('Update info') : __('Generate');
            if(!$onlyupdatepo){
                $acti_buttom  = ($editoraction == 'edit') ? 'dbmovies-updaterpost' : 'dbmovies-generartor';
            } else {
                $acti_buttom = 'dbmovies-updaterpost';
            }

            $text_duplic  = __d('Check duplicate content');
            // Values
            $value1 = $id  ? $this->meta($id)  : false;
            $value2 = $id2 ? $this->meta($id2) : false;
            $value3 = $id3 ? $this->meta($id3) : false;
            // View
            $output  = "<tr id='{$id}_box'><td class='label'>";
    		$output .= "<label for='{$id}'>{$label}</label>";
    		$output .= "<p class='description'>{$desc}</p></td>";
            $output .= "<td {$style} class='field'>";
            if(!empty($id)) $output .= "<input class='{$class}' type='text' name='{$id}' id='{$id}' placeholder='{$placeholder}' value='{$value1}'> ";
            if(!empty($id2)) $output .= "<input class='{$class}' type='text' name='{$id2}' id='{$id2}' placeholder='{$placeholder2}' value='{$value2}'> ";
            if(!empty($id3)) $output .= "<input class='{$class}' type='text' name='{$id3}' id='{$id3}' placeholder='{$placeholder3}' value='{$value3}'> ";
            if(!$editoraction || $requireupdat == true){
                $output .= "<input type='button' class='button button-primary' name='dbmovies-generartor' id='{$acti_buttom}' value='{$text_buttom}'>";
            }
    		$output .= "<p class='description'>{$fdesc}</p>";
    		$output .= "</td></tr>";
            // Compose view
            return $output;
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function checkbox($args) {
            // Parameters
            $id      = doo_isset($args,'id');
            $label   = doo_isset($args,'label');
            $clabel  = doo_isset($args,'clabel');
            $checked = $this->meta($id) == true ? ' checked' : false;
            // View
            $output  = "<tr id='{$id}_box'><td class='label'><label>{$label}</label></td>";
            $output .= "<td class='field'><label for='{$id}_clik'><input type='checkbox' name='{$id}' value='1' id='{$id}_clik'{$checked}> {$clabel}</label></td></tr>";
            // Compose view
            return $output;
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function upload($args){
            global $post;
            // Parameters
            $id      = doo_isset($args,'id');
            $aid     = doo_isset($args,'aid');
            $label   = doo_isset($args,'label');
            $desc    = doo_isset($args,'desc');
            $ajax    = doo_isset($args,'ajax');
            $prelink = doo_isset($args,'prelink');
            $nonce   = wp_create_nonce('dt-ajax-upload-image');
            $value   = $id ? $this->meta($id) : false;
            $btntext = __d('Upload now');
            $btnuplo = __d('Upload');
            // View
            $output  = "<tr id='{$id}_box'><td class='label'><label for='dt_poster'>{$label}</label><p class='description'>{$desc}</p></td>";
    		$output .= "<td class='field'><input class='regular-text' type='text' name='{$id}' id='{$id}' value='{$value}'> ";
    		$output .= "<input class='{$aid} button-secondary' type='button' value='{$btnuplo}' /> ";
            if(!empty($ajax) && !filter_var($value, FILTER_VALIDATE_URL)) {
                $output .= "<input class='import-upload-image button-secondary' type='button' data-field='{$id}' data-postid='{$post->ID}' data-nonce='{$nonce}' data-prelink='{$prelink}' value='{$btntext}' />";
            }
    		$output .= "</td></tr>";
            // Compose View
            return $output;
        }


        /**
         * @since 2.2.2
         * @version 1.1
         */
        public function heading($args) {
            // Parameters
            $colspan = doo_isset($args,'colspan');
            $text    = doo_isset($args,'text');
            // View
            return "<tr><td colspan={$colspan}><h3>{$text}</h3></td></tr>";
        }
    }
}
