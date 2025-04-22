<?php
/**
 * Plugin Name: WP Appspring Test
 * Description: Custom plugin to fetch and display providers and tags from external APIs.
 * Version: 1.0.0
 * Author: Gerson Salcedo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('APPSPRING_PLUGIN_VERSION', '1.0.0');
define('APPSPRING_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('APPSPRING_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load the plugin loader
require_once APPSPRING_PLUGIN_PATH . 'includes/class-appspring-loader.php';

// Plugin activation hook
register_activation_hook(__FILE__, ['Appspring_Loader', 'activate']);

// Load CSS and JS only for the /providers page
add_action('wp_enqueue_scripts', function () {
        wp_enqueue_style('appspring-choices', plugins_url('assets/vendor/choices/choices.min.css', __FILE__));
        wp_enqueue_style('appspring-custom-css', plugins_url('assets/css/providers.css', __FILE__));
        wp_enqueue_script('appspring-choices', plugins_url('assets/vendor/choices/choices.min.js', __FILE__), [], null, true);
        wp_enqueue_script('appspring-custom-js', plugins_url('assets/js/providers.js', __FILE__), ['appspring-choices'], null, true);

});
