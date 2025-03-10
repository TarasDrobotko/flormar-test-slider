<?php
/*
Plugin Name: Flormar Test Slider
Plugin URI: https://github.com/TarasDrobotko/flormar-test-slider
Description: The plugin adds the [flormar-test-slider] shortcode to display the WooCommerce responsive product slider.
Version: 1.0.0
Text Domain: flormar-test-slider
Domain Path: /languages
Author: Drobotko Taras
Author URI: https://drobotkot.xyz/
Requires Plugins: woocommerce 
*/

if (
    ! defined('ABSPATH')
) {
    exit;
}

define('FL_SLIDER_VERSION', '1.0.0');
define('FL_SLIDER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('FL_SLIDER_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Check if WooCommerce plugin is active
 */
function fl_check_activation()
{
    if (! class_exists('WooCommerce')) {
        if (is_plugin_active(plugin_basename(__FILE__))) {
            // deactivate the plugin
            deactivate_plugins(plugin_basename(__FILE__));

            // unset activation notice
            unset($_GET['activate']);

            // display notice
            add_action('admin_notices', 'fl_admin_notices');
        }
    }
}


// Check required plugin is activated or not
add_action('admin_init', 'fl_check_activation');

/**
 * Admin notices
 */
function fl_admin_notices()
{
    if (! class_exists('WooCommerce')) {
        echo '<div class="error notice is-dismissible">';

        echo sprintf(__('<p><strong>%s</strong> requires the following plugin to be installed & activated.</p>', 'flormar-test-slider'), 'Flormar Test Slider');

        echo sprintf(__('<p><strong><a href="%s" target="_blank">%s</a> </strong></p>', 'flormar-test-slider'), 'https://wordpress.org/plugins/woocommerce/', 'WooCommerce');

        echo '</div>';
    }
}

/**
 * Load the plugin after the main plugin is loaded.
 */
function fl_load_plugin()
{
    // Check main plugin is active or not
    if (class_exists('WooCommerce')) {
        /**
         * Add Go To Settings Page
         */
        // function fl_goto_settings_page_link($links)
        // {
        //     $goto_settings_link = array('<a href="' . admin_url('edit.php?post_type=product&page=flormar-test-slider') . '">' . __('Settings', 'flormar-test-slider') . '</a>');

        //     return array_merge($links, $goto_settings_link);
        // }

        // add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'fl_goto_settings_page_link');

        /**
         * Load Text Domain
         */
        function fl_load_textdomain()
        {
            load_plugin_textdomain('flormar-test-slider', '', dirname(plugin_basename(__FILE__)) . '/languages/');
        }

        // Action to load plugin text domain
        add_action('plugins_loaded', 'fl_load_textdomain');

        add_action('wp_enqueue_scripts', 'fl_test_slider_enqueue_scripts');

        /**
         * Function to add frontend scripts and styles
         */
        function fl_test_slider_enqueue_scripts()
        {
            wp_enqueue_style('fl-slider-style', FL_SLIDER_PLUGIN_URL . 'assets/css/styles.css', array(), FL_SLIDER_VERSION);

            wp_enqueue_style('slick-css', FL_SLIDER_PLUGIN_URL . 'assets/src/library/css/slick.css', [], FL_SLIDER_VERSION);
            wp_enqueue_style('slick-theme-css', FL_SLIDER_PLUGIN_URL . 'assets/src/library/css/slick-theme.css', ['slick-css'], FL_SLIDER_VERSION);
            wp_enqueue_script('slick-js', FL_SLIDER_PLUGIN_URL . 'assets/src/library/js/slick.min.js', ['jquery'], FL_SLIDER_VERSION, true);
            wp_enqueue_script('carousel-js', FL_SLIDER_PLUGIN_URL . 'assets/src/carousel/index.js', ['jquery', 'slick-js'], FL_SLIDER_VERSION, true);
        }

        add_action('wp_enqueue_scripts', 'fl_test_slider_enqueue_scripts');
    }
}

// Action to load plugin after the main plugin is loaded
add_action('plugins_loaded', 'fl_load_plugin', 15);


add_shortcode('flormar-test-slider', 'fl_test_slider');

function fl_test_slider($atts)
{
    $defaults =  array(
        'max-price' => -1,
        'min-price' => 0,
    );

    $atts = shortcode_atts(
        $defaults,

        $atts
    );

    extract($atts);

    ob_start();

    require_once 'partials/slider-content.php';

    $output = ob_get_contents();

    $slider =  $output;
    ob_end_clean();

    return $slider;
}
