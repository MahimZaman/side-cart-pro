<?php
namespace SCP;

defined( 'ABSPATH' ) || exit;

class Templates {

    public static function init() {
        add_filter( 'wc_get_template', [ __CLASS__, 'load' ], 10, 5 );
    }

    public static function load( $template, $template_name, $args, $template_path, $default_path ) {

        if ( strpos( $template_name, 'side-cart/' ) === false ) {
            return $template;
        }

        $theme_template = locate_template( $template_name );

        if ( $theme_template ) {
            return $theme_template;
        }

        return SCP_PATH . 'templates/' . basename( $template_name );
    }
}
