<?php defined('ABSPATH') || exit; ?>

<div class="scp-side-cart">
    <div class="scp-header">
        <h3><?php _e('Cart', 'scp'); ?> (<span class="scp-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>)</h3>
        <button class="scp-close">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-cancel" viewBox="0 0 24 24">
                <path d="M6.758 17.243 12.001 12m5.243-5.243L12 12m0 0L6.758 6.757M12.001 12l5.243 5.243" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
    </div>
    <div class="scp-body">
        <div class="scp-cart-items">
            <div class="scp-skeleton-loader">
                <div class="scp-skeleton-item">
                    <div class="scp-image-skeleton"></div>
                    <div class="scp-detail-skeleton">
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                    </div>
                </div>
                <div class="scp-skeleton-item">
                    <div class="scp-image-skeleton"></div>
                    <div class="scp-detail-skeleton">
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                    </div>
                </div>
                <div class="scp-skeleton-item">
                    <div class="scp-image-skeleton"></div>
                    <div class="scp-detail-skeleton">
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                    </div>
                </div>
            </div>
            <?php
            
            ?>
        </div>
        <span class="scp-container-loader"></span>
    </div>
    <div class="scp-footer">
        <div class="scp-upsell-container">
            <?php echo do_shortcode('[scp_cart_upsells]'); ?>
        </div>
        <div class="scp-subtotal-container">
            <label><?php _e('Subtotal', 'scp'); ?></label>
            <span class="scp-subtotal"><?php echo WC()->cart->get_total(); ?></span>
        </div>
        <a href="<?php echo wc_get_checkout_url() ?>" class="scp-button scp-checkout"><?php _e('Checkout', 'scp'); ?></a>
    </div>
</div>