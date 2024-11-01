<?php
defined( 'ABSPATH' ) || exit;


/**
 * Prevent CSS file from being removed when option "Remove Unused CSS" is enabled
 *
 * @since 0.4.1
 * @author Maël Conan
 *
 * @param array $external_exclusions        The list of CSS files
 *
 * @return array                            The list of CSS files to ignore with that of the widget
 */
function vmtvw_rocket_rucss_external_exclusions( $external_exclusions = array() ) {
    $external_exclusions[] = '/wp-content/plugins/travel-visa-widget/assets/css/style.css';
    return $external_exclusions;
}
add_filter( 'rocket_rucss_external_exclusions', 'vmtvw_rocket_rucss_external_exclusions' );
