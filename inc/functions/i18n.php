<?php
defined( 'ABSPATH' ) || exit;


/**
 * Returns the current language based on available translation plugins.
 *
 * @since 0.1.0
 * @author Maël Conan
 *
 * @return string           The slug (2-letters code) of the current language.
 */
function vmtvw_get_current_language() {
    $language = false;

    if ( function_exists( 'pll_current_language' ) ) { // Polylang
        $language = pll_current_language( 'slug' );
    }
    elseif ( function_exists( 'weglot_get_current_language' ) ) { // Weglot
        $language = weglot_get_current_language();
    }
    else {
        $language = substr( get_locale(), 0, 2 );
    }

    // Fallback
    if ( ! $language ) {
        $language = 'en';
    }

    return $language;
}
