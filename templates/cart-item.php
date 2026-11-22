<?php
defined('ABSPATH') || exit;

$product   = $item['data'];
$qty       = $item['quantity'];
$product_id = $product->get_id();
$product_link = get_permalink($product_id);

// Variations
$variation_data = [];
if (! empty($item['variation'])) {
    foreach ($item['variation'] as $attr => $value) {
        $label = wc_attribute_label(str_replace('attribute_', '', $attr));
        $variation_data[] = $label . ': ' . $value;
    }
}
?>

<div class="scp-cart-item" data-key="<?php echo esc_attr($key); ?>">

    <!-- LEFT COLUMN -->
    <div class="scp-item-image">
        <a href="<?php echo esc_url($product_link); ?>">
            <?php echo $product->get_image([100, 100]); ?>
        </a>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="scp-item-body">

        <!-- TITLE -->
        <a href="<?php echo esc_url($product_link); ?>" class="scp-item-title">
            <?php echo esc_html($product->get_name()); ?>
        </a>

        <!-- VARIATIONS -->
        <?php if (! empty($variation_data)) : ?>
            <ul class="scp-item-variations">
                <?php foreach ($variation_data as $variation) : ?>
                    <li><?php echo esc_html($variation); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <!-- Price -->
        <div class="scp-item-pricing">
            <?php
            echo $product->get_price_html();
            ?>
        </div>

        <!-- QTY + REMOVE -->
        <div class="scp-item-actions">
            <?php if (get_option('scp_settings')['cart']['enable_quantity']) : ?>
                <div class="scp-qty">
                    <button type="button"
                        class="scp-qty-minus"
                        data-key="<?php echo esc_attr($key); ?>">
                        -
                    </button>

                    <input
                        type="number"
                        min="1"
                        class="scp-qty-input"
                        data-key="<?php echo esc_attr($key); ?>"
                        value="<?php echo esc_attr($qty); ?>">

                    <button type="button"
                        class="scp-qty-plus"
                        data-key="<?php echo esc_attr($key); ?>">
                        +
                    </button>
                </div>
            <?php endif; ?>

            <button type="button"
                class="scp-remove"
                data-key="<?php echo esc_attr($key); ?>"
                aria-label="<?php esc_attr_e('Remove item', 'side-cart-pro'); ?>">
                <i class="ri-delete-bin-line"></i>
                <span class="scp-remove-text"><?php echo __('Remove', 'side-cart-pro'); ?></span>
            </button>
        </div>
    </div>
</div>