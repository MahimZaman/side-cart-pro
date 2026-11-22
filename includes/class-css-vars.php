<?php

namespace SCP;

defined('ABSPATH') || exit;

class Css_Vars
{

    public static function init()
    {
        add_action('wp_head', [__CLASS__, 'output']);
    }

    public static function output()
    {
        $s = get_option('scp_settings', Settings::defaults()); ?>
        <style>
            :root {
                --scp-primary: <?php echo esc_html($s['colors']['primary']); ?>;
                --scp-bg: <?php echo esc_html($s['colors']['background']); ?>;
                --scp-text: <?php echo esc_html($s['colors']['text']); ?>;
                --scp-font-size: <?php echo intval($s['typography']['font_size']); ?>px;
                --scp-cart-width: <?php echo intval($s['spacing']['cart_width']); ?>px;
                --scp-padding: <?php echo intval($s['spacing']['padding']); ?>px;
                --scp-image-size: <?php echo intval($s['spacing']['image_size']); ?>px;
                --scp-background: <?php echo $s['colors']['enable_dark_mode'] == 'yes' ? '#121212' : '#ffffff' ?>;
                --scp-color: <?php echo $s['colors']['enable_dark_mode'] == 'yes' ? '#ffffff' : '#121212' ?>;
                --scp-border-color: <?php echo $s['colors']['enable_dark_mode'] == 'yes' ? 'rgb(57, 54, 54)' : '#eeeeee' ?>;
                --scp-btn-bg: <?php echo $s['colors']['button_bg'] ?>;
                --scp-btn-text: <?php echo $s['colors']['button_text'] ?>;
            }
        </style>
<?php
    }
}
