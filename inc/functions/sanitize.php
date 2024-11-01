<?php
defined( 'ABSPATH' ) || exit;


/**
 * Strips out all characters that are not allowable in the agency ID.
 *
 * @since 0.5.0
 * @author Maël Conan
 *
 * @param string $agency_id     Agency ID to filter.
 *
 * @return string               Filtered agency ID.
 */
function vmtvw_sanitize_agency_id( $agency_id ) {
    $agency_id = preg_replace( "/[^0-9]/", "", $agency_id );

    return $agency_id;
}


/**
 * Strips out all characters that are not allowable in the Affilae ID.
 *
 * @since 0.5.0
 * @author Maël Conan
 *
 * @param string $affilae_id    Affilae ID to filter.
 *
 * @return string               Filtered Affilae ID.
 */
function vmtvw_sanitize_affilae_id( $affilae_id ) {
    $affilae_id = preg_replace( "/[^0-9]/", "", $affilae_id );
    $affilae_id = ! empty( $affilae_id ) ? 'ae' . $affilae_id : '';

    return $affilae_id;
}
