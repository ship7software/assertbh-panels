<?php
if( !defined( 'ABSPATH') ) exit();
/**
 * Display slider
 * 
 * @param string $alias slider alias
 */

if (!function_exists('avartanSlider')) {
    function avartanSlider($alias) {
        AvartanlitesliderShortcode::avartansliderOutput($alias, true);
    }
}

/**
 * return slider html
 * 
 * @param string $alias slider alias
 * 
 * @return string slider html
 */
if (!function_exists('avartansliderGet')) {
    function avartansliderGet($alias) {
        AvartanlitesliderShortcode::avartansliderOutput($alias, false);
    }
}

class AvartanlitesliderShortcode {

    /**
     * check shortcode
     */
    public static function avartansliderExtShortcode($atts) {
        $a = shortcode_atts(array(
            'alias' => false,
                ), $atts);

        if (!$a['alias']) {
            return __('You have to insert a valid alias in the shortcode', AVARTANLITESLIDER_TEXTDOMAIN);
        } else {
            return AvartanlitesliderShortcode::avartansliderOutput($a['alias'], false);
        }
    }

    /**
     * Generate shortcode
     */
    public static function avartansliderAddShortcode() {
        add_shortcode(AVARTANLITESLIDER_TEXTDOMAIN, array(__CLASS__, 'avartansliderExtShortcode'));
    }
    /**
    * return boolean
    */
    public static function returnBoolean($str){
           if(is_numeric($str)) {
               if($str == 0)
                   return "false";
               else if($str == 1)
                   return "true";
           }
           return "false";
           
    }

    /**
     * Get slide information
     * 
     * @param array $slides slide information
     * 
     */
    public static function avartansliderEleDetails($elements) {
        $ele_output = '';

        $elements = is_array($elements) ? $elements : array($elements);
        foreach ($elements as $element) {
            
            if(trim($element->type) == 'button' || trim($element->type) == 'icon' || trim($element->type) == 'shortcode' || trim($element->type) == 'shape'){
                continue;
            }
            
            $ele_img_width = $ele_img_height = 0;
            $ele_css = 'z-index: ' . (isset($element->z_index) ? trim($element->z_index) : '1') . ';';
            
            $ele_animation = ' data-delay="' . (isset($element->data_delay) ? trim($element->data_delay) : '300') . '"' . 
                                ' data-ease-in="' . (isset($element->data_easeIn) ? trim($element->data_easeIn) : '300') . '"' . 
                                ' data-ease-out="' . (isset($element->data_easeOut) ? trim($element->data_easeOut) : '300') . '"' . 
                                ' data-in="' . (isset($element->data_in) ? trim($element->data_in) : 'fade') . '"' . 
                                ' data-out="' . (isset($element->data_out) ? trim($element->data_out) : 'fade') . '"' . 
                                ' data-ignore-ease-out="' . (isset($element->data_ignoreEaseOut) ? trim($element->data_ignoreEaseOut) : '') . '"' . 
                                ' data-top="' . (isset($element->data_top) ? trim($element->data_top) : '0') . '"' .
                                ' data-left="' . (isset($element->data_left) ? trim($element->data_left) : '0') . '"' . 
                                ' data-time="' . (isset($element->data_time) ? trim($element->data_time) : 'all') . '"';
            
            $ele_id = ((isset($element->attr_id) && trim($element->attr_id)!='') ? 'id="' .trim($element->attr_id) . '" ' : '');
            $ele_class = 'as-layer'.((isset($element->attr_class) && trim($element->attr_class)!='') ? ' '.trim($element->attr_class) : '');
            $ele_title = ((isset($element->attr_title) && trim($element->attr_title)!='') ? 'title="' .trim($element->attr_title) . '" ' : '');
            $ele_rel = ((isset($element->attr_rel) && trim($element->attr_rel)!='') ? 'rel="' .trim($element->attr_rel) . '" ' : '');

            $ele_target = (isset($element->link) && trim($element->link) != '' && isset($element->link_new_tab) && trim($element->link_new_tab) == 1) ? 'target="_blank"' : '';

            $ele_href = (isset($element->link) && trim($element->link) != '') ? 'href="'. stripslashes(trim($element->link)) .'"' : '';

            $ele_custom_css = ((isset($element->custom_css) && trim($element->custom_css)!='') ? stripslashes(trim($element->custom_css)) : '');


            if (isset($element->link) && trim($element->link) != '') {
                //Set link
                $ele_output .= '<a ' . $ele_target . ' ' . $ele_href;
            } else {
                $ele_output .= '<div ';
            }

            if($ele_id!='') { $ele_output .= ' ' . $ele_id; }

            if($ele_title!='') { $ele_output .= ' ' . $ele_title; }

            if($ele_rel!='') { $ele_output .= ' ' . $ele_rel; }

            if($ele_animation!='') { $ele_output .= ' ' . $ele_animation; }

            $ele_output .= ' style="';
            $ele_output .= $ele_css;

            if($ele_custom_css!='') { $ele_output .= '' . $ele_custom_css; }
            
            if(trim($element->type) == 'video'){
                $ele_video_width = (isset($element->video_width) ? trim($element->video_width) : '320');

                $ele_video_height = (isset($element->video_height) ? trim($element->video_height) : '240');

                $ele_output .= "width :".$ele_video_width."px; height:".$ele_video_height."px;";
            }
            
            if(trim($element->type) == 'image'){
                $ele_img_width = (isset($element->image_width) ? trim($element->image_width) : '');

                $ele_img_height = (isset($element->image_height) ? trim($element->image_height) : '');

                $ele_output .= "width:".$ele_img_width."px;height:".$ele_img_height."px;";
            }

            $ele_output .= '"';
            
            
            switch (trim($element->type)) {
                case 'text':
                    $ele_class .= ' as-text-layer';

                    $ele_output .= ' class="'. trim($ele_class) .'" ';

                    $ele_output .= '>';

                    $ele_output .= (isset($element->inner_html) ? stripslashes(trim($element->inner_html)) : '');

                    break;
                
                case 'image':
                    $ele_image_scale = 'data-scale =' . (isset($element->image_scale) && trim($element->image_scale) == 'Y' ? 'true' : 'false') . '"';

                    $ele_class .= ' as-image-layer';

                    $ele_output .= ' class="'. $ele_class .'" ';


                    if($ele_image_scale!='') { $ele_image_scale .= ' ' . $ele_image_scale; }

                    $ele_output .= '>' . "\n";

                    $ele_output .= '<img';
                    
                    $ele_output .= ' src="' . (isset($element->image_src) ? trim($element->image_src) : '') . '" width="' . $ele_img_width . '" height="' . $ele_img_height . '"' .
                            ' alt="' . ((isset($element->image_alt) && trim($element->image_alt)!='') ? trim($element->image_alt) : ((isset($element->image_title) && trim($element->image_title)!='') ? trim($element->image_title) : '')) . '"';

                    $ele_output .= '/>' . "\n";

                    break;

                case 'video':
                    $video_preview_img = '';

                    $ele_video_link = (isset($element->video_link) ? trim($element->video_link) : '');

                    $ele_video_type = ((isset($element->video_type) && $element->video_type == 'H') ? 'html5' : ((isset($element->video_type) && $element->video_type == 'V') ? 'vimeo' : 'youtube'));

                    $fullscreen = ((isset($element->video_full_width) && trim($element->video_full_width) == 'Y') ? 'fullscreenvideo' : 'none' );

                    $ele_video_settings = ' data-video-type =' . $ele_video_type  . 
                            ' data-fullscreenvideo=' . $fullscreen. 
                            ' data-is-preview="' . (isset($element->video_is_preview_set) ? trim($element->video_is_preview_set) : 'none') . '"' .
                            ' data-aspect-ratio="16:9"' .
                            ' data-video-current-time="0"';
                    if($ele_video_type == 'youtube' || $ele_video_type == 'vimeo'){
                        $video_preview_img = (isset($element->video_preview_img_src) ? $element->video_preview_img_src : '');
                        $ele_video_settings .= ' data-video-id="'. ((isset($element->video_id) && trim($element->video_id) != '') ? trim($element->video_id) : '') .'"'.
                                                ' data-preview-img="' . $video_preview_img . '"'.
                                                ' data-preview-title="' . ((isset($element->video_preview_img_alt) && trim($element->video_preview_img_alt)!='') ? trim($element->video_preview_img_alt) : (isset($element->video_preview_img_title) ? $element->video_preview_img_title : '')) . '"';
                    }

                    if($ele_video_type == 'youtube'){
                        $ele_video_settings .= ' data-video-attr="version=3&amp;enablejsapi=1&amp;html5=1&amp;hd=1&amp;wmode=opaque&amp;showinfo=0&amp;ref=0;"'.
                                               ' data-video-speed="1"';
                    }

                    if($ele_video_type == 'vimeo'){
                        $ele_video_settings .= ' data-video-attr="title=0&amp;byline=0&amp;portrait=0&amp;api=1"';
                    }

                    if($ele_video_type == 'html5'){
                        $video_preview_img = (isset($element->video_html5_poster_url) ? $element->video_html5_poster_url : '');
                        $ele_video_settings .= ' data-preview-img="' . $video_preview_img . '"'.
                                                ' data-preview-title="'. __( 'Html5 Video', AVARTANLITESLIDER_TEXTDOMAIN ).'"';

                        if(isset($element->video_html5_mp4_video_link) && trim($element->video_html5_mp4_video_link) != ''){
                            $ele_video_settings .= ' data-video-mp4="' . trim($element->video_html5_mp4_video_link) . '"';
                        }
                        if(isset($element->video_html5_webm_video_link) && trim($element->video_html5_webm_video_link) != ''){
                            $ele_video_settings .= ' data-video-webm="' . trim($element->video_html5_webm_video_link) . '"';
                        }
                        if(isset($element->video_html5_ogv_video_link) && trim($element->video_html5_ogv_video_link) != ''){
                            $ele_video_settings .= ' data-video-ogv="' . trim($element->video_html5_ogv_video_link) . '"';
                        }

                    }

                    $ele_class .= ' as-video-layer'.(($fullscreen!='none') ? ' '.$fullscreen : '');

                    $ele_output .= ' class="'. $ele_class .'" ';

                    if($ele_video_settings!='') { $ele_output .= ' ' . $ele_video_settings; }

                    $ele_output .= '>';
                    break;
            }
            if (isset($element->link) && trim($element->link) != '') {
                $ele_output .= '</a>' . "\n";
            } else {
                $ele_output .= '</div>' . "\n";
            }
        }
        return $ele_output;
    }
    
    public static function avartansliderSlideDetail($params, $elements) {
        $output = '';
        
        $background_type_image = (!isset($params['background_type_image']) || (isset($params['background_type_image']) && ($params['background_type_image'] == 'undefined' || $params['background_type_image'] == 'none'))) ? 'none;' : 'url(\'' . $params['background_type_image'] . '\');';
            $background_color = (!isset($params['background_type_color']) || (isset($params['background_type_color']) && $params['background_type_color'] == 'transparent')) ? 'transparent' : $params['background_type_color'];
            
            $background_position = 'center center';
            if(isset($params['background_property_position']))
            {
                if(trim($params['background_property_position']) == 'percentage'){
                    $background_position = (isset($params['background_property_position_x']) ? $params['background_property_position_x']. '%' : '0') . ' ' . (isset($params['background_property_position_y']) ? $params['background_property_position_y']. '%' : '0');
                }
                else
                {
                    $background_position = trim($params['background_property_position']);
                }
            }
            
            $background_size = 'cover';
            if(isset($params['background_property_size']))
            {
                if(trim($params['background_property_size']) == 'percentage'){
                    $background_size = (isset($params['background_property_size_x']) ? $params['background_property_size_x']. '%' : '0') . ' ' . (isset($params['background_property_size_y']) ? $params['background_property_size_y'] . '%' : '0');
                }
                else
                {
                    $background_size = trim($params['background_property_size']);
                }
            }
            
            $output .= '<li' . 
                    ' style="' . 
                    ' background-color: ' . $background_color . ';' .
                    ' background-image: ' . $background_type_image . ';' . 
                    ' background-position: ' . $background_position . ';' . 
                    ' background-repeat: ' . (isset($params['background_repeat']) ? $params['background_repeat'] : 'no-repeat') . ';' . 
                    ' background-size: ' . $background_size . ';' . 
                    (isset($params['custom_css']) ? stripslashes($params['custom_css']) : '') . 
                    '"' .
                    ' data-in="' . (isset($params['data_in']) ? $params['data_in'] : '') . '"' . 
                    ' data-ease-in="' . (isset($params['data_easeIn']) ? $params['data_easeIn'] : '') . '"' . 
                    ' data-out="' . (isset($params['data_out']) ? $params['data_out'] : '') . '"' . 
                    ' data-ease-out="' . (isset($params['data_easeOut']) ? $params['data_easeOut'] : '') . '"' . 
                    ' data-time="' . (isset($params['data_time']) ? $params['data_time'] : '') . '"' . 
                    '>';

        //Get Elements of particular slide
        if(count($elements) > 0){
            $output .= AvartanlitesliderShortcode::avartansliderEleDetails($elements);

        }
        $output .= '</li>' . "\n";
        
        return $output;
    }
    
    /**
     * Generate slider
     * 
     * @param string $alias slider alias
     * 
     * @param boolean $echo identify the we have to return the output or display the output
     * 
     * @return string if $echo is false then whole slider content will return
     */
    public static function avartansliderOutput($alias, $echo) {
        
        global $wpdb;
        
        //Get the slider information
        $slider = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'avartan_sliders WHERE alias = \'' . $alias . '\'');

        //Display error message if slider is not found
        if (!$slider) {
            if ($echo) {
                _e('The slider has not been found', AVARTANLITESLIDER_TEXTDOMAIN);
                return;
            } else {
                return __('The slider has not been found', AVARTANLITESLIDER_TEXTDOMAIN);
            }
        }

        $slider_id = $slider->id;
        $slider_option = maybe_unserialize($slider->slider_option);

        $output = '';

        //Set some settings for slider 
        $output .= '<div style="display: none;" class="avartanslider-slider avartanslider-slider-' . (isset($slider_option->layout) ? $slider_option->layout : '') . ' avartanslider-slider-' . $alias . '" id="avartanslider-' . $slider_id . '">' . "\n";
        $output .= '<ul>' . "\n";

        //Get slide information
        $slides = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'avartan_slides WHERE slider_parent = ' . $slider_id . ' ORDER BY position');

        foreach ($slides as $slide) {

            //Get slide setting and set the property
            $params = maybe_unserialize($slide->params);
            
            $elements = array();
            //Get Elements of particular slide
            if ($slide->layers != '') {
                $elements = maybe_unserialize($slide->layers);
            }
            
            $output .= AvartanlitesliderShortcode::avartansliderSlideDetail($params,$elements);
        }
        
        $output .= '</ul>' . "\n";
        $output .= '</div>' . "\n";
        
        //Get Loader
        $loader_options = isset($slider_option->loader) ? $slider_option->loader : array();
        $lEnable = (isset($slider_option->enableLoader)) ? $slider_option->enableLoader : ((isset($loader_options->enable)) ? $loader_options->enable : 1);
        $lType = (isset($slider_option->loaderType)) ? $slider_option->loaderType : ((isset($loader_options->type)) ? $loader_options->type : 'default');
        
        if($lType == 'default') {
            $lStyle = (isset($slider_option->loaderClass)) ? trim($slider_option->loaderClass) : ((isset($loader_options->style)) ? $loader_options->style : 'loader1'); 
        }
        
        //Get Arrows
        $arrows_options = isset($slider_option->navigation->arrows) ? $slider_option->navigation->arrows : array();
        $aEnable = (isset($slider_option->showControls)) ? $slider_option->showControls : ((isset($arrows_options->enable)) ? $arrows_options->enable : 1);
        $arrowsStyle = (isset($slider_option->controlsClass) ? trim($slider_option->controlsClass) : (isset($arrows_options->style) ? trim($arrows_options->style) : 'control1'));
        $arrowInn = '';
        
        //Get Bullets
        $navBulletOptions = isset($slider_option->navigation->bullets) ? $slider_option->navigation->bullets : array();
        
        $hPos = (isset($navBulletOptions->hPos) ? $navBulletOptions->hPos : 'center');
        if(isset($slider_option->navigationPosition)) {
            switch(trim($slider_option->navigationPosition)) {
                case 'bl' :
                    $hPos = 'left';
                    break;
                case 'bc' :
                    $hPos = 'center';
                    break;
                case 'br' :
                    $hPos = 'right';
                    break;
            }
        }
        
        $bulletStyle = (isset($slider_option->navigationClass) ? trim($slider_option->navigationClass) : (isset($navBulletOptions->style) ? trim($navBulletOptions->style) : 'navigation1'));

        $output .= '<script type="text/javascript">' . "\n";
        $output .= '(function($) {' . "\n";
        $output .= '$(document).ready(function() {' . "\n";
        $output .= '$("#avartanslider-' . $slider_id . '").avartanSlider({' . "\n";
        $output .= 'layout: \'' . (isset($slider_option->layout) ? $slider_option->layout : 'fixed') . '\',' . "\n";
        $output .= 'startWidth: ' . (isset($slider_option->startWidth) ? $slider_option->startWidth : '1170') . ',' . "\n";
        $output .= 'startHeight: ' . (isset($slider_option->startHeight) ? $slider_option->startHeight : '500') . ',' . "\n";
        $output .= 'sliderBgColor: \'' . (isset($slider_option->background_type_color) ? trim($slider_option->background_type_color) : 'transparent') . '\',' . "\n";
        $output .= 'automaticSlide: ' . (isset($slider_option->automaticSlide) ? $slider_option->automaticSlide : 'true') . ',' . "\n";
        $output .= 'enableSwipe: ' . (isset($slider_option->enableSwipe) ? $slider_option->enableSwipe : 'true') . ',' . "\n";
        $output .= 'showShadowBar: ' . (isset($slider_option->showShadowBar) ? $slider_option->showShadowBar : 'false') . ',' . "\n";
        $output .= 'shadowClass: \'' . (isset($slider_option->shadowClass) ? trim($slider_option->shadowClass) : '') . '\',' . "\n";
        $output .= 'pauseOnHover: ' . (isset($slider_option->pauseOnHover) ? $slider_option->pauseOnHover : 'true') . ',' . "\n";
        $output .= 'loader : {'. "\n";
        $output .= 'type:'.'\''. $lType .'\''. ',' . "\n";
        $output .= 'style:'.'\''. $lStyle .'\''. ',' . "\n";
        $output .= '}' . ',' . "\n";
        $output .= 'navigation : {'. "\n";
        $output .= 'arrows: {'. "\n";
        $output .= 'enable:'. AvartanlitesliderShortcode::returnBoolean($aEnable) . ',' . "\n";
        $output .= 'style:'.'\''.$arrowsStyle.'\''. ',' . "\n";
        $output .= ' },' . "\n";
        $output .= 'bullets: {'. "\n";
        $output .= 'enable:'. (isset($navBulletOptions->enable) ? AvartanlitesliderShortcode::returnBoolean($navBulletOptions->enable) : 'false') . ',' . "\n";
        $output .= 'style:'.'\''. $bulletStyle .'\''. ',' . "\n";
        $output .= 'hPos:\''.$hPos.'\',' . "\n";
        $output .= 'vPos:\'bottom\',' . "\n";
        $output .= 'hOffset:0,' . "\n";
        $output .= 'vOffset:20,' . "\n";
        $output .= ' }' . "\n";
        $output .= '}' . ',' . "\n";
        $output .= '});' . "\n";
        $output .= '});' . "\n";
        $output .= '})(jQuery);' . "\n";
        $output .= '</script>' . "\n";
 
        if ($echo) {
            echo $output;
        } else {
            return $output;
        }
    }
    
}