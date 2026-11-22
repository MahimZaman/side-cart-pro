<?php
defined('ABSPATH') || exit;

$settings = wp_parse_args(
    get_option('scp_settings', []),
    \SCP\Settings::defaults()
);
?>

<div class="scp-admin-wrap">
    <div class="scp-header">
        <h1>Side Cart</h1>
        <p>Customize your slide-in WooCommerce cart</p>
    </div>

    <form method="post" action="options.php" class="scp-admin">
        <?php settings_fields('scp_settings_group'); ?>

        <div class="scp-layout">

            <!-- SIDEBAR -->
            <aside class="scp-tabs">
                <button type="button" data-tab="design" class="active">🎨 Design</button>
                <button type="button" data-tab="typography">🔤 Typography</button>
                <button type="button" data-tab="spacing">📐 Spacing</button>
                <button type="button" data-tab="cart">🛒 Cart</button>
            </aside>

            <!-- CONTENT -->
            <section class="scp-content">

                <!-- DESIGN -->
                <div class="scp-panel active" data-panel="design">
                    <h2>Colors</h2>


                    <label class="scp-toggle">
                        <input type="checkbox"
                            name="scp_settings[colors][enable_dark_mode]" value="yes"
                            <?php checked($settings['colors']['enable_dark_mode'], 'yes'); ?>>
                        <span></span>
                        Enable Dark Mode
                    </label>

                    <div class="scp-field">
                        <label>Button Background Color</label>
                        <input type="text"
                            class="scp-color-field"
                            name="scp_settings[colors][button_bg]"
                            value="<?php echo esc_attr($settings['colors']['button_bg']); ?>">
                    </div>

                    <div class="scp-field">
                        <label>Button Text Color</label>
                        <input type="text"
                            class="scp-color-field"
                            name="scp_settings[colors][button_text]"
                            value="<?php echo esc_attr($settings['colors']['button_text']); ?>">
                    </div>

                </div>

                <!-- TYPOGRAPHY -->
                <div class="scp-panel" data-panel="typography">
                    <h2>Typography (Inter)</h2>

                    <div class="scp-field">
                        <label>Font Size (px)</label>
                        <input type="number"
                            name="scp_settings[typography][font_size]"
                            value="<?php echo esc_attr($settings['typography']['font_size']); ?>">
                    </div>


                </div>

                <!-- SPACING -->
                <div class="scp-panel" data-panel="spacing">
                    <h2>Layout</h2>

                    <div class="scp-field">
                        <label>Cart Width (px)</label>
                        <input type="number"
                            name="scp_settings[spacing][cart_width]"
                            value="<?php echo esc_attr($settings['spacing']['cart_width']); ?>">
                    </div>

                    <div class="scp-field">
                        <label>Padding (px)</label>
                        <input type="number"
                            name="scp_settings[spacing][padding]"
                            value="<?php echo esc_attr($settings['spacing']['padding']); ?>">
                    </div>

                    <div class="scp-field">
                        <label>Image Size (px)</label>
                        <input type="number"
                            name="scp_settings[spacing][image_size]"
                            value="<?php echo esc_attr($settings['spacing']['image_size']); ?>">
                    </div>
                </div>

                <!-- CART -->
                <div class="scp-panel" data-panel="cart">
                    <h2>Cart Behavior</h2>

                    <label class="scp-toggle">
                        <input type="checkbox"
                            name="scp_settings[cart][enable_quantity]" value="yes"
                            <?php checked($settings['cart']['enable_quantity'], 'yes'); ?>>
                        <span></span>
                        Enable Quantity Selector
                    </label>

                    <label class="scp-toggle">
                        <input type="checkbox"
                            name="scp_settings[cart][enable_upsells]" value="yes"
                            <?php checked($settings['cart']['enable_upsells'], 'yes'); ?>>
                        <span></span>
                        Enable Upsells
                    </label>

                    <label class="scp-toggle">
                        <input type="checkbox"
                            name="scp_settings[cart][show_checkout]" value="yes"
                            <?php checked($settings['cart']['show_checkout'], 'yes'); ?>>
                        <span></span>
                        Show Checkout Button
                    </label>

                    <div class="scp-field">
                        <label>Checkout Button Text</label>
                        <input type="text"
                            name="scp_settings[cart][checkout_button_text]"
                            value="<?php echo esc_attr($settings['cart']['checkout_button_text']); ?>">
                    </div>
                </div>

            </section>
        </div>

        <div class="scp-footer">
            <?php submit_button('Save Settings'); ?>
        </div>
    </form>
</div>