<?php

namespace SCP;

defined('ABSPATH') || exit;

class Frontend
{

    public function __construct()
    {
        add_action('wp_footer', [$this, 'render_cart']);
        add_filter('woocommerce_add_to_cart_fragments', [$this, 'cart_fragments']);
    }

    public function cart_fragments($fragments)
    {
        ob_start();
?>
        <span class="scp-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
<?php
        $fragments['.scp-count'] = ob_get_clean();

        return $fragments;
    }

    public function render_cart()
    {
        wc_get_template(
            'mini-cart.php',
            [],
            'side-cart/',
            SCP_PATH . 'templates/'
        );
    }
}

new Frontend();
