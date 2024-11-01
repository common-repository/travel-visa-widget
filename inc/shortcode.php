<?php
defined( 'ABSPATH' ) || exit;


/**
 * Adds shortcode to display the widget anywhere.
 *
 * @since 0.1.0
 * @since 0.5.0 Added attributes to shortcode.
 *
 * @author Maël Conan
 *
 * @return string           HTML render of the widget.
 */
function vmtvw_add_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'agency_id' => '',
        'affilae_id' => ''
    ), $atts );

    // Attributes cleanup
    $agency_id = vmtvw_sanitize_agency_id( $atts['agency_id'] );
    $affilae_id = vmtvw_sanitize_affilae_id( $atts['affilae_id'] );

    // Enqueue script & style only if shortcode is used
    wp_enqueue_style( 'vmtvw-style' );
    wp_enqueue_script( 'vmtvw-script' );

    // Data for the main view
    $data = array(
        'widget_id' => uniqid(),        // Generates a unique id if widget is loaded multiple times
        'agency_id' => $agency_id,
        'affilae_id' => $affilae_id
    );

    // Rendering the widget
    return vmtvw_get_view( 'public/widget-base', $data );
}
add_shortcode( 'travel_visa_widget', 'vmtvw_add_shortcode' );
