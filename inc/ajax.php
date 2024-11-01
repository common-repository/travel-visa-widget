<?php
defined( 'ABSPATH' ) || exit;


/**
 * Handles ajax request to get visa requirement result.
 *
 * @since 0.1.0
 * @since 0.5.0 Added get agency/Affilae IDs and send them to API request.
 *
 * @author Maël Conan
 */
function vmtvw_get_ajax_requirement_result() {
    $error = true;

    if(
        ( isset( $_GET[ 'nationality' ] ) && preg_match( "/^([A-Z]){3}$/", $_GET[ 'nationality' ] ) ) ||
        ( isset( $_GET[ 'destination' ] ) && preg_match( "/^([A-Z]){3}$/", $_GET[ 'destination' ] ) )
    ) {
        $nationality = sanitize_text_field( $_GET[ 'nationality' ] );
        $destination = sanitize_text_field( $_GET[ 'destination' ] );
        $agency_id = vmtvw_sanitize_agency_id( $_GET[ 'agency_id' ] );
        $affilae_id = vmtvw_sanitize_affilae_id( $_GET[ 'affilae_id' ] );

        $data = vmtvw_get_requirement( $nationality, $destination, array(
            'agency_id' => $agency_id,
            'affilae_id' => $affilae_id
        ) );

        if ( $data ) {
            $error = false;
            echo vmtvw_format_result( $data );
        }
    }

    if ( $error ) {
        echo '<p class="vmtvw-error">' . __( "An error occurred", 'travel-visa-widget' ) . '</p>';
    }

    exit;
}
add_action( 'wp_ajax_vmtvw_get_ajax_requirement_result', 'vmtvw_get_ajax_requirement_result' );
add_action( 'wp_ajax_nopriv_vmtvw_get_ajax_requirement_result', 'vmtvw_get_ajax_requirement_result' );
