<?php
defined( 'ABSPATH' ) || exit;


/**
 * Tell WordPress what to do when plugin is loaded.
 *
 * @since 0.1.0
 * @since 0.5.0 Added sanitize functions file.
 *
 * @author Maël Conan
 */
function vmtvw_init() {
    // Do nothing if WordPress makes an automatic backup
    if ( defined( 'DOING_AUTOSAVE' ) ) {
        return;
    }

    // Load other features
    require_once VMTVW_3RD_PARTY_PATH . '3rd-party.php';
    require_once VMTVW_INC_PATH . 'assets.php';
    require_once VMTVW_INC_PATH . 'ajax.php';
    require_once VMTVW_FUNCTIONS_PATH . 'sanitize.php';
    require_once VMTVW_FUNCTIONS_PATH . 'options.php';
    require_once VMTVW_FUNCTIONS_PATH . 'views.php';
    require_once VMTVW_FUNCTIONS_PATH . 'i18n.php';
    require_once VMTVW_FUNCTIONS_PATH . 'api.php';
    require_once VMTVW_INC_PATH . 'shortcode.php';
    require_once VMTVW_INC_PATH . 'render.php';
    if ( is_admin() ) {
        require_once VMTVW_INC_PATH . 'admin.php';
    }

    /**
     * Fires when Travel Visa Widget is fully loaded.
     *
     * @since 0.1.0
     */
    do_action( 'vmtvw/plugins_loaded' );
}
add_action( 'plugins_loaded', 'vmtvw_init', 12 );
