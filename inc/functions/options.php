<?php
defined( 'ABSPATH' ) || exit;


/**
 * Retrieves an option value based on an option name.
 *
 * @since 0.2.0
 * @author Maël Conan
 *
 * @param string $option        Name of the option to retrieve.
 * @param mixed $default        Default value to return if the option does not exist.
 *
 * @return mixed                Value of the option or it's default value. If there is no option in the database or no default value, boolean false is returned.
 */
function vmtvw_get_option( $option, $default = false ) {
    $vmtvw_options = get_option( 'vmtvw_options' );
    if ( is_array( $vmtvw_options ) && array_key_exists( $option, $vmtvw_options ) && ! empty( $vmtvw_options[ $option ] ) ) {
        return $vmtvw_options[ $option ];
    }
    return $default;
}
