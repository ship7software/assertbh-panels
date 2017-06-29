<?php
if( !defined( 'ABSPATH') ) exit();
/**
 * Print Elements slide wise
 * 
 * @param boolean $edit identify that you are in edit mode or not
 * 
 * @param array $slider slider information
 * 
 * @param array $slide slide information
*/
if(!function_exists('avartansliderPrintElements'))
{
    function avartansliderPrintElements($edit, $slider, $slide) {
    
        //Get slider option
        $slider_option = maybe_unserialize( $slider->slider_option );

        //Get all Slides settings by params and elements by layers
        $params = $elements = array();
        $slide_index = 0;
        if($slide){
            $params = maybe_unserialize( $slide->params );
            $slide_index = ($slide->position + 1);
            $elements = maybe_unserialize($slide->layers);
        }
        global $aios_ele_time_output;
        ?>
	<div class="as-elements">
            <div
            class="as-editor-wrapper"
            <?php 
            if($edit && $slide): ?>
                    <?php
                    
                    if(isset($params['background_type_image']) && $params['background_type_image'] != 'none') {
                            echo 'data-background-image-src="' . $params['background_type_image'] . '"';
                    }
                    
                    $background_position = '0 0';
                    if(isset($params['background_property_position']))
                    {
                        if(trim($params['background_property_position']) == 'percentage'){
                            $background_position = (isset($params['background_property_position_x']) ? $params['background_property_position_x'] : '0') . '% ' . (isset($params['background_property_position_y']) ? $params['background_property_position_y'].'%' : '0');
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
                            $background_size = (isset($params['background_property_size_x']) ? $params['background_property_size_x'] : '0') . '% ' . (isset($params['background_property_size_y']) ? $params['background_property_size_y'] . '%' : '0');
                        }
                        else
                        {
                            $background_size = trim($params['background_property_size']);
                        }
                    }
                    ?>
                    style="
                    width: <?php echo (isset($slider_option->layout) && $slider_option->layout == 'full-width') ? '100%' : (isset($slider_option->startWidth) ? $slider_option->startWidth.'px' : '1170px'); ?>;
                    height: <?php echo isset($slider_option->startHeight) ? $slider_option->startHeight:'500'; ?>px;
                    background-image: url('<?php echo isset($params['background_type_image']) ? $params['background_type_image']:''; ?>');
                    background-color: <?php echo ((isset($params['background_type_color']) && $params['background_type_color'] == 'transparent') ? 'rgba(0, 0, 0, 0)' : $params['background_type_color']); ?>;
                    background-position: <?php echo $background_position; ?>;			
                    background-repeat: <?php echo isset($params['background_repeat']) ? $params['background_repeat'] : 'no-repeat'; ?>;
                    background-size: <?php echo $background_size; ?>;
                    <?php echo isset($params['custom_css']) ? stripslashes($params['custom_css']) : ''; ?>
                    "
            <?php endif; ?>
            >
                <div class="as-slide-editing-area <?php echo ($edit && $slide && isset($slider_option->layout) && $slider_option->layout == 'fixed') ? 'fixed' :''; ?>"
                     <?php 
                    if($edit && $slide): ?>
                     style="
                    width: <?php echo isset($slider_option->startWidth) ? $slider_option->startWidth : '1170'; ?>px;
                    height: <?php echo isset($slider_option->startHeight) ? $slider_option->startHeight:'500'; ?>px;"
                    <?php endif; ?>
                     >
                <?php
                $aios_ele_time_output = '';
                if($edit && $elements != NULL) {
                    echo avartansliderPrintEditior($elements);
                }
                ?>
                </div>
            </div>
            <div class="as-elements-actions">
                <div class="as-layer-menu">
                    <a href="javascript:void(0);" class="as-select-layer"><i class="fa fa-database"></i>&nbsp;&nbsp;<?php _e( 'Add New Layer', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
                    <ul style="display: none;">
                        <li>
                            <a class="as-add-text-element"><i class="fa fa-text-width"></i>&nbsp;&nbsp;<?php _e( 'Text/HTML', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
                        </li>
                        <li>
                            <a class="as-add-image-element"><i class="fa fa-image"></i>&nbsp;&nbsp;<?php _e( 'Image', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
                        </li>
                        <li>
                            <a class="as-add-video-element"><i class="fa fa-video-camera"></i>&nbsp;&nbsp;<?php _e( 'Video', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
                        </li>
                        <li>
                            <a class="as-add-shortcode-element as-is-temp-disabled as-pro-version"><i class="fa fa-code"></i>&nbsp;&nbsp;<?php _e( 'Shortcode', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
                        </li>
                        <li>
                            <a class="as-add-button-element as-is-temp-disabled as-pro-version"><i class="fa fa-square-o"></i>&nbsp;&nbsp;<?php _e( 'Button', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
                        </li>
                        <li>
                            <a class="as-add-icon-element as-is-temp-disabled as-pro-version"><i class="fa fa-th"></i>&nbsp;&nbsp;<?php _e( 'Icon', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
                        </li>
                        <li>
                            <a class="as-add-shape-element as-is-temp-disabled as-pro-version"><i class="fa fa-clone"></i>&nbsp;&nbsp;<?php _e( 'Shape', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
                        </li>
                    </ul>
                </div>
                <a title="<?php _e( 'Delete All Element', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" class="as-right as-delete-all-element as-element-action <?php echo ($slide && $slide->layers!='')?'':'as-is-disabled'; ?>"><span class="dashicons dashicons-trash"></span></a>
                <a title="<?php _e( 'Duplicate Element', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" class="as-right as-duplicate-element as-element-action as-is-disabled"><span class="dashicons dashicons-images-alt"></span></a>
                <a title="<?php _e( 'Delete Element', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" class="as-right as-delete-element as-element-action as-is-disabled"><span class="dashicons dashicons-dismiss"></span></a>
                <a title="<?php _e( 'Live Preview', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" class="as-right as-live-preview as-element-action"><span class="dashicons dashicons-search"></span></a>
                <a title="<?php _e( 'Element Timing', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" class="as-right as-ele-time-btn as-element-action"><span class="dashicons dashicons-backup"></span></a>
            </div>
            <div class="as-ele-time" style="display: none;">
                <span class="as-close-block">X</span>
                <h4 class="ad-s-setting-head"><?php _e('All Elements Timing', AVARTANLITESLIDER_TEXTDOMAIN); ?></h4>
                <table  cellspacing="0">
                    <thead class="as-ele-list-tilte">
                        <tr>
                            <th title="<?php _e('Show/Hide Element', AVARTANLITESLIDER_TEXTDOMAIN); ?>"><center><span class="dashicons dashicons-visibility"></span></center></th>
                            <th><center><?php _e('Element List', AVARTANLITESLIDER_TEXTDOMAIN); ?></center></th>
                            <th><center><?php _e('Delay Time', AVARTANLITESLIDER_TEXTDOMAIN); ?> <small>(<?php _e('ms', AVARTANLITESLIDER_TEXTDOMAIN); ?>)</small></center></th>
                            <th><center><?php _e('Ease In', AVARTANLITESLIDER_TEXTDOMAIN); ?> <small>(<?php _e('ms', AVARTANLITESLIDER_TEXTDOMAIN); ?>)</small></center></th>
                            <th><center><?php _e('Ease Out', AVARTANLITESLIDER_TEXTDOMAIN); ?> <small>(<?php _e('ms', AVARTANLITESLIDER_TEXTDOMAIN); ?>)</small></center></th>
                            <th><center><?php _e('Z-index', AVARTANLITESLIDER_TEXTDOMAIN); ?></center></th>
                            </tr>   
                    </thead>
                    <tbody>
                        <?php 
                        if($aios_ele_time_output!='')
                        {
                            echo $aios_ele_time_output;
                        }
                        else
                        {
                            ?>
                            <tr class="as-no-record">
                                <td colspan="6" align="center"><?php _e('No element found.', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="as-elements-list">
                <?php
                if($edit && $elements != NULL) {
                    foreach($elements as $ele_key => $element) {
                        if(isset($element->type)) {
                            switch($element->type) {
                                case 'text':
                                        echo '<div class="as-element-settings as-text-element-settings" style="display: none;">';
                                        avartansliderPrintTextElement($element);
                                        echo '</div>';
                                    break;
                                case 'image':
                                        echo '<div class="as-element-settings as-image-element-settings" style="display: none;">';
                                        avartansliderPrintImageElement($element, $ele_key);
                                        echo '</div>';
                                    break;
                                case 'video':
                                        echo '<div class="as-element-settings as-video-element-settings" style="display: none;">';
                                        avartansliderPrintVideoElement($element, $slide_index, $ele_key);
                                        echo '</div>';
                                    break;    
                            }
                        }
                    }
                }
                echo '<div class="as-void-element-settings as-void-text-element-settings as-element-settings as-text-element-settings">';
                avartansliderPrintTextElement(false);
                echo '</div>';
                echo '<div class="as-void-element-settings as-void-image-element-settings as-element-settings as-image-element-settings">';
                avartansliderPrintImageElement(false);
                echo '</div>';
                echo '<div class="as-void-element-settings as-void-video-element-settings as-element-settings as-video-element-settings">';
                avartansliderPrintVideoElement(false);
                echo '</div>';
                ?>
            </div>

	</div>
        <?php
    }
}

/**
 * Get Element timing block
 * 
 * @param boolean $edit identify that you are in edit mode or not
 * 
 * @param array $elements Elements information
 *
*/
if(!function_exists('avartansliderPrintEleTimingBlock'))
{
    function avartansliderPrintEleTimingBlock($element) {
        $container_class = '';
        $timing_output = '';
        if($element->type == 'text')
        {
            $timing_output .= '<tr class="as-ele-list '. $container_class .'">'.
                            '<td title="'. __( 'Show/Hide Element', AVARTANLITESLIDER_TEXTDOMAIN ).'"><span class="dashicons dashicons-visibility"></span></td>'.
                            '<td class="as-ele-title"><span class="fa fa-text-width"></span><span class="as-ele-heading">'. (isset($element->inner_html) ? stripslashes($element->inner_html) : __('Text Element', AVARTANLITESLIDER_TEXTDOMAIN)).'</span></td>';
        }
        else if($element->type == 'image'){
            $timing_output = '<tr class="as-ele-list as-ele-image-list '. $container_class .'">'.
                            '<td title="'. __( 'Show/Hide Element', AVARTANLITESLIDER_TEXTDOMAIN ).'"><span class="dashicons dashicons-visibility"></span></td>'.
                            '<td class="as-ele-title"><span class="fa fa-image"></span><span class="as-ele-heading">'.__('Image Element', AVARTANLITESLIDER_TEXTDOMAIN).'</span></td>';
            
        }
        else if($element->type == 'video'){
            $video_title = __('Video Element', AVARTANLITESLIDER_TEXTDOMAIN);
            
            if(isset($element->video_type) && $element->video_type=='H')
            {
                $video_title = __('Html5 Video', AVARTANLITESLIDER_TEXTDOMAIN);
            }
            else 
            {
                if(isset($element->video_preview_img_alt) && trim($element->video_preview_img_alt)!='')
                {
                    $video_title = trim($element->video_preview_img_alt);
                }
            }
            
            $timing_output = '<tr class="as-ele-list '. $container_class .'">'.
                            '<td title="'. __( 'Show/Hide Element', AVARTANLITESLIDER_TEXTDOMAIN ).'"><span class="dashicons dashicons-visibility"></span></td>'.
                            '<td class="as-ele-title"><span class="fa fa-video-camera"></span><span class="as-ele-heading">';
            
            $timing_output .= $video_title;
            $timing_output .= '</span></td>';
        }
        
        $timing_output .= '<td><input type="number" min="0" value="'. (isset($element->data_delay) ? trim($element->data_delay) : '300') .'" class="as-delay-ele" onkeypress="return isNumberKey(event);" /></td>'.
                            '<td><input type="number" min="0" value="'. (isset($element->data_easeIn) ? trim($element->data_easeIn) : '300') .'" class="as-easein-ele " onkeypress="return isNumberKey(event);" /></td>'.
                            '<td><input type="number" min="0" value="'. (isset($element->data_easeOut) ? trim($element->data_easeOut) : '300') .'" class="as-easeout-ele " onkeypress="return isNumberKey(event);" /></td>'.
                            '<td><input type="number" min="0" value="'. (isset($element->z_index) ? trim($element->z_index) : '1') .'" class="as-z-index-ele " onkeypress="return isNumberKey(event);" /></td>'.
                            '</tr>';

        return $timing_output;
    }
}

/**
 * Get data from database
 * 
 * @param array $elements Elements information
 *
*/
if (!function_exists('avartansliderPrintEditior')) {

    function avartansliderPrintEditior($elements) {

        global $aios_ele_time_output;

        $ele_output = '';

        $elements = is_array($elements) ? $elements : array($elements);
        foreach ($elements as $element) {
            
            if(trim($element->type) == 'button' || trim($element->type) == 'icon' || trim($element->type) == 'shortcode' || trim($element->type) == 'shape'){
                continue;
            }
            
            $ele_css = 'z-index: ' . (isset($element->z_index) ? trim($element->z_index) : '1') . ';'.
                        'top: ' . (isset($element->data_top) ? trim($element->data_top).'px' : '0') . ';'.
                        'left: ' . (isset($element->data_left) ? trim($element->data_left).'px' : '0') . ';';

            $ele_animation = 'data-top="' . (isset($element->data_top) ? trim($element->data_top) : '0') . '"' . "\n" .
                    'data-left="' . (isset($element->data_left) ? trim($element->data_left) : '0') . '"' . "\n";

            $ele_class = 'as-element' . "\n";

            $ele_target = (isset($element->link) && trim($element->link) != '' && isset($element->link_new_tab) && trim($element->link_new_tab) == 1) ? 'target="_blank"' : '';

            $ele_href = (isset($element->link) && trim($element->link) != '') ? 'href="' . stripslashes(trim($element->link)) . '"' : '';

            $ele_custom_css = ((isset($element->custom_css) && trim($element->custom_css) != '') ? stripslashes(trim($element->custom_css)) : '') . "\n";

            $aios_ele_time_output .= avartansliderPrintEleTimingBlock($element);
            
            if (isset($element->link) && trim($element->link) != '') {
                //Set link
                $ele_output .= '<a ' . $ele_target . ' ' . $ele_href . "\n";
            } else {
                $ele_output .= '<div ' . "\n";
            }
            
            if ($ele_animation != '') {
                $ele_output .= ' ' . $ele_animation . "\n";
            }

            $ele_output .= ' style="';
            $ele_output .= $ele_css . "\n";

            if ($ele_custom_css != '') {
                $ele_output .= '' . $ele_custom_css . "\n";
            }
            $ele_output .= '"' . "\n";

            switch (trim($element->type)) {
                    case 'text':
                        $ele_class .= ' as-text-element';
                        
                        $ele_output .= ' class="' . trim($ele_class) . '" ' . "\n";

                        $ele_output .= '>' . "\n";

                        $ele_output .= (isset($element->inner_html) ? stripslashes(trim($element->inner_html)) : '') . "\n";

                        break;

                    case 'image':
                        $ele_class .= ' as-image-element';
                        
                        $ele_output .= ' class="' . $ele_class . '" ' . "\n";

                        $ele_output .= '>' . "\n";

                        $ele_output .= '<img ' . "\n";

                        $ele_output .= 'src="' . (isset($element->image_src) ? trim($element->image_src) : '') . '"' . "\n" .
                                        'alt="' . (isset($element->image_alt) ? trim($element->image_alt) : '') . '"' . "\n".
                                        'width="' . (isset($element->image_width) ? trim($element->image_width) : '0') . '"' . "\n".
                                        'height="' . (isset($element->image_height) ? trim($element->image_height) : '0') . '"' . "\n";
                                        

                        $ele_output .= '/>' . "\n";

                        break;

                    case 'video':
                        $video_preview_img_src = AVARTANLITE_PLUGIN_URL . '/images/video_sample.jpg';

                        $video_title = __( 'Video Element', AVARTANLITESLIDER_TEXTDOMAIN );
                        $video_icon = 'youtube_icon';

                        if (isset($element->video_type) && $element->video_type == 'H') {

                            $video_title = __( 'Html5 Video', AVARTANLITESLIDER_TEXTDOMAIN );
                            $video_icon = 'html5_icon';
                            if (isset($element->video_html5_poster_url) && trim($element->video_html5_poster_url) != '') {
                                $video_preview_img_src = trim($element->video_html5_poster_url);
                            } else {
                                $video_preview_img_src = AVARTANLITE_PLUGIN_URL . '/images/html5-video.png';
                            }
                        } else {

                            if (isset($element->video_type) && $element->video_type == 'Y') {
                                $video_icon = 'youtube_icon';
                            } else if (isset($element->video_type) && $element->video_type == 'V') {
                                $video_icon = 'vimeo_icon';
                            }

                            if (isset($element->video_preview_img_src) && trim($element->video_preview_img_src) != '') {
                                $video_preview_img_src = trim($element->video_preview_img_src);
                            }
                            if (isset($element->video_preview_img_alt) && trim($element->video_preview_img_alt) != '') {
                                $video_title = trim($element->video_preview_img_alt);
                            }
                        }

                        $ele_class .= ' as-video-element';

                        $ele_output .= ' class="' . $ele_class . '" ' . "\n";

                        $ele_output .= '>' . "\n";

                        $ele_output .= '<label class="video_block_title">' . $video_title . '</label>' . "\n";

                        $ele_output .= '<img src="' . $video_preview_img_src . '" width="' . (isset($element->video_width) ? $element->video_width : '320px') . '" height="' . (isset($element->video_height) ? $element->video_height : '240px') . ' "/>' . "\n";
                        $ele_output .= '<div class="video_block_icon ' . $video_icon . '"></div>' . "\n";

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

}

/**
 * Print Text Element
 *  
 * @param array $element text element information
*/
if(!function_exists('avartansliderPrintTextElement'))
{
    function avartansliderPrintTextElement($element) {
	$void = !$element ? true : false;
	
        //Default Transition
	$animations = array(
		'slideDown' => array(__('Slide Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideUp' => array(__('Slide Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideLeft' => array(__('Slide Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideRight' => array(__('Slide Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fade' => array(__('Fade', AVARTANLITESLIDER_TEXTDOMAIN), true),
		'fadeDown' => array(__('Fade Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeUp' => array(__('Fade Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeLeft' => array(__('Fade Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeRight' => array(__('Fade Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallDown' => array(__('Fade Small Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallUp' => array(__('Fade Small Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallLeft' => array(__('Fade Small Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallRight' => array(__('Fade Small Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
	);
	
	?>
        <div class="as-element-pro-tab as-tabs">
            <ul class="as-element-pro-tab-ul">
                <li class="">
                    <a class="as-button as-is-navy as-is-active" href="javascript:void(0);" data-href=".as-ele-txt-general-parameter"><?php _e('General Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-txt-animation-parameter"><?php _e('Animation Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-txt-advanced-parameter"><?php _e('Advanced Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
            </ul>
            <div class="as-element-type-block as-ele-txt-general-parameter" style="display: block;">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('Text', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <textarea class="as-element-inner-html"><?php echo ($void)? __('Text element', AVARTANLITESLIDER_TEXTDOMAIN) : (isset($element->inner_html) ? stripslashes($element->inner_html) : '') ?></textarea>
                            </td>
                            <td class="as-description">
                                <?php _e('Write the text or the HTML.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Left', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-left" type="number" min="0" value="<?php echo ($void) ? '0' : (isset($element->data_left) ? $element->data_left : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Left distance in px from the start width.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Top', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-top" type="number" min="0" value="<?php echo ($void) ? '0' : (isset($element->data_top) ? $element->data_top : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Top distance in px from the start height.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Z - index', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-z-index" type="number" min="0" value="<?php echo ($void) ? '1' : (isset($element->z_index) ? $element->z_index : '1'); ?>" onkeypress="return isNumberKey(event);" />
                            </td>
                            <td class="as-description">
                                <?php _e('An element with an high z-index will cover an element with a lower z-index if they overlap.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-txt-animation-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e( 'Delay', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-delay" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_delay) ? $element->data_delay : '300') ; ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the element wait before the entrance. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Time', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-time" type="text" value="<?php echo ($void) ? 'all' : (isset($element->data_time) ? $element->data_time : 'all'); ?>" />&nbsp;<?php _e('ms', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element be displayed during the slide execution. Write "all" to set the entire time. Default:all', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('In Animation', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-in">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_in) && $element->data_in == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="as-description">
                                <?php _e('The in animation of the element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Out Animation', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-out">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_out) && $element->data_out == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br />
                                <label><input class="as-element-data-ignoreEaseOut" type="checkbox" <?php echo (!$void && isset($element->data_ignoreEaseOut) && $element->data_ignoreEaseOut) ? 'checked="checked"' : '' ?> /><?php _e('Disable synchronization with slide out animation', AVARTANLITESLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('The out animation of the element.<br /><br />Disable synchronization with slide out animation: if not checked, the slide out animation won\'t start until all the elements that have this option unchecked are animated out.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Ease In', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeIn" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_easeIn) ? $element->data_easeIn : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the in animation take. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Ease Out', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeOut" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_easeOut) ? $element->data_easeOut : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the out animation take. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-txt-advanced-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('ID', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-id" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_id) ? $element->attr_id : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add ID attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Classes', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-class" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_class) ? $element->attr_class : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Class attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Title', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-title" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_title) ? $element->attr_title : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Title attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Rel', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-rel" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_rel) ? $element->attr_rel : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Rel attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link" type="text" value="<?php echo ($void) ? '' : (isset($element->link) ? stripslashes($element->link) : ''); ?>" />
                                <br />
                                <label><input class="as-element-link-new-tab" type="checkbox" <?php echo (!$void && isset($element->link_new_tab) && $element->link_new_tab) ? 'checked="checked"' : '';  ?> /><?php _e('Open link in a new tab', AVARTANLITESLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Open the link (e.g.: http://avartanslider.com) on click. Leave it empty if you don\'t want it.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Custom CSS', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <textarea class="as-element-custom-css"><?php echo ($void) ? '' : (isset($element->custom_css) ? stripslashes($element->custom_css) : ''); ?></textarea>
                            </td>
                            <td class="as-description">
                                <?php _e('Style the element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	<?php
    }
}

/**
 * Print Image Element
 *  
 * @param array $element image element information
 * 
 * @param integer $ele_no element number
*/
if(!function_exists('avartansliderPrintImageElement'))
{
    function avartansliderPrintImageElement($element, $ele_no = null) {
	$void = !$element ? true : false;
	
        //Default Transition
	$animations = array(
		'slideDown' => array(__('Slide Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideUp' => array(__('Slide Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideLeft' => array(__('Slide Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideRight' => array(__('Slide Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fade' => array(__('Fade', AVARTANLITESLIDER_TEXTDOMAIN), true),
		'fadeDown' => array(__('Fade Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeUp' => array(__('Fade Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeLeft' => array(__('Fade Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeRight' => array(__('Fade Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallDown' => array(__('Fade Small Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallUp' => array(__('Fade Small Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallLeft' => array(__('Fade Small Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallRight' => array(__('Fade Small Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
	);
	
	?>
        <div class="as-element-pro-tab as-tabs">
            <ul class="as-element-pro-tab-ul ui-tabs-nav">
                <li class="">
                    <a  class="as-button as-is-navy as-is-active" href="javascript:void(0);" data-href=".as-ele-img-general-parameter"><?php _e('General Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-img-animation-parameter"><?php _e('Animation Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-img-advanced-parameter"><?php _e('Advanced Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
            </ul>
            <div class="as-element-type-block as-ele-img-general-parameter" style="display: block;">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
			<tr>
				<td class="as-name"><?php _e( 'Modify Image', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
				<td class="as-content">
                                    <input data-width="<?php echo ($void) ? '' : (isset($element->image_width) ? $element->image_width : ''); ?>" data-height="<?php echo ($void) ? '' : (isset($element->image_height) ? $element->image_height : ''); ?>" data-src="<?php echo ($void) ? '' : (isset($element->image_src) ? $element->image_src : ''); ?>" data-title="<?php echo ($void) ? '' : (isset($element->image_title) ? $element->image_title : ''); ?>" class="as-image-element-upload-button as-button as-is-default" type="button" value="<?php _e( 'Open Gallery', AVARTANLITESLIDER_TEXTDOMAIN ) ?>" />
				</td>
				<td class="as-description">
					<?php _e( 'Change the image source or the alt text.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
				</td>
			</tr>
                        <tr>
				<td class="as-name"><?php _e( 'Image Alt', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
				<td class="as-content">
                                    <input class="as-element-image-alt" type="text" value="<?php echo ($void) ? '' : (isset($element->image_alt) ? trim($element->image_alt) : ''); ?>" />
				</td>
				<td class="as-description">
					<?php _e( 'Add image alt text.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
				</td>
			</tr>
                        <tr>
                                <td class="as-name as-label-for" data-label-for=".as-element-image-scale"><?php _e( 'Scale Proportional', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
				<td class="as-content">
                                    <input class="as-element-image-scale" type="checkbox" value="Y" <?php echo (!$void && isset($element->image_scale) && $element->image_scale == 'Y') ? 'checked="checked"' : ''; ?> />
				</td>
				<td class="as-description">
					<?php _e( 'An element with Scale Proportional will scalling width and height with respect to slider width and height.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
				</td>
			</tr>
			<tr>
                            <td class="as-name"><?php _e( 'Left', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-left" type="number" min="0" value="<?php echo ($void) ? '0' : (isset($element->data_left) ? $element->data_left : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Left distance in px from the start width.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Top', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-top" type="number" min="0" value="<?php echo ($void) ? '0' : (isset($element->data_top) ? $element->data_top : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Top distance in px from the start height.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Z - index', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-z-index" type="number" min="0" value="<?php echo ($void) ? '1' : (isset($element->z_index) ? $element->z_index : '1'); ?>" onkeypress="return isNumberKey(event);" />
                            </td>
                            <td class="as-description">
                                <?php _e('An element with an high z-index will cover an element with a lower z-index if they overlap.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-img-animation-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
			<tr>
                            <td class="as-name"><?php _e( 'Delay', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-delay" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_delay) ? $element->data_delay : '300') ; ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the element wait before the entrance. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Time', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-time" type="text" value="<?php echo ($void) ? 'all' : (isset($element->data_time) ? $element->data_time : 'all'); ?>" />&nbsp;<?php _e('ms', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element be displayed during the slide execution. Write "all" to set the entire time. Default:all', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('In Animation', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-in">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_in) && $element->data_in == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="as-description">
                                <?php _e('The in animation of the element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Out Animation', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-out">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_out) && $element->data_out == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br />
                                <label><input class="as-element-data-ignoreEaseOut" type="checkbox" <?php echo (!$void) ? 'checked="checked"' : '' ?> /><?php _e('Disable synchronization with slide out animation', AVARTANLITESLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('The out animation of the element.<br /><br />Disable synchronization with slide out animation: if not checked, the slide out animation won\'t start until all the elements that have this option unchecked are animated out.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Ease In', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeIn" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_easeIn) ? $element->data_easeIn : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the in animation take. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Ease Out', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeOut" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_easeOut) ? $element->data_easeOut : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the out animation take. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-img-advanced-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('ID', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-id" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_id) ? $element->attr_id : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add ID attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Classes', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-class" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_class) ? $element->attr_class : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Class attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Title', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-title" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_title) ? $element->attr_title : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Title attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Rel', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-rel" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_rel) ? $element->attr_rel : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Rel attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link" type="text" value="<?php echo ($void) ? '' : (isset($element->link) ? stripslashes($element->link) : ''); ?>" />
                                <br />
                                <label><input class="as-element-link-new-tab" type="checkbox" <?php echo (!$void && isset($element->link_new_tab) && $element->link_new_tab) ? 'checked="checked"' : '';  ?> /><?php _e('Open link in a new tab', AVARTANLITESLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Open the link (e.g.: http://www.google.com) on click. Leave it empty if you don\'t want it.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Custom CSS', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <textarea class="as-element-custom-css"><?php echo ($void) ? '' : (isset($element->custom_css) ? stripslashes($element->custom_css) : ''); ?></textarea>
                            </td>
                            <td class="as-description">
                                <?php _e('Style the element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	<?php
    }
}

/**
 * Print Video Element
 *  
 * @param array $element video element information
 * 
 * @param integer $ele_no element number
*/
if(!function_exists('avartansliderPrintVideoElement'))
{
    function avartansliderPrintVideoElement($element, $slide_index = 0, $ele_no = null) {
	$void = !$element ? true : false;
	$animations = array(
		'slideDown' => array(__('Slide Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideUp' => array(__('Slide Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideLeft' => array(__('Slide Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'slideRight' => array(__('Slide Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fade' => array(__('Fade', AVARTANLITESLIDER_TEXTDOMAIN), true),
		'fadeDown' => array(__('Fade Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeUp' => array(__('Fade Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeLeft' => array(__('Fade Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeRight' => array(__('Fade Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallDown' => array(__('Fade Small Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallUp' => array(__('Fade Small Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallLeft' => array(__('Fade Small Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
		'fadeSmallRight' => array(__('Fade Small Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
	);
	
	?>
        <div class="as-element-pro-tab as-tabs">
            <ul class="as-element-pro-tab-ul ui-tabs-nav">
                <li class="">
                    <a  class="as-button as-is-navy as-is-active" href="javascript:void(0);" data-href=".as-ele-video-general-parameter"><?php _e('General Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-video-animation-parameter"><?php _e('Animation Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-video-advanced-parameter"><?php _e('Advanced Parameter', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                </li>
            </ul>
            <div class="as-element-type-block as-ele-video-general-parameter" style="display: block;">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
			<tr>
				<td class="as-name"><?php _e('Choose Video Type ', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
				<td class="as-content">
                                    <ul class="nav nav-pills" role="tablist">
                                        <li class="<?php echo ($void || (!$void && isset($element->video_type) && ($element->video_type == 'Y' || $element->video_type == ''))) ? 'as-active-type' : ''  ?>" role="Video"><a href="javascript:void(0);" class="as-element-video-type as-youtube"><?php _e('Youtube', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
                                        <li class="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? 'as-active-type' : ''  ?>" role="Video"><a href="javascript:void(0);" class="as-element-video-type as-vimeo"><?php _e('Vimeo', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
                                        <li class="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'H') ? 'as-active-type' : ''  ?>" role="Video"><a href="javascript:void(0);" class="as-element-video-type as-html5"><?php _e('HTML5', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
                                    </ul>
				</td>
				<td class="as-description">
					<?php _e('Choose video type ', AVARTANLITESLIDER_TEXTDOMAIN); ?>
				</td>
			</tr>
                        <?php
                        $youtube_style = $vimeo_style = $html5_style = '';
                        if((!$void && isset($element->video_type) && $element->video_type=='Y') || $void) {
                            $youtube_style = 'style="display:table-row;"';
                        }
                        else if(!$void && isset($element->video_type) && $element->video_type=='V') {
                            $vimeo_style = 'style="display:table-row;"';
                        }
                        else if(!$void && isset($element->video_type) && $element->video_type=='H') {
                            $html5_style = 'style="display:table-row;"';
                        }
                        ?>
                        <!-- Youtube block start -->
                        <tr class="as-youtube-search as-video-search" <?php echo $youtube_style; ?>>
                            <td class="as-name"><?php _e('Enter Youtube ID or URL ', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-youtube-video-link as-width-big" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='Y') ? (isset($element->video_link) ? trim($element->video_link) : '') : ''  ?>" />
                                <a href="javascript:void(0);" class="as-button as-is-primary as-search-youtube-video"><?php _e('Search', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                            </td>
                            <td class="as-description">
                                <?php _e('example: iNJdPyoqt8U ', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <tr class="as-video-block as-youtube-option" <?php echo (!$void) ? $youtube_style : ''; ?>>
                            <td class="as-name as-label-for" data-label-for=".as-element-video-full-width"><?php _e('Full Width', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <?php
                                $yt_full_width = $video_wh = '';

                                if(!$void && isset($element->video_type) && $element->video_type == 'Y' && isset($element->video_full_width) && $element->video_full_width == 'Y')
                                {
                                    $yt_full_width = 'checked="checked"';
                                    $video_wh = 'style="display:none;"';
                                }
                                ?>

                                <input class="as-element-video-full-width" type="checkbox" value="Y" <?php echo $yt_full_width; ?> />

                                <!-- video width -->
                                    <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e( 'Width', AVARTANLITESLIDER_TEXTDOMAIN ); ?> &nbsp;&nbsp;<input class="as-element-video-width" type="number" min="0" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_width) ? $element->video_width : '320') : '320' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?></label>
                                    
                                    <!-- video height -->
                                    <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e( 'Height', AVARTANLITESLIDER_TEXTDOMAIN ); ?> &nbsp;&nbsp;<input class="as-element-video-height" type="number" min="0" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_height) ? $element->video_height : '240') : '240' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Checked full width checkbox for get full width video which will neglate width and height which you have enter. If full width is not checked then video will take width and height from textbox.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="as-video-block as-youtube-option" <?php echo (!$void) ? $youtube_style : ''; ?>>
                            <td class="as-name"><?php _e('Set Preview image', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-preview-image-element-upload-button as-button as-is-primary" data-src="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_preview_img_src) ? $element->video_preview_img_src : '') : '' ?>" data-alt="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_preview_img_alt) ? $element->video_preview_img_alt : '') : '' ?>" data-title="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_preview_img_title) ? $element->video_preview_img_title : '') : '' ?>" data-is-preview="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_is_preview_set) ? $element->video_is_preview_set : '') : '' ?>" type="button" value="<?php _e( 'Set Preview', AVARTANLITESLIDER_TEXTDOMAIN ) ?>" />&nbsp;&nbsp;
                                <input class="as-remove-preview-image-element-upload-button as-button as-is-danger" type="button" value="<?php _e('Remove Preview', AVARTANLITESLIDER_TEXTDOMAIN) ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Set the preivew image for video and remove preview image on select remove preview button.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <!-- Youtube block end -->
                        
                        <!-- Vimeo block start -->
			<tr class="as-vimeo-search as-video-search" <?php echo $vimeo_style; ?>>
                            <td class="as-name"><?php _e('Enter Vimeo ID or URL ', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-vimeo-video-link as-width-big" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='V') ? (isset($element->video_link) ? $element->video_link : '') : '' ?>" />
                                <a href="javascript:void(0);" class="as-button as-is-primary as-search-vimeo-video"><?php _e('Search', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                            </td>
                            <td class="as-description">
                                <?php _e('example: 35545973 ', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        
                        <tr class="as-video-block as-vimeo-option" <?php echo $vimeo_style; ?>>
                            <td class="as-name as-label-for" data-label-for=".as-element-video-full-width"><?php _e('Full Width', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <?php
                                $vm_full_width = $video_wh = '';

                                if(!$void && isset($element->video_type) && $element->video_type == 'V' && isset($element->video_full_width) && $element->video_full_width == 'Y')
                                {
                                    $vm_full_width = 'checked="checked"';
                                    $video_wh = 'style="display:none;"';
                                }
                                ?>

                                <input class="as-element-video-full-width" type="checkbox" value="Y" <?php echo $vm_full_width; ?> />

                                <!-- video width -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e( 'Width', AVARTANLITESLIDER_TEXTDOMAIN ); ?> &nbsp;&nbsp;<input class="as-element-video-width" type="number" min="0" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_width) ? $element->video_width : '320') : '320' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?></label>

                                <!-- video height -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e( 'Height', AVARTANLITESLIDER_TEXTDOMAIN ); ?> &nbsp;&nbsp;<input class="as-element-video-height" type="number" min="0" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_height) ? $element->video_height : '240') : '240' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Checked full width checkbox for get full width video which will neglate width and height which you have enter. If full width is not checked then video will take width and height from textbox.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="as-video-block as-vimeo-option" <?php echo $vimeo_style; ?>>
                            <td class="as-name"><?php _e('Set Preview image', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-preview-image-element-upload-button as-button as-is-primary" data-src="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_preview_img_src) ? $element->video_preview_img_src : '') : '' ?>" data-alt="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_preview_img_alt) ? $element->video_preview_img_alt : '') : '' ?>" data-title="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_preview_img_title) ? $element->video_preview_img_title : '') : '' ?>" data-is-preview="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_is_preview_set) ? $element->video_is_preview_set : '') : '' ?>" type="button" value="<?php _e( 'Set Preview', AVARTANLITESLIDER_TEXTDOMAIN ) ?>" />&nbsp;&nbsp;
                                <input class="as-remove-preview-image-element-upload-button as-button as-is-danger" type="button" value="<?php _e('Remove Preview', AVARTANLITESLIDER_TEXTDOMAIN) ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Set the preivew image for video and remove preview image on select remove preview button.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <!-- Vimeo block end -->
                        
                        <!-- Html5 block start -->
                        <tr class="html5_search as-video-search" <?php echo $html5_style; ?>>
                            <td class="as-name"><?php _e('Enter Poster Image Url', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-html5-poster-url as-width-big" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='H') ? (isset($element->video_html5_poster_url) ? $element->video_html5_poster_url : '') : '' ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Example: http://video-js.zencoder.com/oceans-clip.png', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="html5_search as-video-search" <?php echo $html5_style; ?>>
                            <td class="as-name as-no-border"><?php _e('Enter MP4 Url', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content as-no-border">
                                <input class="as-element-html5-mp4-video-link as-width-big" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='H') ? (isset($element->video_html5_mp4_video_link) ? $element->video_html5_mp4_video_link : '') : '' ?>" />
                            </td>
                            <td class="as-description as-no-border">
                                <?php _e('Example: http://video-js.zencoder.com/oceans-clip.mp4', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="html5_search as-video-search" <?php echo $html5_style; ?>>
                            <td class="as-name as-no-border"><?php _e('Enter WEBM Url', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content as-no-border">
                                <input class="as-element-html5-webm-video-link as-width-big" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='H') ? (isset($element->video_html5_webm_video_link) ? $element->video_html5_webm_video_link : '') : '' ?>" />
                            </td>
                            <td class="as-description as-no-border">
                                <?php _e('Example: http://video-js.zencoder.com/oceans-clip.webm', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="html5_search as-video-search" <?php echo $html5_style; ?>>
                            <td class="as-name"><?php _e('Enter OGV Url', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-html5-ogv-video-link as-width-big" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='H') ? (isset($element->video_html5_ogv_video_link) ? $element->video_html5_ogv_video_link : '') : '' ?>" />
                                <br/>
                                <a href="javascript:void(0);" class="as-button as-is-primary search_html5_video mt5"><?php _e('Search', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                            </td>
                            <td class="as-description">
                                <?php _e('Example: http://video-js.zencoder.com/oceans-clip.ogv', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        
                        <tr class="as-video-block as-html5-option" <?php echo $html5_style; ?>>
                            <td class="as-name as-label-for" data-label-for=".as-element-video-full-width"><?php _e('Full Width', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <?php
                                $h5_full_width = $video_wh = '';

                                if(!$void && isset($element->video_type) && $element->video_type == 'H' && isset($element->video_full_width) && $element->video_full_width == 'Y')
                                {
                                    $h5_full_width = 'checked="checked"';
                                    $video_wh = 'style="display:none;"';
                                }
                                ?>

                                <input class="as-element-video-full-width" type="checkbox" value="Y" <?php echo $h5_full_width; ?> />

                                <!-- video width -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e( 'Width', AVARTANLITESLIDER_TEXTDOMAIN ); ?> &nbsp;&nbsp;<input class="as-element-video-width" type="number" min="0" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'H') ? (isset($element->video_width) ? $element->video_width : '320') : '320' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?></label>

                                <!-- video height -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e( 'Height', AVARTANLITESLIDER_TEXTDOMAIN ); ?> &nbsp;&nbsp;<input class="as-element-video-height" type="number" min="0" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'H') ? (isset($element->video_height) ? $element->video_height : '240') : '240' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Checked full width checkbox for get full width video which will neglate width and height which you have enter. If full width is not checked then video will take width and height from textbox.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <!-- Html5 block end -->
                        
                        <tr>
                            <td class="as-name"><?php _e( 'Left', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-left" type="number" min="0" value="<?php echo ($void) ? '0' : (isset($element->data_left) ? $element->data_left : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Left distance in px from the start width.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Top', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-top" type="number" min="0" value="<?php echo ($void) ? '0' : (isset($element->data_top) ? $element->data_top : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'px', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Top distance in px from the start height.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Z - index', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-z-index" type="number" min="0" value="<?php echo ($void) ? '1' : (isset($element->z_index) ? $element->z_index : '1'); ?>" onkeypress="return isNumberKey(event);" />
                            </td>
                            <td class="as-description">
                                <?php _e('An element with an high z-index will cover an element with a lower z-index if they overlap.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-video-animation-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
			<tr>
                            <td class="as-name"><?php _e( 'Delay', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-delay" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_delay) ? $element->data_delay : '300') ; ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the element wait before the entrance. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Time', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-time" type="text" value="<?php echo ($void) ? 'all' : (isset($element->data_time) ? $element->data_time : 'all') ?>" />&nbsp;<?php _e('ms', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element be displayed during the slide execution. Write "all" to set the entire time. Default:all', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('In Animation', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-in">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_in) && $element->data_in == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="as-description">
                                <?php _e('The in animation of the element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Out Animation', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-out">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_out) && $element->data_out == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br />
                                <label><input class="as-element-data-ignoreEaseOut" type="checkbox" <?php echo (!$void) ? 'checked="checked"' : '' ?> /><?php _e('Disable synchronization with slide out animation', AVARTANLITESLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('The out animation of the element.<br /><br />Disable synchronization with slide out animation: if not checked, the slide out animation won\'t start until all the elements that have this option unchecked are animated out.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Ease In', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeIn" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_easeIn) ? $element->data_easeIn : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the in animation take. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Ease Out', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeOut" type="number" min="0" value="<?php echo ($void) ? '300' : (isset($element->data_easeOut) ? $element->data_easeOut : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                            <td class="as-description">
                                <?php _e( 'How long will the out animation take. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-video-advanced-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('ID', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-id" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_id) ? $element->attr_id : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add ID attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Classes', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-class" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_class) ? $element->attr_class : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Class attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Title', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-title" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_title) ? $element->attr_title : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Title attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Rel', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-rel" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_rel) ? $element->attr_rel : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Rel attribute to element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link" type="text" value="<?php echo ($void) ? '' : (isset($element->link) ? stripslashes($element->link) : ''); ?>" />
                                <br />
                                <label><input class="as-element-link-new-tab" type="checkbox" <?php echo (!$void && isset($element->link_new_tab) && $element->link_new_tab) ? 'checked="checked"' : '';  ?> /><?php _e('Open link in a new tab', AVARTANLITESLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Open the link (e.g.: http://www.google.com) on click. Leave it empty if you don\'t want it.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Custom CSS', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <textarea class="as-element-custom-css"><?php echo ($void) ? '' : (isset($element->custom_css) ? stripslashes($element->custom_css) : '')?></textarea>
                            </td>
                            <td class="as-description">
                                <?php _e('Style the element.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	<?php
    }
}
?>