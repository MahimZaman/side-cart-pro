<?php

namespace SCP;

defined('ABSPATH') || exit;

class Assets
{

    public static function init()
    {
        add_action('wp_enqueue_scripts', [__CLASS__, 'frontend']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'admin']);
        add_action('wp_enqueue_scripts', [__CLASS__, 'scp_enqueue_upsell_assets']);
    }

    public static function scp_enqueue_upsell_assets()
    {
        wp_enqueue_style(
            'scp-swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css'
        );

        wp_enqueue_script(
            'scp-swiper',
            'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            array(),
            null,
            true
        );

        wp_enqueue_script(
            'scp-upsell',
            SCP_URL . 'assets/js/scp-upsell.js',
            array('jquery'),
            '1.0',
            true
        );

        wp_localize_script('scp-upsell', 'scpUpsell', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('scp_upsell_nonce')
        ));
    }

    public static function frontend()
    {
        wp_enqueue_style(
            'scp-remixicon',
            'https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css',
            [],
            SCP_VERSION
        );

        wp_enqueue_style(
            'scp-styles',
            SCP_URL . 'assets/css/scpStyles.css',
            [],
            SCP_VERSION
        );

        wp_enqueue_style(
            'scp-frontend',
            SCP_URL . 'assets/css/frontend.css',
            [],
            SCP_VERSION
        );

        wp_enqueue_script(
            'scp-functions-js',
            SCP_URL . 'assets/js/scpFunctions.js',
            ['jquery'],
            SCP_VERSION,
            true
        );

        wp_enqueue_script(
            'scp-frontend-js',
            SCP_URL . 'assets/js/frontend.js',
            ['jquery', 'wc-cart-fragments'],
            SCP_VERSION,
            true
        );


        wp_localize_script('scp-frontend-js', 'scpAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('scp_nonce'),
        ]);
    }

    public static function admin()
    {
        wp_enqueue_style(
            'scp-remixicon',
            'https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css',
            [],
            SCP_VERSION
        );

        wp_enqueue_style(
            'scp-styles',
            SCP_URL . 'assets/css/scpStyles.css',
            [],
            SCP_VERSION
        );

        wp_enqueue_style(
            'scp-admin',
            SCP_URL . 'assets/css/admin.css',
            [],
            SCP_VERSION
        );

        wp_enqueue_style('wp-color-picker');

        wp_enqueue_script(
            'scp-functions-js',
            SCP_URL . 'assets/js/scpFunctions.js',
            ['jquery'],
            SCP_VERSION,
            true
        );

        wp_enqueue_script(
            'scp-admin',
            SCP_URL . 'assets/js/admin.js',
            ['jquery'],
            SCP_VERSION,
            true
        );
    }
}
