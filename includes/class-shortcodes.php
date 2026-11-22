<?php

namespace SCP;

defined('ABSPATH') || exit;

class Shortcodes
{

    public static function init()
    {
        add_shortcode('side_cart_button', [__CLASS__, 'button']);
        add_shortcode('scp_cart_upsells', [__CLASS__, 'scp_render_cart_upsells']);
    }

    public static function button()
    {
        ob_start(); ?>
        <button class="scp-cart-toggle">
            <span class="scp-icon"><i class="ri-shopping-bag-4-line"></i></span>
            <span class="scp-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </button>
    <?php
        return ob_get_clean();
    }

    public static function scp_render_cart_upsells()
    {
        ob_start(); ?>

        <div id="scp-upsell-container">
            <div class="scp-loading">Loading...</div>
        </div>

<?php
        return ob_get_clean();
    }
}
