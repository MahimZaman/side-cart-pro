<?php
namespace SCP;

defined( 'ABSPATH' ) || exit;

class Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'menu' ] );
    }

    public function menu() {
        add_menu_page(
            'Side Cart',
            'Side Cart',
            'manage_options',
            'scp-settings',
            [ $this, 'render' ],
            'dashicons-cart'
        );
    }

    public function render() {
        require SCP_PATH . 'admin/views/settings-page.php';
    }
}

new Admin();
