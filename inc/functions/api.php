<?php
defined( 'ABSPATH' ) || exit;


/**
 * Returns the list of countries from the Visamundi API.
 *
 * @since 0.1.0
 * @since 0.5.1 Changed endpoint url.
 *
 * @author Maël Conan
 *
 * @return boolean|object       Countries list in case of success. False if an error occured.
 */
function vmtvw_get_countries() {
    // Current page language
    $language = vmtvw_get_current_language();

    // Get_countries
    if ( false === ( $countries = get_transient( "vmtvw_countries_{$language}" ) ) ) {
        // Builds the request URL
        $request_url = add_query_arg( array(
            'language' => $language
        ), VISAMUNDI_API_URL . '/v1.1/e/countries' );

        // Do the request to the API
        $response = wp_remote_get( $request_url, array(
            'timeout' => 10,
            'sslverify' => false
        ) );

        // If the HTTP code is 200 ... We continue
        if ( wp_remote_retrieve_response_code( $response ) === 200 ) {
            $list = wp_remote_retrieve_body( $response );
            if ( ! empty( $list ) ) {
                $list = json_decode( $list );
                if ( json_last_error() === JSON_ERROR_NONE && isset( $list->data->countries ) && ! empty( $list->data->countries ) ) {
                    $countries = $list->data->countries;

                    // Alphabetical sorting of the list
                    usort( $countries, function( $a, $b ) {
                        return strcmp( remove_accents( $a->name ), remove_accents( $b->name ) );
                    } );

                    // Recording in a dedicated transient for a week
                    set_transient( "vmtvw_countries_{$language}", $countries, WEEK_IN_SECONDS );
                }
            }
        }
    }

    return $countries;
}


/**
 * Returns the visa requirement between the country pair (nationality/destination) from the Visamundi API.
 *
 * @since 0.1.0
 * @since 0.5.0 Added third parameter '$attributs' and agency/Affilae IDs override.
 * @since 0.5.1 Changed endpoint url.
 *
 * @author Maël Conan
 *
 * @param string $nationality       ISO 3166‑1 alpha‑3 code of nationality country.
 * @param string $destination       ISO 3166‑1 alpha‑3 code of destination country.
 * @param array $attributs
 *
 * @return boolean|object           The visa requirement and translations data in case of success. False if an error occured.
 */
function vmtvw_get_requirement( $nationality, $destination, $attributs = array() ) {
    // Current page language
    $language = vmtvw_get_current_language();

    // Build the request URL
    $request_url = add_query_arg( array(
        'language' => $language,
        'nationality' => $nationality,
        'destination' => $destination
    ), VISAMUNDI_API_URL . '/v1.1/e/visa/requirements' );

    // Do the request to the API
    $response = wp_remote_get( $request_url, array(
        'timeout' => 10,
        'sslverify' => false
    ) );

    // If the HTTP code is 200 ... We continue
    if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
        $requirement = wp_remote_retrieve_body( $response );
        if ( ! empty( $requirement ) ) {
            $requirement = json_decode( $requirement );
            if ( json_last_error() === JSON_ERROR_NONE && isset( $requirement->data ) && ! empty( $requirement->data ) ) {

                // Adds Agency ID to URL
                if ( isset( $requirement->data->visamundi_url ) && ! empty( $requirement->data->visamundi_url ) ) {
                    if ( isset( $attributs['agency_id'] ) && ! empty( $attributs['agency_id'] ) ) {
                        $agency_id = $attributs['agency_id'];
                    } else {
                        $agency_id = vmtvw_get_option( 'agency_id' );
                    }

                    if ( isset( $attributs['affilae_id'] ) && ! empty( $attributs['affilae_id'] ) ) {
                        $affilae_id = $attributs['affilae_id'];
                    } else {
                        $affilae_id = vmtvw_get_option( 'affilae_id' );
                    }

                    if ( false !== $agency_id ) {
                        $requirement->data->visamundi_url = add_query_arg( array(
                            'agence' => $agency_id
                        ), $requirement->data->visamundi_url );
                    }
                    if ( false !== $affilae_id ) {
                        $requirement->data->visamundi_url = $requirement->data->visamundi_url . '#' . $affilae_id;
                    }
                }

                return $requirement->data;

            }
        }
    }

    return false;
}


/**
 * Adds the widget version to the WordPress user agent string.
 *
 * @since 0.5.1
 * @author Maël Conan
 *
 * @param string $user_agent    WordPress user agent string.
 * @param string $url           The request URL.
 *
 * @return string               Filtered WordPress user agent string with the widget version added.
 */
function vmtvw_http_headers_useragent( $user_agent, $url ) {
    if ( false !== strpos( $url, 'api.visamundi' ) && defined( 'VMTVW_VERSION' ) ) {
        $user_agent .= "; TVW/" . VMTVW_VERSION;
    }

    return $user_agent;
}
add_filter( 'http_headers_useragent', 'vmtvw_http_headers_useragent', 10, 2 );
