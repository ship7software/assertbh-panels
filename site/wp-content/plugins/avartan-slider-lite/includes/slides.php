<?php
if( !defined( 'ABSPATH') ) exit();

/**
 * Prints a slide. If the ID is not false, prints the values from MYSQL database, else prints a slide with default values.
 * 
 * @param array $slider Contains the slider information
 * 
 * @param array $slide Contains the slide information
 * 
 * @param boolean $edit variable because the elements.php file has to see it
*/
if(!function_exists('avartansliderPrintSlide'))
{
    function avartansliderPrintSlide($slider, $slide, $edit) {
    if($edit)
        $void = !$slide ? true : false;	
        $params = array();
        $slide_id = 0;
        if($slide){
            $params = maybe_unserialize( $slide->params );
            $slide_id = $slide->id;
        }
        //Default transition
        $animations = array(
                'fade' => array(__('Fade', AVARTANLITESLIDER_TEXTDOMAIN), true),
                'fadeLeft' => array(__('Fade Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'fadeRight' => array(__('Fade Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'slideLeft' => array(__('Slide Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'slideRight' => array(__('Slide Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'slideUp' => array(__('Slide Up', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'slideDown' => array(__('Slide Down', AVARTANLITESLIDER_TEXTDOMAIN), false),
        );

        // Slide selection box options
        $slide_select_options = array(
            'position' => array(
                'center top' => array(__('center top', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'center right' => array(__('center right', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'center bottom' => array(__('center bottom', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'center center' => array(__('center center', AVARTANLITESLIDER_TEXTDOMAIN), true),
                'left top' => array(__('left top', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'left center' => array(__('left center', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'left bottom' => array(__('left bottom', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'right top' => array(__('right top', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'right center' => array(__('right center', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'right bottom' => array(__('right bottom', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'percentage' => array(__('(x%, y%)', AVARTANLITESLIDER_TEXTDOMAIN), false),
            ),
            'size' => array(
                'cover' => array(__('cover', AVARTANLITESLIDER_TEXTDOMAIN), true),
                'contain' => array(__('contain', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'percentage' => array(__('percentage', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'normal' => array(__('normal', AVARTANLITESLIDER_TEXTDOMAIN), false),
            ),
            'repeat' => array(
                'no-repeat' => array(__('No Repeat', AVARTANLITESLIDER_TEXTDOMAIN), true),
                'repeat' => array(__('Repeat', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'repeat-x' => array(__('Repeat-x', AVARTANLITESLIDER_TEXTDOMAIN), false),
                'repeat-y' => array(__('Repeat-y', AVARTANLITESLIDER_TEXTDOMAIN), false),
            )
        );

        /*
         * Slide block start
         */
        ?>
        <h4 class="ad-s-setting-head"><?php _e('Slide General Options', AVARTANLITESLIDER_TEXTDOMAIN); ?>
            <a class="as-right as-button as-is-primary as-export-slide as-is-temp-disabled as-pro-version" href="javascript:void(0);"><span class="dashicons dashicons-share-alt2 mr5"></span><?php _e( 'Export Slide', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
            <a class="as-right as-button as-is-primary as-copy-move-slide as-is-temp-disabled as-pro-version" href="javascript:void(0);"><span class="dashicons dashicons-image-rotate-right mr5"></span><?php _e( 'Copy & Move Slide', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
            <a class="as-right as-button as-is-primary as-duplicate-slide as-is-temp-disabled as-pro-version" href="javascript:void(0);"><span class="dashicons dashicons-images-alt mr5"></span><?php _e('Duplicate Slide', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
            <a class="as-right as-button as-is-success as-save-slide" data-slide-id="<?php echo $slide_id ?>" href="javascript:void(0);"><span class="dashicons dashicons-feedback mr5"></span><?php _e( 'Save Slide', AVARTANLITESLIDER_TEXTDOMAIN ); ?></a>
        </h4>
        <div class="ad-s-setting-content">
            <table class="as-slide-settings-list as-table">
                <tbody>
                        <tr>
                                <td class="as-name"><?php _e( 'Slide Name', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                                <td class="as-content">
                                    <input class="as-slide-name-txt as-is-temp-disabled as-pro-version" readonly="readonly" type="text" value="<?php echo _e( 'Slide', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" />
                                </td>
                                <td class="as-description">
                                        <?php _e( 'Enter your favorite slide name. Default : Slide', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Background Color', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <form> 
                                    <select class="as-slide-background-type-color as-toggle-options" data-option=".as-slide-bgcolor">
                                        <option value="0" <?php echo (!isset($params['background_type_color']) || (isset($params['background_type_color']) && $params['background_type_color'] == 'transparent'))?'selected="selected"' : '' ?>><?php _e( 'Transparent', AVARTANLITESLIDER_TEXTDOMAIN ); ?></option>
                                        <option value="1" <?php echo (isset($params['background_type_color']) && $params['background_type_color'] != '' && $params['background_type_color'] != 'transparent') ? 'selected="selected"' : '' ?>><?php _e( 'Background Color', AVARTANLITESLIDER_TEXTDOMAIN ); ?></option>
                                    </select>

                                    <?php $display_slidebg = ((!isset($params['background_type_color']) || (isset($params['background_type_color']) && $params['background_type_color'] == 'transparent')) ? 'style="display:none";' : 'style="display:block";'); ?>
                                    <div class="as-toggle as-slide-bgcolor" <?php echo $display_slidebg; ?>>
                                        <input type="text" value="<?php echo (isset($params['background_type_color']) && $params['background_type_color'] != 'transparent') ? $params['background_type_color'] : ''; ?>" class="as-slide-background-type-color-picker-input" data-alpha="true" data-custom-width="0" />
                                    </div>

                                </form>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Set Background color in slide if image is none or image type is png.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Background Image', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <form> 
                                    <select class="as-slide-background-type-image as-toggle-options" data-option=".as-slide-bgimg">
                                        <option value="0" <?php echo (!isset($params['background_type_image']) || (isset($params['background_type_image']) && ($params['background_type_image'] == 'none' || $params['background_type_image'] == 'undefined'))) ?'selected="selected"' : '' ?>><?php _e( 'None', AVARTANLITESLIDER_TEXTDOMAIN ); ?></option>
                                        <option value="1" <?php echo ((isset($params['background_type_image']) && $params['background_type_image'] != 'none' && $params['background_type_image'] != 'undefined')) ? 'selected="selected"' : '' ?>><?php _e( 'Background Image', AVARTANLITESLIDER_TEXTDOMAIN ); ?></option>
                                    </select>

                                    <?php $display_slidebgimg = ((!isset($params['background_type_image']) || (isset($params['background_type_image']) && ($params['background_type_image'] == 'none' || $params['background_type_image'] == 'undefined'))) ? 'style="display:none";' : 'style="display:block";'); ?>
                                    <div class="as-slide-bgimg as-toggle" <?php echo $display_slidebgimg; ?>>
                                        <input class="as-slide-background-type-image-upload-button as-button as-is-default" type="button" value="<?php _e( 'Select Image', AVARTANLITESLIDER_TEXTDOMAIN ); ?>" />
                                    </div>
                                </form>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Set Background image to slide. Background color will be ignore if image type is not png.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Background Position', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <form>
                                    <select class="as-slide-background-position" name="as-slide-background-position">
                                        <?php
                                        foreach ($slide_select_options['position'] as $key => $value) {
                                            echo '<option value="' . $key . '"';
                                            if ((!$edit && $value[1]) || ($edit && !isset($params['background_property_position']) && $value[1]) || ($edit && isset($params['background_property_position']) && $params['background_property_position'] == $key)) {
                                                echo ' selected="selected"';
                                            }
                                            echo '>' . $value[0] . '</option>';
                                        }
                                        ?> 
                                    </select>
                                    <?php
                                    $disp_position = "display:none;";
                                    if (isset($params['background_property_position']) && $params['background_property_position'] == 'percentage') {
                                        $disp_position = "display:inline;";
                                    }
                                    ?>
                                    <input type="number" min="0" max="100" style="<?php echo $disp_position; ?>" value="<?php echo (isset($params['background_property_position']) && $params['background_property_position'] == 'percentage' && isset($params['background_property_position_x'])) ? $params['background_property_position_x'] : '0'; ?>" class="as-background-position as-slide-background-position-x" name="bg_position_x" onkeypress="return isNumberKey(event);" />
                                    <input type="number" min="0" max="100" style="<?php echo $disp_position; ?>" value="<?php echo (isset($params['background_property_position']) && $params['background_property_position'] == 'percentage' && isset($params['background_property_position_y'])) ? $params['background_property_position_y'] : '0'; ?>" class="as-background-position as-slide-background-position-y" name="bg_position_y" onkeypress="return isNumberKey(event);" />
                                </form>    
                            </td>
                            <td class="as-description">
                                <?php _e( 'Set backgound image position. Default : center center', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Background Repeat', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <form>                                                
                                    <select name="as-slide-background-repeat" class="as-slide-background-repeat">
                                        <?php
                                        foreach ($slide_select_options['repeat'] as $key => $value) {
                                            echo '<option value="' . $key . '"';
                                            if ((!$edit && $value[1]) || ($edit && !isset($params['background_repeat']) && $value[1]) || ($edit && isset($params['background_repeat']) && $params['background_repeat'] == $key)) {
                                                echo ' selected="selected"';
                                            }
                                            echo '>' . $value[0] . '</option>';
                                        }
                                        ?> 
                                    </select>
                                </form>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Set backgound image repeat. Default : no-repeat', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Background Size', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <form>
                                    <select name="as-slide-background-property-size" class="as-slide-background-property-size">
                                        <?php
                                        foreach ($slide_select_options['size'] as $key => $value) {
                                            echo '<option value="' . $key . '"';
                                            if ((!$edit && $value[1]) || ($edit && !isset($params['background_property_size']) && $value[1]) || ($edit && isset($params['background_property_size']) && $params['background_property_size'] == $key)) {
                                                echo ' selected="selected"';
                                            }
                                            echo '>' . $value[0] . '</option>';
                                        }
                                        ?> 
                                    </select>
                                    <?php
                                    $disp_size = "display:none;";
                                    if (isset($params['background_property_size']) && $params['background_property_size'] == 'percentage') {
                                        $disp_size = "display:inline;";
                                    }
                                    ?>
                                    <input type="number" min="0" max="100" style="<?php echo $disp_size; ?>" value="<?php echo (isset($params['background_property_size']) && $params['background_property_size'] == 'percentage' && isset($params['background_property_size_x'])) ? $params['background_property_size_x'] : '100'; ?>" class="as-background-size as-slide-background-size-x" name="bg_size_x" onkeypress="return isNumberKey(event);"/>
                                    <input type="number" min="0" max="100" style="<?php echo $disp_size; ?>" value="<?php echo (isset($params['background_property_size']) && $params['background_property_size'] == 'percentage' && isset($params['background_property_size_y'])) ? $params['background_property_size_y'] : '100'; ?>" class="as-background-size as-slide-background-size-y" name="bg_size_y" onkeypress="return isNumberKey(event);"/>
                                </form>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Set backgound image position. Default : cover', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Color Overlay', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <form class="as-is-temp-disabled as-pro-version"> 
                                    <input type="text" value="" class="as-slide-background-color-overlay-picker-input" data-alpha="true" data-custom-width="0" />
                                </form>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Set color overlay on background image or color. Default : transparent', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e( 'Patterns Overlay', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                            <td class="as-content">
                                <form class="as-is-temp-disabled as-pro-version"> 
                                    <div class="as-pattern-wrap">
                                        <a class="as-pattern-selection as-pattern-img as-pattern-box" title="Select Pattern">
                                            <span class="pattern0"></span>
                                        </a>
                                    </div>
                                </form>
                            </td>
                            <td class="as-description">
                                <?php _e( 'Set Pattern overlay on background image or color. Default : none', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </td>
                        </tr>
                        <tr>
                                <td class="as-name"><?php _e( 'In Animation', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                                <td class="as-content">
                                        <select class="as-slide-data-in">
                                                <?php
                                                foreach($animations as $key => $value) {
                                                        echo '<option value="' . $key . '"';
                                                        if(($void && $value[1]) || (!$void && isset($params['data_in']) && $params['data_in'] == $key)) {
                                                                echo ' selected';
                                                        }
                                                        echo '>' . $value[0] . '</option>';
                                                }
                                                ?>
                                        </select>
                                </td>
                                <td class="as-description">
                                        <?php _e( 'The in animation of the slide.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                        </tr>
                        <tr>
                                <td class="as-name"><?php _e( 'Out Animation', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                                <td class="as-content">
                                        <select class="as-slide-data-out">
                                                <?php
                                                foreach($animations as $key => $value) {
                                                        echo '<option value="' . $key . '"';
                                                        if(($void && $value[1]) || (!$void && isset($params['data_out']) && $params['data_out'] == $key)) {
                                                                echo ' selected';
                                                        }
                                                        echo '>' . $value[0] . '</option>';
                                                }
                                                ?>
                                        </select>
                                </td>
                                <td class="as-description">
                                        <?php _e( 'The out animation of the slide.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                        </tr>
                        <tr>
                                <td class="as-name"><?php _e( 'Time', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                                <td class="as-content">
                                        <?php
                                        if($void) echo '<input class="as-slide-data-time" type="number" min="0" onkeypress="return isNumberKey(event);" value="9000" />';
                                        else echo '<input class="as-slide-data-time" type="number" min="0" onkeypress="return isNumberKey(event);" value="' . (isset($params['data_time'])?$params['data_time']:'9000') .'" />';
                                        ?>
                                        <?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                                <td class="as-description">
                                        <?php _e( 'The time that the slide will remain on the screen. Default : 9000ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                        </tr>
                        <tr>
                                <td class="as-name"><?php _e( 'Ease In', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                                <td class="as-content">
                                        <?php
                                        if($void) echo '<input class="as-slide-data-easeIn" type="number" min="0" onkeypress="return isNumberKey(event);" value="300" />';
                                        else echo '<input class="as-slide-data-easeIn" type="number" min="0" onkeypress="return isNumberKey(event);" value="' . (isset($params['data_easeIn'])?$params['data_easeIn']:'300') .'" />';
                                        ?>
                                        <?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                                <td class="as-description">
                                        <?php _e( 'The time that the slide will take to get in. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                        </tr>
                        <tr>
                                <td class="as-name"><?php _e( 'Ease Out', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                                <td class="as-content">
                                        <?php
                                        if($void) echo '<input class="as-slide-data-easeOut" type="number" min="0" onkeypress="return isNumberKey(event);" value="300" />';
                                        else echo '<input class="as-slide-data-easeOut" type="number" min="0" onkeypress="return isNumberKey(event);" value="' . (isset($params['data_easeOut'])?$params['data_easeOut']:'300') .'" />';
                                        ?>
                                        <?php _e( 'ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                                <td class="as-description">
                                        <?php _e( 'The time that the slide will take to get out. Default : 300ms', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                        </tr>
                        <tr>
                                <td class="as-name"><?php _e( 'Custom CSS', AVARTANLITESLIDER_TEXTDOMAIN ); ?></td>
                                <td class="as-content">
                                        <?php
                                        if($void) echo '<textarea class="as-slide-custom-css"></textarea>';
                                        else echo '<textarea class="as-slide-custom-css">' . (isset($params['custom_css'])?stripslashes($params['custom_css']):'') . '</textarea>';
                                        ?>
                                </td>
                                <td class="as-description">
                                        <?php _e( 'Apply CSS to the slide.', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                </td>
                        </tr>
                </tbody>
            </table>
        </div>

        <?php
        /*
         * Slide block end
         */

        // If the slide is not void, select her elements
        if(!$void) {
            global $wpdb;

            $elements = maybe_unserialize( $slide->layers );
        }
        else {
            $elements = NULL;
        }
        avartansliderPrintElements($edit, $slider, $slide);
    }
}
?>
<div id="as-slides">
    <div class="as-slide-tabs as-tabs as-tabs-border">
        <ul class="as-sortable as-slide-tab">
            <?php
            if($edit) {
                    $j = 0;
                    $slides_num = count($slides);
                    foreach($slides as $slide) {
                        $params = maybe_unserialize( $slide->params );
                        $a_disable = '';
                        $slide_publish = 'as-publish';
                        $publish_dashicon = 'dashicons-visibility';

                            if($j == $slides_num - 1) {
                                    echo '<li class="ui-state-default active">';
                                    echo '<a class="as-button as-is-navy as-is-active '. $a_disable .'">';
                            }
                            else {
                                    echo '<li class="ui-state-default">';
                                    echo '<a class="as-button as-is-navy '. $a_disable .'">';
                            }
                            echo '<span class="dashicons '. $publish_dashicon .' as-visibility as-is-temp-disabled as-pro-version '. $slide_publish .'"></span>';
                            echo  '<span class="as-slide-name"> #<span class="as-slide-index">' . (intval(trim($slide->position)) + 1) . '</span> <span class="as-slide-name-val">'. ((isset($params['slide_name']) && trim($params['slide_name']) != '') ? $params['slide_name'] : __( 'Slide', AVARTANLITESLIDER_TEXTDOMAIN )) . '</span></span>';
                            echo '<span class="dashicons dashicons-dismiss as-close"></span></a>';
                            echo '</li>';

                            $j++;
                    }
            }
            /* if($edit) {
                $j = 0;
                $slides_num = count($slides);
                foreach($slides as $slide) {
                    $params = maybe_unserialize( $slide->params );
                    if($j == $slides_num - 1) {
                        echo '<li class="ui-state-default active">';
                        echo '<a class="as-button as-is-navy as-is-active">';
                    }
                    else {
                        echo '<li class="ui-state-default">';
                        echo '<a class="as-button as-is-navy">';
                    }
                    echo  __('Slide', AVARTANLITESLIDER_TEXTDOMAIN) . ' <span class="as-slide-index">' . (intval(trim($slide->position)) + 1) . '</span>';
                    echo '<span class="dashicons dashicons-dismiss as-close"></span></a>';
                    echo '</li>';

                    $j++;
                }
            } */
            ?>
            <li class="ui-state-default ui-state-disabled">
                <a class="as-add-new as-button as-is-inverse"><?php _e('Add New Slide', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
            </li>
        </ul>

        <div class="as-slides-list">
            <?php
                if($edit) {
                    foreach($slides as $slide) {
                        echo '<div class="as-slide">';
                        avartansliderPrintSlide($slider, $slide, $edit);
                        echo '</div>';
                    }
                }
            ?>
        </div>		
        <div class="as-void-slide"><?php avartansliderPrintSlide($slider, false, $edit); ?></div>

        <div style="clear: both"></div>
    </div>
</div>