<?php

class Appspring_Loader {

    public static function activate() {
        // Code to run when plugin is activated (optional for now)
    }

    public static function init() {
        require_once APPSPRING_PLUGIN_PATH . 'includes/class-appspring-api.php';
        require_once APPSPRING_PLUGIN_PATH . 'includes/class-appspring-admin.php';
        require_once APPSPRING_PLUGIN_PATH . 'includes/class-appspring-frontend.php';

        Appspring_API::init();
        Appspring_Admin::init();
        Appspring_Frontend::init();
    }
}

// Hook into plugins_loaded to initialize the plugin
add_action('plugins_loaded', ['Appspring_Loader', 'init']);
