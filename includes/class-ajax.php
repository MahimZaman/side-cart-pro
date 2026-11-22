<?php

namespace SCP;

defined('ABSPATH') || exit;

class Ajax
{

    public static function init()
    {
        add_action('wp_ajax_scp_update_qty', [__CLASS__, 'update_qty']);
        add_action('wp_ajax_nopriv_scp_update_qty', [__CLASS__, 'update_qty']);

        add_action('wp_ajax_scp_remove_item', [__CLASS__, 'remove_item']);
        add_action('wp_ajax_nopriv_scp_remove_item', [__CLASS__, 'remove_item']);

        add_action('wp_ajax_scp_add_to_cart', [__CLASS__, 'scp_ajax_add_to_cart']);
        add_action('wp_ajax_nopriv_scp_add_to_cart', [__CLASS__, 'scp_ajax_add_to_cart']);

        add_action('wp_ajax_scp_load_variations', [__CLASS__, 'scp_load_variation_popup']);
        add_action('wp_ajax_nopriv_scp_load_variations', [__CLASS__, 'scp_load_variation_popup']);

        add_action('wp_ajax_scp_get_upsell_loop', [__CLASS__, 'scp_get_upsell_loop']);
        add_action('wp_ajax_nopriv_scp_get_upsell_loop', [__CLASS__, 'scp_get_upsell_loop']);

        add_action('wp_ajax_scp_load_cart', [__CLASS__, 'scp_load_cart']);
        add_action('wp_ajax_nopriv_scp_load_cart', [__CLASS__, 'scp_load_cart']);
    }

    public static function scp_load_cart()
    {
        ob_start();
        if (WC()->cart->is_empty()) :
            echo '<p>Your cart is empty.</p>';
        else :
            foreach (WC()->cart->get_cart() as $key => $item) :
                wc_get_template(
                    'cart-item.php',
                    compact('item', 'key'),
                    'side-cart/',
                    SCP_PATH . 'templates/'
                );
            endforeach;
        endif;
        $cart = ob_get_clean();
        wp_send_json_success([
            'cart' => $cart,
        ]);
    }

    public static function scp_get_upsell_loop()
    {

        check_ajax_referer('scp_upsell_nonce', 'nonce');

        if (WC()->cart->is_empty()) {
            echo '<p>No upsells available</p>';
            wp_die();
        }

        $cart_ids = array();

        foreach (WC()->cart->get_cart() as $item) {
            $cart_ids[] = $item['product_id'];
        }

        $upsell_ids = array();

        foreach ($cart_ids as $pid) {
            $product = wc_get_product($pid);
            if ($product) {
                $upsell_ids = array_merge($upsell_ids, $product->get_upsell_ids());
            }
        }

        $upsell_ids = array_unique($upsell_ids);
        $upsell_ids = array_diff($upsell_ids, $cart_ids);

        if (empty($upsell_ids)) {
            echo '<p>No upsells available</p>';
            wp_die();
        }

?>

        <div class="swiper scp-upsell-slider">
            <div class="swiper-wrapper">

                <?php foreach ($upsell_ids as $upsell_id) :
                    $product = wc_get_product($upsell_id);
                    if (!$product) continue;
                ?>

                    <div class="swiper-slide">
                        <div class="scp-upsell-item" data-product-id="<?php echo esc_attr($upsell_id); ?>"
                            data-product-type="<?php echo esc_attr($product->get_type()); ?>">
                            <?php echo $product->get_image('woocommerce_thumbnail'); ?>
                            <div class="scp_upsell_item_details">
                                <a href="<?php echo get_permalink($product->get_id()) ?>"><?php echo esc_html($product->get_name()); ?></a>
                                <span><?php echo $product->get_price_html(); ?></span>
                                <button class="button scp-add-to-cart">
                                    <span class="scp-button-text">
                                        <?php _e('Add', 'side-cart-pro'); ?>
                                    </span>
                                    <span class="scp-btn-loader"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>

    <?php

        wp_die();
    }

    public static function scp_load_variation_popup()
    {

        check_ajax_referer('scp_upsell_nonce', 'nonce');

        $product_id = absint($_POST['product_id']);
        $product    = wc_get_product($product_id);

        if (! $product || ! $product->is_type('variable')) {
            wp_die();
        }

        $available_variations = $product->get_available_variations();
        $attributes           = $product->get_variation_attributes();
    ?>

        <div class="scp-variation-popup" data-product-id="<?php echo esc_attr($product_id); ?>">

            <div class="scp-popup-header">
                <h3><?php echo esc_html($product->get_name()); ?></h3>
            </div>

            <div class="scp-popup-body">

                <div class="scp-popup-image">
                    <?php echo $product->get_image('medium'); ?>
                </div>

                <form class="scp-variation-form"
                    data-product_id="<?php echo esc_attr($product_id); ?>"
                    data-variations='<?php echo wp_json_encode($available_variations); ?>'>

                    <?php foreach ($attributes as $attribute_name => $options) : ?>

                        <div class="scp-attr-row">
                            <label><?php echo wc_attribute_label($attribute_name); ?></label>

                            <select name="attribute_<?php echo esc_attr($attribute_name); ?>" class="scp-variation-select">
                                <option value="">Choose</option>

                                <?php foreach ($options as $option) : ?>
                                    <option value="<?php echo esc_attr($option); ?>">
                                        <?php echo esc_html($option); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                    <?php endforeach; ?>

                    <input type="hidden" name="variation_id" value="0">

                    <button type="submit" class="button scp-variable-add-to-cart">
                        Add to cart
                    </button>

                </form>

            </div>

        </div>

<?php

        wp_die();
    }


    public static function scp_ajax_add_to_cart()
    {

        check_ajax_referer('scp_upsell_nonce', 'nonce');

        $product_id = absint($_POST['product_id']);
        $variation_id = absint($_POST['variation_id'] ?? 0);
        $variations = $_POST['variations'] ?? array();

        if ($variation_id) {
            WC()->cart->add_to_cart($product_id, 1, $variation_id, $variations);
        } else {
            WC()->cart->add_to_cart($product_id);
        }

        \WC_AJAX::get_refreshed_fragments();
        wp_die();
    }

    public static function update_qty()
    {
        check_ajax_referer('scp_nonce', 'nonce');

        $key = sanitize_text_field($_POST['key']);
        $qty = max(0, intval($_POST['qty']));

        if ($qty === 0) {
            WC()->cart->remove_cart_item($key);
        } else {
            WC()->cart->set_quantity($key, $qty, true);
        }

        WC()->cart->calculate_totals();
        self::send_cart();
    }

    public static function remove_item()
    {
        check_ajax_referer('scp_nonce', 'nonce');

        $key = sanitize_text_field($_POST['key']);
        WC()->cart->remove_cart_item($key);
        WC()->cart->calculate_totals();

        self::send_cart();
    }

    private static function send_cart()
    {
        ob_start();
        wc_get_template(
            'mini-cart.php',
            [],
            'side-cart/',
            SCP_PATH . 'templates/'
        );

        wp_send_json_success([
            'html'  => ob_get_clean(),
            'count' => WC()->cart->get_cart_contents_count(),
        ]);
    }
}
