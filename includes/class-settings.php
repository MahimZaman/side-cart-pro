<?php

namespace SCP;

defined('ABSPATH') || exit;

class Settings
{

    public static function init()
    {
        add_action('admin_init', [__CLASS__, 'register']);
    }

    public static function register()
    {
        register_setting(
            'scp_settings_group',
            'scp_settings',
            ['sanitize_callback' => [__CLASS__, 'sanitize']]
        );
    }

    public static function sanitize($input)
    {
        return wp_parse_args($input, self::defaults());
    }

    public static function defaults()
    {
        return [
            'colors' => [
                'primary' => '#4f46e5',
                'button_bg' => '#121212',
                'button_text' => '#ffffff',
            ],
            'typography' => [
                'font_size' => 14,
                'font_weight' => 500,
                'line_height' => 1.5,
                'letter_spacing' => 0.2,
            ],
            'spacing' => [
                'cart_width' => 380,
                'padding' => 16,
                'image_size' => 90,
            ],
            'cart' => [
                'enable_quantity' => true,
                'show_checkout' => true,
                'cart_button_text' => 'View Cart',
                'checkout_button_text' => 'Checkout',
            ],
        ];
    }
}
