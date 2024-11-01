<?php
defined( 'ABSPATH' ) || exit;


// Loads the classic widget class
require_once VMTVW_WIDGET_PATH . 'class-vmtvw-widget.php';

/**
 * Registers the classic widget.
 *
 * @since 0.1.0
 * @author Maël Conan
 */
function vmtvw_register_classic_widget() {
	register_widget( 'VMTVW_Widget' );
}
add_action( 'widgets_init', 'vmtvw_register_classic_widget' );


/**
 * Displays the widget title.
 *
 * @since 0.1.0
 * @author Maël Conan
 */
function vmtvw_display_widget_title() {
    // Generates the default title
    $title = sprintf(
        _x( "Find your %1\$s with %2\$s", "Find your Visa with Visamundi", 'travel-visa-widget' ),
        sprintf( '<strong>%s</strong>', __( "Visa", 'travel-visa-widget' ) ),
        '<span class="visamundi-logo"><span class="screen-reader-text">Visamundi</span></span>'
    );

    /**
     * Filters the widget title.
     *
     * @since 0.1.0
     *
     * @param string $title     The title to override.
     */
    $title = apply_filters( 'vmtvw/widget_title', $title );

    echo wp_kses( $title, array(
        'strong' => array(),
        'span' => array(
            'class' => array()
        )
    ) );
}
add_action( 'vmtvw/display_widget_title', 'vmtvw_display_widget_title' );


/**
 * Displays the list of countries for <select> tags.
 *
 * @since 0.1.0
 * @author Maël Conan
 */
function vmtvw_display_countries_list() {
    $countries = vmtvw_get_countries();

    if ( $countries ) {
        /**
         * Filters the countries list.
         *
         * @since 0.1.0
         *
         * @param object $countries     List of countries to filter.
         */
        $countries = apply_filters( 'vmtvw/countries_list', $countries );

        foreach ( $countries as $country ) {
            ?>
            <option value="<?php echo esc_attr( $country->alpha3_code ); ?>"><?php echo esc_html( $country->name ); ?></option>
            <?php
        }
    }
}
add_action( 'vmtvw/display_countries_list', 'vmtvw_display_countries_list' );


/**
 * Displays the result of the visa requirement request.
 *
 * @since 0.1.0
 * @since 0.5.4 Added new conditions for displaying the button.
 *
 * @author Maël Conan
 *
 * @param object $data      Data result from the Visamundi API.
 *
 * @return string           HTML result to render in the dedicated area.
 */
function vmtvw_format_result( $data ) {
    $html = $answer = $requirement = '';
    $add_notification_infos = false;

    $requirements = array(
        'visa required' => _x( "a visa is required", "To travel to (destination_name) with a (nationality_demonym), ...", 'travel-visa-widget' ),
        'visa on arrival' => _x( "a visa is granted on arrival", "To travel to (destination_name) with a (nationality_demonym), ...", 'travel-visa-widget' ),
        'e-visa' => _x( "you will need a travel document", "To travel to (destination_name) with a (nationality_demonym), ...", 'travel-visa-widget' ),
        'Hayya Entry Permit' => _x( "you will need a Hayya Entry Permit", "To travel to (destination_name) with a (nationality_demonym), ...", 'travel-visa-widget' ),
        'visa free' => _x( "no visa is required", "To travel to (destination_name) with a (nationality_demonym), ...", 'travel-visa-widget' ),
        'no admission' => _x( "it's compromised because no admission is possible", "To travel to (destination_name) with a (nationality_demonym), ...", 'travel-visa-widget' )
    );

    if( array_key_exists( $data->requirement, $requirements ) ) {
        $requirement = $requirements[$data->requirement];
    } elseif( (int)$data->requirement > 0 ) {
        $requirement = sprintf( __( "no visa is required for a stay of up to %d days", 'travel-visa-widget' ), (int)$data->requirement );
    } elseif( (int)$data->requirement === -1 ) {
        $answer = __( "Please choose a destination different from your passport.", 'travel-visa-widget' );
    } else {
        $requirement = _x( "we don't have information on what is needed", "To travel to (destination_name) with a (nationality_demonym), ...", 'travel-visa-widget' );
        $add_notification_infos = true;
    }

    if ( empty( $answer ) ) {
        $answer .= sprintf(
            _x( "To travel %1\$s %2\$s with a %3\$s passport, %4\$s.", "To travel (destination_prefix) (destination_name) with a (nationality_demonym) passport, (you will/won't need ...)", 'travel-visa-widget' ),
            $data->i18n->destination->country->prefix,
            $data->i18n->destination->country->name,
            strtolower( $data->i18n->nationality->demonym ),
            '<strong>' . $requirement . '</strong>'
        );
    }

    $html .= '<p>';
    $html .= $answer;
    $html .= '</p>';

    if (
        ! empty( $data->visamundi_url ) &&
        isset( $data->requirement ) &&
        ! in_array( $data->requirement, array( 'visa free', 'no admission' ) ) &&
        ! $add_notification_infos
    ) {
        $answer_button_text = __( "Get my Visa", 'travel-visa-widget' );

        if ( (int)$data->requirement > 0 ) {
            $answer_button_text = __( "Get my other mandatory document", 'travel-visa-widget' );
        } elseif ( 'e-visa' === $data->requirement ) {
            $answer_button_text = __( "Get my Document", 'travel-visa-widget' );
        }

        $html .= '<p>';
        $html .= '<a href="' . esc_url( $data->visamundi_url ) . '" target="_blank"><span>' . $answer_button_text . '</span></a>';
        $html .= '</p>';
    }

    if ( $add_notification_infos ) {
        $html .= '<p class="vmtvw-notification-msg">';
        $html .= __( "Our teams have been notified and will update the data accordingly.", 'travel-visa-widget' );
        $html .= '</p>';
    }

    return $html;
}
