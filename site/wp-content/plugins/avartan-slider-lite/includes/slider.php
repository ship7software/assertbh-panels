<?php
if( !defined( 'ABSPATH') ) exit();
?>
<div id="as-slider-settings">  
    <?php
        //Get slider setting option
        $slider_option = array();
        if(isset($slider)){
            $slider_option = maybe_unserialize( $slider->slider_option );
        }
        
	// Contains the key, the display name and a boolean: true if is the default option
	$slider_select_options = array(
		'layout' => array(
			'full-width' => array(__('Full Width', AVARTANLITESLIDER_TEXTDOMAIN), false),
			'fixed' => array(__('Fixed', AVARTANLITESLIDER_TEXTDOMAIN), true),
		),
		'boolean' => array(
			1 => array(__('Yes', AVARTANLITESLIDER_TEXTDOMAIN), true),
			0 => array(__('No', AVARTANLITESLIDER_TEXTDOMAIN), false),
		),
                'shadow' => array(
                        'shadow1','shadow2','shadow3',
                ),
		'controls' => array(
                        'control1','control2','control3',
                        'control4','control5','control6',
                        'control7','control8','control9'
                ),
		'navigation' => array(
                        'navigation1','navigation2','navigation3',
                        'navigation4','navigation5','navigation6',
                        'navigation7','navigation8','navigation9',
                        'navigation10'
                ),
		'navDirection' => array(
                    'horizontal' => array(__('Horizontal', AVARTANLITESLIDER_TEXTDOMAIN), true),
                    'vertical' => array(__('Vertical', AVARTANLITESLIDER_TEXTDOMAIN), false),
                ),
                'navHPosition' => array(
                    'left' => array(__('Left', AVARTANLITESLIDER_TEXTDOMAIN), false),
                    'center' => array(__('Center', AVARTANLITESLIDER_TEXTDOMAIN), true),
                    'right' => array(__('Right', AVARTANLITESLIDER_TEXTDOMAIN), false),
                ),
                'navVPosition' => array(
                    'top' => array(__('Top', AVARTANLITESLIDER_TEXTDOMAIN), false),
                    'center' => array(__('Center', AVARTANLITESLIDER_TEXTDOMAIN), false),
                    'bottom' => array(__('Bottom', AVARTANLITESLIDER_TEXTDOMAIN), true),
                ),
		'loader' => array(
                        'loader1','loader2','loader3', 
                        'loader4','loader5','loader6',
                ),
	);
	?>
    <div class="ad-s-setting-content">
        <div class="main_slider_setting">
            <div class="as-slider-main-setting-block" id="as-slider-info">
                <div class="slider_name_block">
                    <label class="slider_title"><?php _e('Slider Name', AVARTANLITESLIDER_TEXTDOMAIN); ?> <span class="required">*</span></label>
                    <div class="slider_content">
                        <input type="text" id="as-slider-name" placeholder="<?php _e('Slider Name', AVARTANLITESLIDER_TEXTDOMAIN); ?>" value="<?php echo ($edit) ? $slider->name : ''; ?>" onkeypress="return isNotSpecialChar(event);" />
                    </div>
                </div>
                <div class="slider_alias_block">
                    <label class="slider_title"><?php _e('Alias', AVARTANLITESLIDER_TEXTDOMAIN); ?></label>
                    <div class="slider_content">
                        <input type="text" id="as-slider-alias" readonly="readonly" placeholder="<?php _e('Alias', AVARTANLITESLIDER_TEXTDOMAIN); ?>" value="<?php echo ($edit) ? $slider->alias : ''; ?>" />
                    </div>
                </div>
                <div class="slider_shortcode_block">
                    <label class="slider_title"><?php _e('Shortcode', AVARTANLITESLIDER_TEXTDOMAIN); ?></label>
                    <div class="slider_content">
                        <input type="text" id="as-slider-shortcode" readonly="readonly" onClick="this.select();" class="shortcode_selection" value="<?php echo (($edit) ? ('[avartanslider alias=\'' . $slider->alias . '\']') : ''); ?>" />                    
                    </div>
                </div>
                <div class="slider_shortcode_block as-no-margin">
                    <label class="slider_title"><?php _e('PHP Function', AVARTANLITESLIDER_TEXTDOMAIN); ?></label>
                    <div class="slider_content">
                        <input type="text" id="as-slider-php-function" readonly="readonly" onClick="this.select();" class="shortcode_selection" value="<?php echo ($edit) ? 'if(function_exists(\'avartanslider\')) avartanslider(\'' . $slider->alias . '\');' : ''; ?>" />                    
                    </div>
                </div>
            </div>            
        </div>   
        <div class="as-slider-settings-list">
            <table class="as-slider-setting-table">
                <tbody>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab as-is-active" data-slider-tab="#as-slider-general"><?php _e('General', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab" data-slider-tab="#as-slider-loader"><?php _e('Loader', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab" data-slider-tab="#as-slider-navigation"><?php _e('Navigation', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab as-is-temp-disabled as-pro-version"><?php _e('Timer Bar', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab as-is-temp-disabled as-pro-version"><?php _e('Mobile Visibility', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab as-is-temp-disabled as-pro-version"><?php _e('Callbacks', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                    </tr>
                </tbody>    
            </table>
        </div>
        <div class="as-slider-settings-wrapper">
            <h4 class="ad-s-setting-head"><?php _e('Slider Setting Options', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                <a class="as-button as-is-primary as-reset-slider-settings" data-reset-block="#as-slider-general" href="javascript:void(0);"><span class="dashicons dashicons-image-rotate mr5"></span><?php _e('Reset Settings', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                <a class="as-button as-is-success as-save-settings" href="javascript:void(0);" data-id="<?php echo $id; ?>"><span class="dashicons dashicons-feedback mr5"></span><?php _e('Save Settings', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
            </h4>
            
            <!-- Slider General info Start -->
            <table class="as-table as-slider-setting-block" id="as-slider-general" style="display: table;">
                <tbody>
                    <tr>
                        <td class="as-name"><?php _e('Layout', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-layout">
                                <?php
                                foreach ($slider_select_options['layout'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->layout) && $slider_option->layout == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Modify the layout type of the slider.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <?php $forceFullW = (isset($slider_option->layout) && $slider_option->layout == 'full-width') ? 'style="display:table-row;"' : 'style="display:none;"'; ?>
                    <tr class="as-full-width-block" <?php echo $forceFullW; ?>>
                        <td class="as-name"><?php _e('Force full width', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-forcefullwidth" class="as-is-temp-disabled as-pro-version">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';

                                    if (!$value[1]) {
                                        echo ' selected';
                                    }
                                    else {
                                        echo ' disabled';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('If yes then it will strech to slider up to window width otherwise not.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Layer Grid Size', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input id="as-slider-startWidth" type="number" min="0" onkeypress="return isNumberKey(event);" value="<?php echo ($edit && isset($slider_option->startWidth) ? $slider_option->startWidth : '1280') ?>" style="width: 80px;" />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>&nbsp;&nbsp;<strong>X</strong>&nbsp;&nbsp;
                            <input id="as-slider-startHeight" type="number" min="0" onkeypress="return isNumberKey(event);" value="<?php echo ($edit && isset($slider_option->startHeight) ? $slider_option->startHeight : '650') ?>" style="width: 80px;"  />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                        <td class="as-description">
                            <?php _e('The initial width & height of the slider.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Mobile Custom Size', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-mobileCustomSize" class="as-is-temp-disabled as-pro-version">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';

                                    if (!$value[1]) {
                                        echo ' selected';
                                    }
                                    else {
                                        echo ' disabled';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('If No, then Default Layer Grid Size is the basic of Linear Responsive calculations.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Automatic Slide', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-automaticSlide">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->automaticSlide) && $slider_option->automaticSlide == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('The slides loop is automatic.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Random Slide', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-randomSlide" class="as-is-temp-disabled as-pro-version">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if (!$value[1]) {
                                        echo ' selected';
                                    }
                                    else {
                                        echo ' disabled';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('The slide will be visible randomly.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Color', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content"> 
                            <select id="as-slider-background-type-color" class="as-toggle-options" name="as-slider-background-type-color" data-option="#as-slider-bgcolor">
                                <option value="0" <?php echo (!$edit || ($edit && isset($slider_option->background_type_color) && $slider_option->background_type_color == 'transparent')) ? 'selected="selected"' : '' ?>><?php _e('Transparent', AVARTANLITESLIDER_TEXTDOMAIN); ?></option>
                                <option value="1" <?php echo ($edit && isset($slider_option->background_type_color) && $slider_option->background_type_color != '' && $slider_option->background_type_color != 'transparent') ? 'selected="selected"' : '' ?>><?php _e('Background Color', AVARTANLITESLIDER_TEXTDOMAIN); ?></option>
                            </select>
                            <?php $display_bgcolor = ((!$edit || ($edit && isset($slider_option->background_type_color) && $slider_option->background_type_color == 'transparent')) ? 'style="display:none"' : 'style="display:block"'); ?>
                            <div id="as-slider-bgcolor" class="as-toggle" <?php echo $display_bgcolor; ?>>
                                <input type="text" value="<?php echo ($edit && isset($slider_option->background_type_color) && $slider_option->background_type_color != '' && $slider_option->background_type_color != 'transparent') ? $slider_option->background_type_color : '' ?>" class="as-slider-background-type-color-picker-input" data-alpha="true" data-custom-width="0" />
                            </div>
                        </td>
                        <td class="as-description">
                            <?php _e('The background of slider.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr class="as-shadow-block">
                        <td class="as-name"><?php _e('Shadow', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content as-default-option-td">
                            <select id="as-slider-shadow-type" name="as-slider-shadow-type" class="as-toggle-options" data-option="#as-slider-shadow">
                                <option value="0" <?php echo (!$edit || (isset($slider_option->showShadowBar) && $slider_option->showShadowBar == '0')) ? 'selected="selected"' : '' ?>><?php _e('None', AVARTANLITESLIDER_TEXTDOMAIN); ?></option>
                                <option value="1" <?php echo ($edit && isset($slider_option->showShadowBar) && $slider_option->showShadowBar == '1')  ? 'selected="selected"' : '' ?> ><?php _e('Shadow', AVARTANLITESLIDER_TEXTDOMAIN); ?></option>
                            </select>
                            
                            <?php $display_shadow = ((!$edit || (isset($slider_option->showShadowBar) && $slider_option->showShadowBar == '0')) ? 'style="display:none"' : 'style="display:block"'); ?>
                            
                            <div id="as-slider-shadow" class="as-toggle" <?php echo $display_shadow; ?>>
                                <input class="as-slider-default-shadow as-button as-is-default" type="button" value="<?php _e('Select Default Shadow', AVARTANLITESLIDER_TEXTDOMAIN); ?>" data-shadow-class="<?php echo ($edit && isset($slider_option->showShadowBar) && $slider_option->showShadowBar == '1') ? $slider_option->shadowClass : 'shadow1'; ?>" />
                                <?php
                                $shadow_path = plugins_url() . '/avartanslider/images/shadow/';
                                ?>
                                <div class="as-default-option-wrapper as-shadow-list-wrapper">
                                    <table cellspacing="0" class="as-default-option-list as-shadow-list">
                                        <?php
                                        $total_shadow = count($slider_select_options['shadow']);
                                        if ($total_shadow > 0) {
                                            foreach ($slider_select_options['shadow'] as $shadow_val) {
                                                echo '<tr>';
                                                echo '<td class="';
                                                if ((!$edit && strtolower($shadow_val) == 'shadow1') || ($edit && isset($slider_option->shadowClass) && $slider_option->shadowClass == strtolower($shadow_val)) || ($edit && isset($slider_option->shadowClass) && trim($slider_option->shadowClass) == '' && strtolower($shadow_val) == 'shadow1')) {
                                                    echo ' active';
                                                }
                                                echo '"><img data-shadow-class="' . strtolower($shadow_val) . '" src="' . $shadow_path . strtolower($shadow_val) . '.png" /></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </td>
                        <td class="as-description">
                            <?php _e('Choose to display shadow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Pause on Hover', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-pauseOnHover">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->pauseOnHover) && $slider_option->pauseOnHover == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Pause the current slide when hovered.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Slider General info End -->

            <!-- Slider Loader info Start -->
            <table class="as-table as-slider-setting-block" id="as-slider-loader">
                <tbody>
                    <?php
                    //Get loaders Information
                    $loader_options = isset($slider_option->loader) ? $slider_option->loader : array();
                    $lEnable = 1;
                    $lType = ($edit && isset($slider_option->loader_type)) ? $slider_option->loader_type : (($edit && isset($loader_options->type)) ? $loader_options->type : 'default');
                    ?>
                    <tr>
                        <td class="as-name"><?php _e('Enable', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-enableLoader" class="as-is-temp-disabled as-pro-version">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ($value[1]) {
                                        echo ' selected';
                                    }
                                    else {
                                        echo ' disabled';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Enable/Disable loader on slider.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <?php
                    $loaderBlock = ($lEnable == 1) ? 'style="display:table-row;"' : 'style="display:none;"';
                    $loaderDef = ($lEnable == 1 && $lType == 'default') ? 'style="display:table-row;"' : 'style="display:none;"';
                    $loaderUpload = ($lEnable == 1 && $lType != 'default') ? 'style="display:table-row;"' : 'style="display:none;"';
                    $lStyle = ($edit && isset($slider_option->loaderClass)) ? trim($slider_option->loaderClass) : (($edit && isset($loader_options->style)) ? $loader_options->style : 'loader1');
                    ?>
                    <tr class="as-loader-block" <?php echo $loaderBlock; ?>>
                        <td class="as-name"><?php _e('Type', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-loaderType">
                                <option value="0" <?php echo $lType == 'default' ? 'selected="selected"' : '' ?> ><?php _e('Select Default Loader', AVARTANLITESLIDER_TEXTDOMAIN); ?></option>
                                <option value="1" <?php echo $lType != 'default' ? 'selected="selected"' : '' ?> ><?php _e('Upload New Loader Image', AVARTANLITESLIDER_TEXTDOMAIN); ?></option>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Select Loader Type.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr class="as-loader-def-block" <?php echo $loaderDef; ?>>
                        <td class="as-name"><?php _e('Style', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content as-default-option-td">
                            <a class="as-slider-default-loader as-button as-is-default as-change-style" href="javascript:void(0);" data-loader-style="<?php echo $lStyle; ?>"><?php _e('Change Loader Style', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                            <?php
                            $loader_path = plugins_url() . '/avartan-slider-lite/images/loaders/';
                            ?>
                            <div class="as-default-option-wrapper as-loader-list-wrapper">
                                <table cellspacing="0" class="as-default-option-list as-loader-list">
                                    <?php
                                    $loader_cnt = 0;
                                    $total_loaders = count($slider_select_options['loader']);
                                    if ($total_loaders > 0) {
                                        foreach ($slider_select_options['loader'] as $loader_val) {
                                            if (($loader_cnt == 0 || $loader_cnt % 2 == 0) && $loader_cnt != 1) {
                                                if ($loader_cnt != 0) {
                                                    echo '</tr>';
                                                }
                                                echo '<tr>';
                                            }
                                            $loader_cnt++;
                                            echo '<td class="';
                                            if ((!$edit && strtolower($loader_val) == 'loader1') || ($edit && $lStyle == strtolower($loader_val))) {
                                                echo ' active';
                                            }
                                            if ($total_loaders == $loader_cnt && $loader_cnt % 2 != 0) {
                                                echo ' border-right';
                                            }
                                            echo '"><img data-loader-style="' . strtolower($loader_val) . '" src="' . $loader_path . strtolower($loader_val) . '.gif" /></td>';

                                            if ($total_loaders == $loader_cnt) {
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                            </div>

                        </td>
                        <td class="as-description">
                            <?php _e('Change Loader style from default loader collection.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr class="as-loader-img-block" <?php echo $loaderUpload; ?>>
                        <td class="as-name"><?php _e('Style', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <a class="as-button as-is-default as-change-style as-upload-loader-img as-is-temp-disabled as-pro-version" href="javascript:void(0);"><?php _e('Change Loader Image', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                        </td>
                        <td class="as-description">
                            <?php _e('Upload new loader image.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Slider Loader info End -->
            
            <!-- Slider Navigation info Start -->
            <table class="as-table as-slider-setting-block" id="as-slider-navigation">
                <tbody>
                    <tr>
                        <td class="as-no-border as-inner-container" colspan="3">
                            <div class="as-inner-menu">
                                <a href="javascript:void(0);" class="as-active as-inner-tab" data-href="#as-slider-arrows">Arrows</a>
                                <a href="javascript:void(0);" class="as-inner-tab" data-href="#as-slider-bullets">Bullets</a>
                                <a href="javascript:void(0);" class="as-inner-tab" data-href="#as-slider-misc">Misc.</a>
                            </div>
                            <table class="as-inner-table as-no-border as-inner-full" id="as-slider-arrows"> 
                                <tbody>
                                    <?php
                                    //Get arrows Information
                                    $arrows_options = isset($slider_option->navigation->arrows) ? $slider_option->navigation->arrows : array();
                                    $aEnable = ($edit && isset($slider_option->showControls)) ? $slider_option->showControls : (($edit && isset($arrows_options->enable)) ? $arrows_options->enable : 1);
                                    ?>
                                    <tr>
                                        <td class="as-name"><?php _e('Enable', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <select id="as-slider-enableArrows">
                                                <?php
                                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                                    echo '<option value="' . $key . '"';
                                                    if ($aEnable == $key) {
                                                        echo ' selected';
                                                    }
                                                    echo '>' . $value[0] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Show the navigation arrows on slider.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        $navArrowStyle = ($aEnable == 1) ? 'style="display:table-row;"' : 'style="display:none;"'; 
                                        $aStyle = ($edit && isset($slider_option->controlsClass)) ? trim($slider_option->controlsClass) : (($edit && isset($arrows_options->style)) ? $arrows_options->style : 'control1');
                                    ?>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Style', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content as-default-option-td">
                                            <a class="as-button as-is-default as-slider-default-arrows" href="javascript:void(0);" data-arrows-style="<?php echo $aStyle; ?>"><?php _e('Change Arrows Style', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                                            <?php $controls_path = plugins_url() . '/avartan-slider-lite/images/controls/'; ?>
                                            <div class="as-default-option-wrapper as-arrows-list-wrapper">
                                                <table cellspacing="0" class="as-default-option-list as-arrows-list">
                                                    <?php
                                                    $controls_cnt = 0;
                                                    $total_controls = count($slider_select_options['controls']);
                                                    if ($total_controls > 0) {
                                                        foreach ($slider_select_options['controls'] as $control_val) {

                                                            if (($controls_cnt == 0 || $controls_cnt % 3 == 0) && $controls_cnt != 1) {
                                                                if ($controls_cnt != 0) {
                                                                    echo '</tr>';
                                                                }
                                                                echo '<tr>';
                                                            }
                                                            $controls_cnt++;
                                                            echo '<td class="';
                                                            if ((!$edit && strtolower($control_val) == 'control1') || ($edit && $aStyle == strtolower($control_val))) {
                                                                echo ' active';
                                                            }
                                                            if ($total_controls == $controls_cnt && $controls_cnt % 3 != 0) {
                                                                echo ' border-right';
                                                            }
                                                            echo '"><img data-arrows-style="' . strtolower($control_val) . '" src="' . $controls_path . strtolower($control_val) . '.png" /></td>';

                                                            if ($total_controls == $controls_cnt) {
                                                                echo '</tr>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Select Previous and Next arrows to display on slider.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name as-no-border"><b><?php _e('Left Arrow', AVARTANLITESLIDER_TEXTDOMAIN); ?>:</b></td>
                                        <td class="as-content as-no-border">&nbsp;</td>
                                        <td class="as-description as-no-border">&nbsp;</td>
                                    </tr>

                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Horizontal Position', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <div class="btn-group" data-toggle="buttons">
                                                <?php
                                                foreach ($slider_select_options['navHPosition'] as $key => $value) {
                                                    $checked = $active = '';
                                                    if ($key == 'left') {
                                                        $checked = ' checked';
                                                        $active = ' active';
                                                    }
                                                    echo '<label class="btn btn-primary as-is-temp-disabled as-pro-version' . $active . '">';
                                                    echo '<input type="radio" name="arrowLHPos" readonly disabled autocomplete="off"' . $checked . ' value="' . $key . '">' . $value[0];
                                                    echo '</label>';
                                                }
                                                ?>

                                            </div>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set horizontal position for left arrow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Vertical Position', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <div class="btn-group" data-toggle="buttons">
                                                <?php
                                                foreach ($slider_select_options['navVPosition'] as $key => $value) {
                                                    $checked = $active = '';
                                                    if ($key == 'center') {
                                                        $checked = ' checked';
                                                        $active = ' active';
                                                    }
                                                    echo '<label class="btn btn-primary as-is-temp-disabled as-pro-version' . $active . '">';
                                                    echo '<input type="radio" name="arrowLVPos" readonly disabled autocomplete="off"' . $checked . ' value="' . $key . '">' . $value[0];
                                                    echo '</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set vertical position for left arrow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Horizontal Offset', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <input id="as-slider-arrowLHOffset" type="number" readonly disabled min="0" onkeypress="return isNumberKey(event);" value="20" />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set horizontal offset for left arrow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Vertical Offset', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <input id="as-slider-arrowLVOffset" type="number" readonly disabled min="0" onkeypress="return isNumberKey(event);" value="0" />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set vertical offset for left arrow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name as-no-border"><b><?php _e('Right Arrow', AVARTANLITESLIDER_TEXTDOMAIN); ?>:</b></td>
                                        <td class="as-content as-no-border">&nbsp;</td>
                                        <td class="as-description as-no-border">&nbsp;</td>
                                    </tr>

                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Horizontal Position', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <div class="btn-group" data-toggle="buttons">
                                                <?php
                                                foreach ($slider_select_options['navHPosition'] as $key => $value) {
                                                    $checked = $active = '';
                                                    if ($key == 'left') {
                                                        $checked = ' checked';
                                                        $active = ' active';
                                                    }
                                                    echo '<label class="btn btn-primary as-is-temp-disabled as-pro-version' . $active . '">';
                                                    echo '<input type="radio" name="arrowRHPos" readonly disabled autocomplete="off"' . $checked . ' value="' . $key . '">' . $value[0];
                                                    echo '</label>';
                                                }
                                                ?>

                                            </div>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set horizontal position for right arrow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Vertical Position', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <div class="btn-group" data-toggle="buttons">
                                                <?php
                                                foreach ($slider_select_options['navVPosition'] as $key => $value) {
                                                    $checked = $active = '';
                                                    if ($key == 'center') {
                                                        $checked = ' checked';
                                                        $active = ' active';
                                                    }
                                                    echo '<label class="btn btn-primary as-is-temp-disabled as-pro-version' . $active . '">';
                                                    echo '<input type="radio" name="arrowRVPos" readonly disabled autocomplete="off"' . $checked . ' value="' . $key . '">' . $value[0];
                                                    echo '</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set vertical position for right arrow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Horizontal Offset', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <input id="as-slider-arrowRHOffset" type="number" readonly min="0" onkeypress="return isNumberKey(event);" value="20" />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set horizontal offset for right arrow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-arrows-block" <?php echo $navArrowStyle; ?>>
                                        <td class="as-name"><?php _e('Vertical Offset', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <input id="as-slider-arrowRVOffset" type="number" readonly min="0" onkeypress="return isNumberKey(event);" value="0" />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set vertical offset for right arrow.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="as-inner-table as-no-border as-inner-full" id="as-slider-bullets" style="display:none;">
                                <tbody>
                                    <?php
                                    //Get Bullets Information
                                    $bullets_options = isset($slider_option->navigation->bullets) ? $slider_option->navigation->bullets : array();
                                    $bEnable = ($edit && isset($slider_option->showNavigation)) ? $slider_option->showNavigation : (($edit && isset($bullets_options->enable)) ? $bullets_options->enable : 1);
                                    ?>
                                    <tr>
                                        <td class="as-name"><?php _e('Enable', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <select id="as-slider-enableBullets">
                                                <?php
                                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                                    echo '<option value="' . $key . '"';
                                                    if ($bEnable == $key) {
                                                        echo ' selected';
                                                    }
                                                    echo '>' . $value[0] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Show bullets on slide.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        $navBulletStyle = ($bEnable == 1) ? 'style="display:table-row;"' : 'style="display:none;"';
                                        $bulletStyle = (isset($slider_option->navigationClass) ? trim($slider_option->navigationClass) : (isset($bullets_options->style) ? trim($bullets_options->style) : 'navigation1'));
                                    ?>
                                    <tr class="as-navbullets-block" <?php echo $navBulletStyle; ?>>
                                        <td class="as-name"><?php _e('Style', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content as-default-option-td">
                                            <a class="as-slider-default-bullets as-button as-is-default" href="javascript:void(0);" data-bullets-style="<?php echo $bulletStyle; ?>"><?php _e('Change Bullet Style', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                                            <?php $navigation_path = plugins_url() . '/avartan-slider-lite/images/navigation/'; ?>
                                            <div class="as-default-option-wrapper as-bullets-list-wrapper">
                                                <table cellspacing="0" class="as-default-option-list as-bullets-list">
                                                    <?php
                                                    $navigation_cnt = 0;
                                                    $total_navigation = count($slider_select_options['navigation']);
                                                    if ($total_navigation > 0) {
                                                        foreach ($slider_select_options['navigation'] as $navigation_val) {

                                                            if (($navigation_cnt == 0 || $navigation_cnt % 5 == 0) && $navigation_cnt != 1) {
                                                                if ($navigation_cnt != 0) {
                                                                    echo '</tr>';
                                                                }
                                                                echo '<tr>';
                                                            }
                                                            $navigation_cnt++;
                                                            echo '<td class="';
                                                            if ((!$edit && strtolower($navigation_val) == 'navigation1') || ($edit && $bulletStyle == strtolower($navigation_val))) {
                                                                echo ' active';
                                                            }
                                                            if ($total_navigation == $navigation_cnt && $navigation_cnt % 5 != 0) {
                                                                echo ' border-right';
                                                            }
                                                            echo '"><img data-bullets-style="' . strtolower($navigation_val) . '" src="' . $navigation_path . strtolower($navigation_val) . '.png" /></td>';

                                                            if ($total_navigation == $navigation_cnt) {
                                                                echo '</tr>';
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Select bullets to display on slider.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-navbullets-block" <?php echo $navBulletStyle; ?>>
                                        <td class="as-name"><?php _e('Direction', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <select id="as-slider-bulletsDirection" class="as-is-temp-disabled as-pro-version">
                                                <?php
                                                $cnt = 0;
                                                foreach ($slider_select_options['navDirection'] as $key => $value) {
                                                    echo '<option value="' . $key . '"';
                                                    if($cnt == 0) {
                                                        echo ' selected';
                                                    }
                                                    else {
                                                        echo ' disabled';
                                                    }
                                                    echo '>' . $value[0] . '</option>';
                                                    $cnt++;
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set navigation bullets direction.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-navbullets-block" <?php echo $navBulletStyle; ?>>
                                        <td class="as-name"><?php _e('Gap', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <input id="as-slider-bulletsGap" type="number" min="0" readonly disabled value="10" />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('The gap between bullets.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-navbullets-block" <?php echo $navBulletStyle; ?>>
                                        <td class="as-name"><?php _e('Horizontal Position', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <div class="btn-group" data-toggle="buttons">
                                                <?php
                                                foreach ($slider_select_options['navHPosition'] as $key => $value) {
                                                    $checked = $active = '';
                                                    if ((!$edit && $value[1]) || ($edit && isset($bullets_options->hPos) && $bullets_options->hPos == $key) || ($edit && !isset($bullets_options->hPos) && $value[1])) {
                                                        $checked = ' checked';
                                                        $active = ' active';
                                                    }
                                                    echo '<label class="btn btn-primary' . $active . '">';
                                                    echo '<input type="radio" name="bulletsHPosition" readonly disabled autocomplete="off"' . $checked . ' value="' . $key . '">' . $value[0];
                                                    echo '</label>';
                                                }
                                                ?>

                                            </div>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set horizontal position for bullets.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-navbullets-block" <?php echo $navBulletStyle; ?>>
                                        <td class="as-name"><?php _e('Vertical Position', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <div class="btn-group" data-toggle="buttons">
                                                <?php
                                                foreach ($slider_select_options['navVPosition'] as $key => $value) {
                                                    $checked = $active = '';
                                                    if ($key == 'bottom') {
                                                        $checked = ' checked';
                                                        $active = ' active';
                                                    }
                                                    echo '<label class="btn btn-primary as-is-temp-disabled as-pro-version' . $active . '">';
                                                    echo '<input type="radio" name="bulletsVPosition" readonly disabled autocomplete="off"' . $checked . ' value="' . $key . '">' . $value[0];
                                                    echo '</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set vertical position for bullets.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-navbullets-block" <?php echo $navBulletStyle; ?>>
                                        <td class="as-name"><?php _e('Horizontal Offset', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <input id="as-slider-bulletsHOffset" type="number" min="0" readonly disabled value="0" />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set horizontal offset for bullets.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                    <tr class="as-navbullets-block" <?php echo $navBulletStyle; ?>>
                                        <td class="as-name"><?php _e('Vertical Offset', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <input id="as-slider-bulletsVOffset" type="number" min="0" readonly disabled value="20" />&nbsp;<?php _e('px', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Set vertical offset for bullets.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="as-inner-table as-no-border as-inner-full" id="as-slider-misc" style="display:none;">
                                <tbody>
                                    <tr>
                                        <td class="as-name"><?php _e('Enable Swipe and Drag', AVARTANLITESLIDER_TEXTDOMAIN); ?></td>
                                        <td class="as-content">
                                            <select id="as-slider-enableSwipe">
                                                <?php
                                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                                    echo '<option value="' . $key . '"';
                                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->enableSwipe) && $slider_option->enableSwipe == $key)) {
                                                        echo ' selected';
                                                    }
                                                    echo '>' . $value[0] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td class="as-description">
                                            <?php _e('Enable swipe left, swipe right, drag left, drag right commands.', AVARTANLITESLIDER_TEXTDOMAIN); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Slider Navigation info End -->
        </div>    
        <br clear="all" />
    </div>
    <br clear="all" />
</div>