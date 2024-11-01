<?php
defined( 'ABSPATH' ) || exit;


/**
 * Registers widget stylesheet.
 *
 * @since 0.1.0
 * @author Élian Thébault
 *
 * @return void
 */
function vmtvw_register_style() {
    wp_register_style( 'vmtvw-style', VMTVW_URL . 'assets/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'vmtvw_register_style', 990 );


/**
 * Registers widget main script and some JS variables.
 *
 * @since 0.1.0
 * @author Maël Conan
 *
 * @return void
 */
function vmtvw_register_script() {
    wp_register_script( 'vmtvw-script', VMTVW_URL . 'assets/js/script.js', array(), false, true );
    wp_localize_script( 'vmtvw-script', 'vmtvw_localize', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));
}
add_action( 'wp_enqueue_scripts', 'vmtvw_register_script' );
