<?php
/**
 * Plugin Name: Travel Visa Widget
 * Plugin URI: https://wordpress.org/plugins/travel-visa-widget/
 * Description: Travel Visa Widget is a tool to know which countries need a travel visa.
 * Version: 0.6.0
 * Requires at least: 5.3
 * Requires PHP: 7.0
 * Author: Visamundi
 * Author URI: https://www.visamundi.co/
 * Licence: GPLv2 or later
 *
 * Text Domain: travel-visa-widget
 * Domain Path: languages
 */

defined( 'ABSPATH' ) || exit;


// Travel Visa Widget defines
define( 'VMTVW_VERSION',            '0.6.0' );
define( 'VMTVW_FILE',               __FILE__ );
define( 'VMTVW_PATH',               realpath( plugin_dir_path( VMTVW_FILE ) ) . DIRECTORY_SEPARATOR );
define( 'VMTVW_INC_PATH',           realpath( VMTVW_PATH . 'inc' ) . DIRECTORY_SEPARATOR );
define( 'VMTVW_VIEWS_PATH',         realpath( VMTVW_PATH . 'views' ) . DIRECTORY_SEPARATOR );

define( 'VMTVW_3RD_PARTY_PATH',     VMTVW_INC_PATH . '3rd-party' . DIRECTORY_SEPARATOR );
define( 'VMTVW_BLOCKS_PATH',        VMTVW_INC_PATH . 'blocks' . DIRECTORY_SEPARATOR );
define( 'VMTVW_FUNCTIONS_PATH',     VMTVW_INC_PATH . 'functions' . DIRECTORY_SEPARATOR );
define( 'VMTVW_WIDGET_PATH',        VMTVW_INC_PATH . 'widget' . DIRECTORY_SEPARATOR );

define( 'VMTVW_URL',                plugin_dir_url( VMTVW_FILE ) );

define( 'VISAMUNDI_API_URL',        'https://api.visamundi.fr' );


/**
 * Load Travel Visa Widget translations from language directories.
 *
 * @since 0.1.0
 * @author Maël Conan
 */
function vmtvw_load_textdomain() {
    $locale = get_locale();

    $locale = apply_filters( 'plugin_locale', $locale, 'travel-visa-widget' );
    load_textdomain( 'travel-visa-widget', WP_LANG_DIR . '/plugins/travel-visa-widget-' . $locale . '.mo' );

    load_plugin_textdomain( 'travel-visa-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'vmtvw_load_textdomain' );


// Travel Visa Widget main loader
require_once VMTVW_INC_PATH . 'main.php';
