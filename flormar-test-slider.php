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

define('FL_TEST_SLIDER_VERSION', '1.0.0');
define('FL_TEST_SLIDER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('FL_TEST_SLIDER_PLUGIN_URL', plugin_dir_url(__FILE__));

add_action('plugins_loaded', 'fl_init_slider_class');

function fl_init_slider_class()
{
    include_once(FL_TEST_SLIDER_PLUGIN_PATH . 'class-fl-test-slider.php');
}

add_action('wp_enqueue_scripts', 'fl_test_slider_enqueue_scripts');

function fl_test_slider_enqueue_scripts()
{
    wp_register_style('fl-slider-style', plugins_url('/assets/css/styles.css', __FILE__), false);
    wp_enqueue_style('fl-slider-style');
}

add_action('wp_enqueue_scripts', 'fl_slick_register_styles');

function fl_slick_register_styles()
{
    wp_enqueue_style('slick-css', plugins_url('/assets/src/library/css/slick.css', __FILE__), [], false, 'all');
    wp_enqueue_style('slick-theme-css', plugins_url('/assets/src/library/css/slick-theme.css', __FILE__), ['slick-css'], false, 'all');
    wp_enqueue_script('slick-js', plugins_url('/assets/src/library/js/slick.min.js', __FILE__), ['jquery'], false, true);
    wp_enqueue_script('carousel-js', plugins_url('/assets/src/carousel/index.js', __FILE__), ['jquery', 'slick-js'], false, true);
}
