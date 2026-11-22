<?php
/**
 * Plugin Name: Side Cart Pro
 * Plugin URI: https://condixia.com
 * Author: Mahim Zaman (Condixia)
 * Author URI: https://mahimzaman.com
 * Description: Modern slide-in WooCommerce side cart.
 * Version: 1.0.0
 * Text Domain: side-cart-pro
 */

defined( 'ABSPATH' ) || exit;

define( 'SCP_PATH', plugin_dir_path( __FILE__ ) );
define( 'SCP_URL', plugin_dir_url( __FILE__ ) );
define( 'SCP_VERSION', '1.0.0' );

require_once SCP_PATH . 'includes/class-plugin.php';

add_action( 'plugins_loaded', function () {
    if ( class_exists( 'WooCommerce' ) ) {
        SCP\Plugin::instance();
    }
});
