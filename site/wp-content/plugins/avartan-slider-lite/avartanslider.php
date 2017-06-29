<?php
/**
 * Plugin Name: Avartan Slider Lite
 * Plugin URI: https://wordpress.org/plugins/avartan-slider-lite/
 * Description: To make your home page more beautiful with Avaratan Slider. Avaratan Slider Lite is a first free slider plugin with lots of nice features like beautiful, modern and configurable backend elements. It is multipurpose slider which comes with text, image and video elements.
 * Author: Solwin Infotech
 * Author URI: https://www.solwininfotech.com/
 * Copyright: Solwin Infotech
 * Version: 1.1.1
 * Requires at least: 4.0
 * Tested up to: 4.7
 * License: GPLv2 or later
 */
/* * ********** */
/** GLOBALS * */
/* * ********** */
if (!defined('ABSPATH'))
    exit();

if (!defined('AVARTANLITESLIDER_TEXTDOMAIN')) {
    define("AVARTANLITESLIDER_TEXTDOMAIN", "avartanslider");
}
if (!defined('AVARTANLITE_PLUGIN_DIR')) {
    define('AVARTANLITE_PLUGIN_DIR', plugin_dir_path(__FILE__));
}
if (!defined('AVARTANLITE_PLUGIN_URL')) {
    define('AVARTANLITE_PLUGIN_URL', plugins_url() . '/avartan-slider-lite');
}

require_once AVARTANLITE_PLUGIN_DIR . 'includes/tables.php';
require_once AVARTANLITE_PLUGIN_DIR . 'includes/shortcode.php';

// Create (or remove) 2 tables: the sliders settings, the slides settings and the elements proprieties. We will also store the current version of the plugin
register_activation_hook(__FILE__,'slider_active');
if (!function_exists('slider_active')) {

    function slider_active() {
        //plugin is activated
        if (is_plugin_active('avartanslider/avartanslider.php')) {
            deactivate_plugins('/avartanslider/avartanslider.php');
        }
        AvartanlitesliderTables::avartansliderSetTables();   
    }

}
register_uninstall_hook(__FILE__, array('AvartanlitesliderTables', 'avartansliderDropTables'));

/**
 * Deactivate Pro version if it is activated
 */
if (!function_exists('slider_status')) {

    function slider_status() {
        global $wpdb;
        //if plugin activated and database table not found then create it
        if (is_plugin_active('avartan-slider-lite/avartanslider.php')) {
            $avartanSlider = $wpdb->prefix . 'avartan_sliders';
            if ($wpdb->get_var("SHOW TABLES LIKE '$avartanSlider'") != $avartanSlider) {
                AvartanlitesliderTables::avartansliderSetSlidersTable();
            }
            $avartanSlides = $wpdb->prefix . 'avartan_slides';
            if ($wpdb->get_var("SHOW TABLES LIKE '$avartanSlides'") != $avartanSlides) {
                AvartanlitesliderTables::avartansliderSetSlidesElementsTable();
            }
        }
    }

}

add_action('admin_init', 'slider_status');

/**
 * plugin text domain
 */
add_action('plugins_loaded', 'avartanlitesliderPluginTextDomain');
if (!function_exists('avartanlitesliderPluginTextDomain')) {

    function avartanlitesliderPluginTextDomain() {
        $locale = apply_filters('plugin_locale', get_locale(), AVARTANLITESLIDER_TEXTDOMAIN);
        load_textdomain(AVARTANLITESLIDER_TEXTDOMAIN, WP_LANG_DIR . '/avartanslider-' . $locale . '.mo');
        load_plugin_textdomain(AVARTANLITESLIDER_TEXTDOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

}

/**
 * Add solwin news dashboard
 */
add_action('plugins_loaded', 'avartanslider_latest_news_solwin_feed');

function avartanslider_latest_news_solwin_feed() {

    // Register the new dashboard widget with the 'wp_dashboard_setup' action
    add_action('wp_dashboard_setup', 'solwin_latest_news_with_product_details');
    if (!function_exists('solwin_latest_news_with_product_details')) {

        function solwin_latest_news_with_product_details() {
            add_screen_option('layout_columns', array('max' => 3, 'default' => 2));
            add_meta_box('wp_avartanslider_dashboard_widget', __('News From Solwin Infotech', AVARTANLITESLIDER_TEXTDOMAIN), 'solwin_dashboard_widget_news', 'dashboard', 'normal', 'high');
        }

    }
    if (!function_exists('solwin_dashboard_widget_news')) {

        function solwin_dashboard_widget_news() {
            echo '<div class="rss-widget">'
            . '<div class="solwin-news"><p><strong>Solwin Infotech News</strong></p>';
            wp_widget_rss_output(array(
                'url' => 'https://www.solwininfotech.com/feed/',
                'title' => __('News From Solwin Infotech', AVARTANLITESLIDER_TEXTDOMAIN),
                'items' => 5,
                'show_summary' => 0,
                'show_author' => 0,
                'show_date' => 1
            ));
            echo '</div>';
            $title = $link = $thumbnail = "";
            //get Latest product detail from xml file

            $file = 'https://www.solwininfotech.com/documents/assets/latest_product.xml';
            define('LATEST_PRODUCT_FILE', $file);
            echo '<div class="display-product">'
            . '<div class="product-detail"><p><strong>' . __('Latest Product', AVARTANLITESLIDER_TEXTDOMAIN) . '</strong></p>';
            $response = wp_remote_post(LATEST_PRODUCT_FILE);
            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
                echo "<p>" . __('Something went wrong', AVARTANLITESLIDER_TEXTDOMAIN) . " : $error_message" . "</p>";
            } else {
                $body = wp_remote_retrieve_body($response);
                $xml = simplexml_load_string($body);
                $title = $xml->item->name;
                $thumbnail = $xml->item->img;
                $link = $xml->item->link;

                $allProducttext = $xml->item->viewalltext;
                $allProductlink = $xml->item->viewalllink;
                $moretext = $xml->item->moretext;
                $needsupporttext = $xml->item->needsupporttext;
                $needsupportlink = $xml->item->needsupportlink;
                $customservicetext = $xml->item->customservicetext;
                $customservicelink = $xml->item->customservicelink;
                $joinproductclubtext = $xml->item->joinproductclubtext;
                $joinproductclublink = $xml->item->joinproductclublink;


                echo '<div class="product-name"><a href="' . $link . '" target="_blank">'
                . '<img alt="' . $title . '" src="' . $thumbnail . '"> </a>'
                . '<a href="' . $link . '" target="_blank">' . $title . '</a>'
                . '<p><a href="' . $allProductlink . '" target="_blank" class="button button-default">' . $allProducttext . ' &RightArrow;</a></p>'
                . '<hr>'
                . '<p><strong>' . $moretext . '</strong></p>'
                . '<ul>'
                . '<li><a href="' . $needsupportlink . '" target="_blank">' . $needsupporttext . '</a></li>'
                . '<li><a href="' . $customservicelink . '" target="_blank">' . $customservicetext . '</a></li>'
                . '<li><a href="' . $joinproductclublink . '" target="_blank">' . $joinproductclubtext . '</a></li>'
                . '</ul>'
                . '</div>';
            }
            echo '</div></div><div class="clear"></div>'
            . '</div>';
        }

    }
}

if (isset($_GET['page']) && $_GET['page'] == 'avartanslider') {
    add_filter('admin_footer_text', 'remove_footer_admin'); //change admin footer text
    if (!function_exists('remove_footer_admin')) {

        function remove_footer_admin() {
            ?>
            <p id="footer-left" class="alignleft">
                <?php _e('If you like ', AVARTANLITESLIDER_TEXTDOMAIN) ?>
                <a href="https://www.solwininfotech.com/product/wordpress-plugins/avartan-slider-lite/" target="_blank"><strong><?php _e('Avartan Slider Lite ', AVARTANLITESLIDER_TEXTDOMAIN) ?></strong></a>
                <?php _e('please leave us a ', AVARTANLITESLIDER_TEXTDOMAIN) ?>
                <a class="as-review-link" data-rated="Thanks :)" target="_blank" href="https://wordpress.org/support/plugin/avartan-slider-lite/reviews?filter=5#new-post">&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;</a>
                <?php _e(' rating. A huge thank you from Solwin Infotech in advance!', AVARTANLITESLIDER_TEXTDOMAIN) ?>
            </p>
            <?php
        }

    }
}

/**
 * admin enqueue script
 */
if (is_admin()) {
    require_once AVARTANLITE_PLUGIN_DIR . 'includes/admin.php';
    add_action('admin_enqueue_scripts', 'AvartanlitesliderAdminJS');
}

if (!function_exists('AvartanlitesliderAdminJS')) {

    function AvartanlitesliderAdminJS() {
        ?>
        <script type="text/javascript">
            var avartanslider_is_wordpress_admin = true;
        </script>
        <?php
    }

}

/**
 * both side enqueue script and style
 */
add_action('wp_enqueue_scripts', 'enqueues');
add_action('admin_enqueue_scripts', 'enqueues');

if (!function_exists('enqueues')) {

    function enqueues() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_style('slidercssfont', AVARTANLITE_PLUGIN_URL . '/css/font-awesome.min.css');
        wp_enqueue_style('slidercss', AVARTANLITE_PLUGIN_URL . '/css/avartanslider.min.css');
        wp_enqueue_script('sliderjs', AVARTANLITE_PLUGIN_URL . '/js/avartanslider.min.js');
    }

}

AvartanlitesliderShortcode::avartansliderAddShortcode();

//admin enqueue script
if (is_admin()) {
    AvartanlitesliderAdmin::setEnqueues();
    AvartanlitesliderAdmin::avartansliderShowSettings();


    // Ajax functions
    require_once AVARTANLITE_PLUGIN_DIR . 'includes/ajax.php';

    /**
     * Append the 'Add Slider' button to selected admin pages
     */
    add_filter('media_buttons_context', 'insert_avartanslider_button');
    if (!function_exists('insert_avartanslider_button')) {

        function insert_avartanslider_button($context) {

            global $pagenow;

            if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php'))) {
                $context .= '<a href="#TB_inline?&inlineId=choose-avartan-slider" class="thickbox button" title="' .
                        __("Select Avartan Slider to insert into post/page", AVARTANLITESLIDER_TEXTDOMAIN) .
                        '"><span class="wp-media-buttons-icon" style="background: url(' . AVARTANLITE_PLUGIN_URL .
                        '/images/avartan.png); background-repeat: no-repeat; background-position: left bottom;"></span> ' .
                        __("Add Avartan slider", AVARTANLITESLIDER_TEXTDOMAIN) . '</a>';
            }

            return $context;
        }

    }

    /**
     * Append the 'Choose Avartan Slider' thickbox content to the bottom of selected admin pages
     */
    add_action('admin_footer', 'admin_footer_avartan', 11);
    if (!function_exists('admin_footer_avartan')) {

        function admin_footer_avartan() {

            global $pagenow;

            // Only run in post/page creation and edit screens
            if (in_array($pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php'))) {
                global $wpdb;
                //Get the slider information
                $sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'avartan_sliders');
                ?>

                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('#insertAvartanSlider').on('click', function () {
                            var id = jQuery('#avartanslider-select option:selected').val();
                            window.send_to_editor('[avartanslider alias="' + id + '"]');
                            tb_remove();
                        });
                    });
                </script>

                <div id="choose-avartan-slider" style="display: none;">
                    <div class="wrap">
                        <?php
                        if (count($sliders)) {
                            echo "<h3 style='margin-bottom: 20px;'>" . __("Insert Avartan Slider", AVARTANLITESLIDER_TEXTDOMAIN) . "</h3>";
                            echo "<select id='avartanslider-select'>";
                            echo "<option disabled=disabled>" . __("Choose Avartan Slider", AVARTANLITESLIDER_TEXTDOMAIN) . "</option>";
                            foreach ($sliders as $slider) {
                                echo "<option value='{$slider->alias}'>{$slider->name}</option>";
                            }
                            echo "</select>";
                            echo "<button class='button primary' id='insertAvartanSlider'>" . __("Insert Avartan Slider", AVARTANLITESLIDER_TEXTDOMAIN) . "</button>";
                        } else {
                            _e("No sliders found", AVARTANLITESLIDER_TEXTDOMAIN);
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }

    }
}

require_once AVARTANLITE_PLUGIN_DIR . 'includes/avartan_widget.php';
if (!function_exists('Avartansliderwidget_register')) {

    function Avartansliderwidget_register() {
        register_widget('Avartanliteslider_Widget');
    }

}

add_action('widgets_init', 'Avartansliderwidget_register');
?>
