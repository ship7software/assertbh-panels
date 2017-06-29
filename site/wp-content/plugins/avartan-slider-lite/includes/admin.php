<?php
if( !defined( 'ABSPATH') ) exit();

class AvartanlitesliderAdmin {

    /**
     * Creates the menu and the admin panel
     */
    public static function avartansliderShowSettings() {
        add_action('admin_menu', 'AvartanlitesliderAdmin::avartansliderPluginMenus');
    }

    /**
     * Add menu in left panel of admin panel
     */
    public static function avartansliderPluginMenus() {
        add_menu_page('Avartan Slider', 'Avartan Slider', 'manage_options', AVARTANLITESLIDER_TEXTDOMAIN, 'AvartanlitesliderAdmin::avartansliderDisplayPage', AVARTANLITE_PLUGIN_URL . '/images/avartan.png');
    }

    /**
     * Display correct page 
     */
    public static function avartansliderDisplayPage() {
        if (!isset($_GET['view'])) {
            $index = 'home';
        } else {
            $index = $_GET['view'];
        }

        global $wpdb;

        // Check what the user is doing: is it adding or modifying a slider? 
        if (isset($_GET['view']) && $_GET['view'] == 'add') {
            $edit = false;
            $id = NULL;
        } else {
            $edit = true;
            $id = isset($_GET['id']) ? $_GET['id'] : NULL;
            if (isset($id)) {
                $slider = $wpdb->get_row('SELECT name FROM ' . $wpdb->prefix . 'avartan_sliders WHERE id = ' . $id);

                //if id is not found
                if (!$slider) {
                    ?>   
                    <script>
                        window.location.href = '?page=avartanslider';
                    </script>
                    <?php
                }
            }
        }
        ?>
        <div class="wrap as-admin">	
            <div class="as-slider-wrapper">
                <noscript class="as-no-js">
                <div class="as-message as-message-error" style="display: block;"><?php _e('JavaScript must be enabled to view this page correctly.', AVARTANLITESLIDER_TEXTDOMAIN); ?></div>
                </noscript>

                <?php if (!$edit): ?>
                    <div class="as-message as-message-warning"><?php _e('When you\'ll click "Save Settings", you\'ll be able to add slides and elements.', AVARTANLITESLIDER_TEXTDOMAIN); ?></div>
                <?php endif; ?>

                <h1 class="as-logo" title="<?php esc_attr_e('Avartan Animation Slider', AVARTANLITESLIDER_TEXTDOMAIN); ?>">
                    <a href="?page=avartanslider" title="<?php _e('Avartan Slider', AVARTANLITESLIDER_TEXTDOMAIN); ?>">
                        <img src="<?php echo AVARTANLITE_PLUGIN_URL . '/images/logo.png' ?>" alt="<?php _e('Avartan Slider', AVARTANLITESLIDER_TEXTDOMAIN); ?>" />
                    </a>
                </h1>
                <div class="as-wrapper">   
                    <?php if (isset($_SESSION['success_msg'])) { ?>
                        <div class="updated is-dismissible notice settings-error"><?php
                            echo '<p>' . $_SESSION['success_msg'] . '</p>';
                            unset($_SESSION['success_msg']);
                            ?></div>
                    <?php } ?>
                    <div class="as-plugin-asides">

                        <div class="as-plugin-aside pro_extentions">
                            <h3><?php _e('Avartan Slider Pro Features', AVARTANLITESLIDER_TEXTDOMAIN); ?></h3>
                            <ul>
                                <li><?php _e('6 Type of Element Support', AVARTANLITESLIDER_TEXTDOMAIN); ?></li>
                                <li><?php _e('One click Import/Export Slider/Single Slide', AVARTANLITESLIDER_TEXTDOMAIN); ?></li>
                                <li><?php _e('Duplicate Slide/Slides', AVARTANLITESLIDER_TEXTDOMAIN); ?></li>
                                <li>
                                    <a href="http://avartanslider.com/features/" target="_blank"><?php _e('and much more!', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                                </li>
                            </ul>
                            <p><a href="https://www.solwininfotech.com/product/wordpress-plugins/avartan-slider/" target="_blank" class="as-plugin-buy-now"><?php _e('Upgrade to PRO!', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></p>
                        </div>

                        <div class="as-plugin-aside get_help">
                            <h3><?php _e('Get Help', AVARTANLITESLIDER_TEXTDOMAIN); ?></h3>
                            <ul>
                                <li>
                                    <a href="http://avartanslider.com" target="_blank"><?php _e('View Live Demo', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                                </li>
                                <li>
                                    <a href="http://avartanslider.com/avartan-documentation/" target="_blank"><?php _e('Read the documentation', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                                </li>
                                <li>
                                    <a href="http://support.solwininfotech.com/" target="_blank"><?php _e('24/7 Free Support', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                                </li>
                                <li>
                                    <a href="http://avartanslider.com/plans-pricing/" target="_blank"><?php _e('Lite & Pro Comparison', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                                </li>
                                <li>
                                    <a href="https://wordpress.org/plugins/avartan-slider-lite/faq/" target="_blank"><?php _e('FAQ', AVARTANLITESLIDER_TEXTDOMAIN); ?></a>
                                </li>
                                <li>
                                    <?php _e('Facing any issue?', AVARTANLITESLIDER_TEXTDOMAIN); ?>&nbsp;<a href="https://wordpress.org/support/plugin/avartan-slider-lite" target="_blank"><u><?php _e('Contact Us', AVARTANLITESLIDER_TEXTDOMAIN); ?></u></a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="as-plugin-aside pull-right support_themes">
                            <h3><?php _e('Looking for an Avartan themes?', AVARTANLITESLIDER_TEXTDOMAIN); ?></h3>
                            <ul>
                                <li><a href="http://demo.solwininfotech.com/wordpress/foodfork/" target="_blank"><?php _e('FoodFork', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
                                <li><a href="http://demo.solwininfotech.com/wordpress/realestaty/" target="_blank"><?php _e('RealEstaty', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
                                <li><a href="http://demo.solwininfotech.com/wordpress/veriyas-pro/" target="_blank"><?php _e('Veriyas PRO', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
                                <li><a href="http://demo.solwininfotech.com/wordpress/myappix/" target="_blank"><?php _e('MyAppix', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
								<li><a href="http://demo.solwininfotech.com/wordpress/biznetic/" target="_blank"><?php _e('Biznetic', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
                                <li><a href="http://demo.solwininfotech.com/wordpress/jewelux/" target="_blank"><?php _e('JewelUX', AVARTANLITESLIDER_TEXTDOMAIN); ?></a></li>
                            </ul>
                        </div>
                        
                    </div>

                        <?php

                    //Choose the page for display based on call
                    switch ($index) {
                        case 'home':
                            self::avartansliderDisplayHome();
                            break;

                        case 'add':
                        case 'edit':
                            self::avartansliderDisplaySlider();
                            break;
                    }
                    ?>
                    <div class="clear"></div>
                </div>
            </div>
           <!-- Loader Section -->    
                <div class="as-admin-preloader"></div>
            </div>
        <?php
    }

    /**
     * Display home page with slider list
     */
    public static function avartansliderDisplayHome() {
        ?>
        <div class="as-home">
            <?php require_once AVARTANLITE_PLUGIN_DIR . 'includes/home.php'; ?>
        </div>
        <?php
    }

    /**
     * Displays the slider page in wich you can add or modify sliders, slides and elements
     */
    public static function avartansliderDisplaySlider() {
        global $wpdb;

        // Check what the user is doing: is it adding or modifying a slider? 
        if ($_GET['view'] == 'add') {
            $edit = false;
            $id = NULL; //This variable will be used in other files. It contains the ID of the SLIDER that the user is editing
        } else {
            $edit = true;
            $id = isset($_GET['id']) ? $_GET['id'] : NULL;
            $slider = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'avartan_sliders WHERE id = ' . $id);
            $slides = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'avartan_slides WHERE slider_parent = ' . $id . ' ORDER BY position');
            // The elements variable are updated in the foreachh() loop directly in the "slides.php" file
        }
        ?>

        <div class="as-slider <?php echo $edit ? 'as-edit-slider' : 'as-add-slider' ?>">
                <div class="as-tabs as-tabs-fade as-tabs-switch-interface">
                        <?php if($edit): ?>
                    <ul class="as-slider-tabs">
                        <li class="as-slider-tab-li">
                            <a class="as-slider-tab-anchor as-is-active" href="#as-slider-settings">
                                <span class="dashicons dashicons-admin-generic"></span>
                                <?php _e( 'Settings', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </a>
                        </li>
                        <li class="as-slider-tab-li">
                            <a class="as-slider-tab-anchor" href="#as-slides">
                                <span class="dashicons dashicons-edit"></span>
                                <?php _e( 'Edit Slides ', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                                [&nbsp;<span class="as-slider-title"><?php echo $slider->name; ?></span>&nbsp;]
                            </a>
                        </li>
                    </ul>
                    <ul class="as-slider-links ui-tabs-nav">
                        <li class="as-slider-tab-li">
                            <a class="as-import-slide as-slider-tab-anchor as-is-temp-disabled as-pro-version" href="javascript:void(0);" title="<?php _e( 'Import Single Slide', AVARTANLITESLIDER_TEXTDOMAIN ) ?>">
                                <span class="dashicons dashicons-download"></span>
                                <?php _e( 'Import Slide', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </a>
                        </li>
                        <li class="as-slider-tab-li">
                            <a href="?page=avartanslider" class="as-slider-tab-anchor as-slider-back-list">
                                <span class="dashicons dashicons-menu"></span>
                                <?php _e( 'Back to List', AVARTANLITESLIDER_TEXTDOMAIN ); ?>
                            </a>
                        </li>
                    </ul>


                        <?php endif; ?>

                        <?php require_once AVARTANLITE_PLUGIN_DIR . 'includes/slider.php'; ?>
                        <?php
                        if($edit) {
                                require_once AVARTANLITE_PLUGIN_DIR . 'includes/elements.php';
                                require_once AVARTANLITE_PLUGIN_DIR . 'includes/slides.php';
                        }
                        ?>
                </div>
        </div>

        <?php
    }

    /**
     * Include CSS and JavaScript
     */
    public static function enqueues() {
        global $wpdb;

        if (isset($_GET['page']) && $_GET['page'] == 'avartanslider') {
            wp_enqueue_script('jquery-ui-draggable');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_media();
            wp_enqueue_style( 'wp-color-picker' );

            wp_register_script('avartanslider-admin-bootstrap', AVARTANLITE_PLUGIN_URL . '/js/bootstrap.min.js');
            wp_register_script('avartanslider-admin-bootstrap-growl', AVARTANLITE_PLUGIN_URL . '/js/jquery.bootstrap-growl.min.js');
            wp_register_script('avartanslider-admin', AVARTANLITE_PLUGIN_URL . '/js/admin.js', array('jquery-ui-tabs', 'jquery-ui-sortable', 'jquery-ui-draggable','wp-color-picker'));

            self::localization();

            wp_enqueue_style('avartanslider-admin-bootstrap', AVARTANLITE_PLUGIN_URL . '/css/bootstrap.min.css');
            wp_enqueue_style('avartanslider-admin', AVARTANLITE_PLUGIN_URL . '/css/admin.css', array());
            wp_enqueue_script( 'wp-color-picker-alpha', AVARTANLITE_PLUGIN_URL . '/js/wp-color-picker-alpha.min.js');
            wp_enqueue_script('avartanslider-admin-bootstrap');
            wp_enqueue_script('avartanslider-admin-bootstrap-growl');
            wp_enqueue_script('avartanslider-admin');
        }
    }

    /**
     * add action for enqueue scripts
     */
    public static function setEnqueues() {
        add_action('admin_enqueue_scripts', 'AvartanlitesliderAdmin::enqueues');
    }

    /**
     * Set localization which will be used in js file
     */
    public static function localization() {
        $nonce = wp_create_nonce("avartanslider_csrf");
        $avartanslider_translations = array(
            'slide' => __('Slide', AVARTANLITESLIDER_TEXTDOMAIN),
            'show_hide_ele_title' => __( 'Show/Hide Element', AVARTANLITESLIDER_TEXTDOMAIN ),
            'text_element_default_video' => __( 'Video Element', AVARTANLITESLIDER_TEXTDOMAIN ),
            'text_element_default_image' => __( 'Image Element', AVARTANLITESLIDER_TEXTDOMAIN ),
            'slider_name' => __('Slider name can not be empty.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_generate' => __('Slider has been generated successfully.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_save' => __('Slider has been saved successfully.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_error' => __('Something went wrong during save slider!', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_already_find' => __('Some other slider with alias', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_exists' => __('already exists.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_delete' => __('Slider has been deleted successfully.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_delete_error' => __('Something went wrong during delete slider!', AVARTANLITESLIDER_TEXTDOMAIN),
            'slide_save' => __('Slide has been saved successfully.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slide_error' => __('Something went wrong during save slide!', AVARTANLITESLIDER_TEXTDOMAIN),
            'slide_delete' => __('Slide has been deleted successfully.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slide_delete_error' => __('Something went wrong during delete slide!', AVARTANLITESLIDER_TEXTDOMAIN),
            'slide_update_position_error' => __('Something went wrong during update slides position!', AVARTANLITESLIDER_TEXTDOMAIN),
            'slide_delete_confirm' => __('The slide will be deleted. Are you sure?', AVARTANLITESLIDER_TEXTDOMAIN),
            'slide_delete_just_one' => __('You can not delete this. You must have at least one slide.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_delete_confirm' => __('The slider will be deleted. Are you sure?', AVARTANLITESLIDER_TEXTDOMAIN),
            'text_element_default_html' => __('Text element', AVARTANLITESLIDER_TEXTDOMAIN),
            'element_no_found_txt' => __('No element found.', AVARTANLITESLIDER_TEXTDOMAIN),
            'slide_stop_preview' => __('Stop Preview', AVARTANLITESLIDER_TEXTDOMAIN),
            'slider_pro_version' => __('This feature is available for pro version only.', AVARTANLITESLIDER_TEXTDOMAIN),
            'youtube_video_title' => __('Youtube Video', AVARTANLITESLIDER_TEXTDOMAIN),
            'ele_del_all_confirm' => __( 'All elements will be deleted. Are you sure?', AVARTANLITESLIDER_TEXTDOMAIN ),
            'html5_video_title' => __('Html5 Video', AVARTANLITESLIDER_TEXTDOMAIN),
            'upgrade_pro' => __('Upgrade to PRO!', AVARTANLITESLIDER_TEXTDOMAIN),
            'ele_del_all_confirm' => __( 'All elements will be deleted. Are you sure?', AVARTANLITESLIDER_TEXTDOMAIN ),
            'ele_del_confirm' => __( 'Element will be deleted. Are you sure?', AVARTANLITESLIDER_TEXTDOMAIN ),
            'default_nonce' => $nonce,
            'AvartanPluginUrl' => plugins_url() . '/avartan-slider-lite',
        );
        wp_localize_script('avartanslider-admin', 'avartanslider_translations', $avartanslider_translations);
    }

}

/**
 * admin scripts
 */
if (!function_exists('avl_admin_scripts')) {

    function avl_admin_scripts() {
        $screen = get_current_screen();
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/avartan-slider-lite/avartanslider.php', $markup = true, $translate = true);
        $current_version = $plugin_data['Version'];
        $old_version = get_option('avl_version');
        if ($old_version != $current_version) {
            update_option('is_user_subscribed_cancled', '');
            update_option('avl_version', $current_version);
        }
        if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes') {
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }
    }

}
add_action('admin_enqueue_scripts', 'avl_admin_scripts');

/**
 * start session if not
 */
if (!function_exists('avl_session_start')) {

    function avl_session_start() {
        if (session_id() == '') {
            session_start();
        }
    }

}
add_action('init', 'avl_session_start');

/**
 * subscribe email form
 */
if (!function_exists('avl_subscribe_mail')) {

    function avl_subscribe_mail() {
        $customer_email = get_option('admin_email');
        $current_user = wp_get_current_user();
        $f_name = $current_user->user_firstname;
        $l_name = $current_user->user_lastname;
        if (isset($_POST['sbtEmail'])) {
            $_SESSION['success_msg'] = __( 'Thank you for your subscription.', AVARTANLITESLIDER_TEXTDOMAIN );
            //Email To Admin
            update_option('is_user_subscribed', 'yes');
            $customer_email = trim($_POST['txtEmail']);
            $customer_name = trim($_POST['txtName']);
            $to = 'plugins@solwininfotech.com';
            $from = get_option('admin_email');

            $headers = "MIME-Version: 1.0;\r\n";
            $headers .= "From: " . strip_tags($from) . "\r\n";
            $headers .= "Content-Type: text/html; charset: utf-8;\r\n";
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
            $subject = 'New user subscribed from Plugin - Avartan Slider Lite';
            $body = '';
            ob_start();
            ?>
            <div style="background: #F5F5F5; border-width: 1px; border-style: solid; padding-bottom: 20px; margin: 0px auto; width: 750px; height: auto; border-radius: 3px 3px 3px 3px; border-color: #5C5C5C;">
                <div style="border: #FFF 1px solid; background-color: #ffffff !important; margin: 20px 20px 0;
                     height: auto; -moz-border-radius: 3px; padding-top: 15px;">
                    <div style="padding: 20px 20px 20px 20px; font-family: Arial, Helvetica, sans-serif;
                         height: auto; color: #333333; font-size: 13px;">
                        <div style="width: 100%;">
                            <strong>Dear Admin (Avartan Slider Lite plugin developer)</strong>,
                            <br />
                            <br />
                            Thank you for developing useful plugin.
                            <br />
                            <br />
                            I <?php echo $customer_name; ?> want to notify you that I have installed plugin on my <a href="<?php echo home_url(); ?>">website</a>. Also I want to subscribe to your newsletter, and I do allow you to enroll me to your free newsletter subscription to get update with new products, news, offers and updates.
                            <br />
                            <br />
                            I hope this will motivate you to develop more good plugins and expecting good support form your side.
                            <br />
                            <br />
                            Following is details for newsletter subscription.
                            <br />
                            <br />
                            <div>
                                <table border='0' cellpadding='5' cellspacing='0' style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;color: #333333;width: 100%;">                                    
                                    <?php if ($customer_name != '') {
                                        ?>
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                                Name<span style="float:right">:</span>
                                            </th>
                                            <td style="padding: 8px 5px;">
                                                <?php echo $customer_name; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {
                                        ?>
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                                Name<span style="float:right">:</span>
                                            </th>
                                            <td style="padding: 8px 5px;">
                                                <?php echo home_url(); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                            Email<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo $customer_email; ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                            Website<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo home_url(); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                            Date<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo date('d-M-Y  h:i  A'); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                            Plugin<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo 'Avartan Slider Lite'; ?>
                                        </td>
                                    </tr>
                                </table>
                                <br /><br />
                                Again Thanks you
                                <br />
                                <br />
                                Regards
                                <br />
                                <?php echo $customer_name; ?>
                                <br />
                                <?php echo home_url(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $body = ob_get_clean();
            wp_mail($to, $subject, $body, $headers);
        }
        if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes') {
            ?>
            <div id="subscribe_widget_avl" style="display:none;">
                <div class="subscribe_widget">
                    <h3>Notify to Avartan Slider plugin developer and subscribe.</h3>
                    <form class='sub_form' name="frmSubscribe" method="post" action="<?php echo admin_url() . 'admin.php?page=avartanslider'; ?>">
                        <div class="sub_row"><label>Your Name: </label><input placeholder="Your Name" name="txtName" type="text" value="<?php echo $f_name . ' ' . $l_name; ?>" /></div>
                        <div class="sub_row"><label>Email Address: </label><input placeholder="Email Address" required name="txtEmail" type="email" value="<?php echo $customer_email; ?>" /></div>
                        <input class="button button-primary" type="submit" name="sbtEmail" value="Notify & Subscribe" />                
                    </form>
                </div>
            </div>
            <?php
        }
        if (isset($_GET['page'])) {
            if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes' && $_GET['page'] == 'avartanslider') {
                ?>
                <a style="display:none" href="#TB_inline?max-width=400&height=210&inlineId=subscribe_widget_avl" class="thickbox" id="subscribe_thickbox"></a>            
                <?php
            }
        }
    }

}
add_action('admin_head', 'avl_subscribe_mail', 10);

/**
 * user cancel subscribe
 */
if (!function_exists('wp_ajax_avl_close_tab')) {

    function wp_ajax_avl_close_tab() {
        update_option('is_user_subscribed_cancled', 'yes');
        exit();
    }

}
add_action('wp_ajax_close_tab', 'wp_ajax_avl_close_tab');
?>