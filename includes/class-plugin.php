<?php

namespace SCP;

defined('ABSPATH') || exit;

class Plugin
{

    private static $instance;

    public static function instance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->includes();
        $this->init();
    }

    private function includes()
    {
        require_once SCP_PATH . 'includes/class-assets.php';
        require_once SCP_PATH . 'includes/class-shortcodes.php';
        require_once SCP_PATH . 'includes/class-ajax.php';
        require_once SCP_PATH . 'includes/class-templates.php';
        require_once SCP_PATH . 'includes/class-settings.php';
        require_once SCP_PATH . 'includes/class-css-vars.php';

        if (is_admin()) {
            require_once SCP_PATH . 'admin/class-admin.php';
        } else {
            require_once SCP_PATH . 'frontend/class-frontend.php';
        }
    }

    private function init()
    {
        Assets::init();
        Shortcodes::init();
        Ajax::init();
        Templates::init();
        Css_Vars::init();
        Settings::init();
    }
}
