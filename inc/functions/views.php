<?php
defined( 'ABSPATH' ) || exit;


/**
 * Get a view content.
 *
 * @since 0.1.0
 * @author Maël Conan
 *
 * @param string $view      The view name.
 * @param mixed $data       Some data to pass to the view.
 *
 * @return string|boolean   The view content. False if the view doesn't exist.
 */
function vmtvw_get_view( $view, $data = array() ) {
    $path = str_replace( '_', '-', $view );
    $path = VMTVW_VIEWS_PATH . $view . '.php';

    if( ! @file_exists( $path ) ) {
        return false;
    }

    ob_start();
    include $path;
    $contents = ob_get_clean();

    return trim( (string)$contents );
}


/**
 * Print a view.
 *
 * @since 0.1.0
 * @author Maël Conan
 *
 * @param string $view      The view name.
 * @param mixed $data       Some data to pass to the view.
 */
function vmtvw_print_view( $view, $data = array() ) {
    echo vmtvw_get_view( $view, $data );
}
