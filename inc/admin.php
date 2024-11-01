<?php
defined( 'ABSPATH' ) || exit;


/**
 * Registers a submenu item in WordPress settings.
 *
 * @since 0.2.0
 * @author Maël Conan
 */
function vmtvw_admin_settings_submenu() {
    add_submenu_page(
        'options-general.php',
        _x( "Travel Visa Widget", "Name of the plugin", 'travel-visa-widget' ),
        _x( "Travel Visa Widget", "Name of the plugin", 'travel-visa-widget' ),
        'manage_options',
        'vmtvw_settings',
        'vmtvw_admin_settings_page_markup'
    );
}
add_action( 'admin_menu', 'vmtvw_admin_settings_submenu' );



/**
 * Registers settings, sections and fields of the form.
 *
 * @since 0.2.0
 * @author Maël Conan
 */
function vmtvw_admin_settings_init() {
    register_setting(
        'vmtvw_settings',
        'vmtvw_options',
        array(
            'sanitize_callback' => 'vmtvw_admin_settings_sanitize_callback',
        )
    );

    // Register the general section
    add_settings_section(
        'vmtvw_section_general',
        __( "General settings", 'travel-visa-widget' ),
        'vmtvw_section_general_callback',
        'vmtvw_settings'
    );

    // Register fields of the general section
    add_settings_field(
        'vmtvw_field_agency_id',
        __( "Agency ID", 'travel-visa-widget' ),
        'vmtvw_field_agency_id_callback',
        'vmtvw_settings',
        'vmtvw_section_general'
    );
    add_settings_field(
        'vmtvw_field_affilae_id',
        __( "Affilae ID", 'travel-visa-widget' ),
        'vmtvw_field_affilae_id_callback',
        'vmtvw_settings',
        'vmtvw_section_general'
    );
}
add_action( 'admin_init', 'vmtvw_admin_settings_init' );


/**
 * Sanitize user inputs.
 *
 * @since 0.2.0
 * @since 0.5.0 Added agency/Affilae IDs sanitization functions.
 *
 * @author Maël Conan
 *
 * @param array $settings       Fields values entered by the user.
 *
 * @return array                Sanitized values of fields.
 */
function vmtvw_admin_settings_sanitize_callback( $settings ) {
    // Agency ID
    $settings['agency_id'] = vmtvw_sanitize_agency_id( $settings['agency_id'] );

    // Affilae ID
    $settings['affilae_id'] = vmtvw_sanitize_affilae_id( $settings['affilae_id'] );

    return $settings;
}


/**
 * Markup callback for the settings page.
 *
 * @since 0.2.0
 * @author Maël Conan
 */
function vmtvw_admin_settings_page_markup() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    settings_errors( 'vmtvw_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="POST">
            <?php
            settings_fields( 'vmtvw_settings' );
            do_settings_sections( 'vmtvw_settings' );
            submit_button( __( "Save Changes" ) );
            ?>
        </form>
    </div>
    <?php
}


/** ----------------------------------------------------------------------------------------- */
/** GENERAL SETTINGS ======================================================================== */
/** ----------------------------------------------------------------------------------------- */


/**
 * General section callback function.
 *
 * @since 0.2.0
 * @author Maël Conan
 *
 * @param array $args       The settings array, defining title, id, callback.
 */
function vmtvw_section_general_callback( $args ) {}


/**
 * Agency ID field callback function.
 *
 * @since 0.2.0
 * @author Maël Conan
 *
 * @param array $args       Arguments passed by field definition.
 */
function vmtvw_field_agency_id_callback( $args ) {
    // Get the value of the setting registered with register_setting()
    $agency_id = vmtvw_get_option( 'agency_id', '' );
    ?>
    <input type="text" name="vmtvw_options[agency_id]" value="<?php echo esc_attr( $agency_id ); ?>" autocomplete="off" />
    <p class="description">
        <?php esc_html_e( "Provide an agency ID to merge all applications from travellers in your Visamundi dashboard.", 'travel-visa-widget' ); ?><br />
        <?php echo sprintf( esc_html__( "You can contact us at %s to get this ID.", 'travel-visa-widget' ), '<a href="mailto:b2b@visamundi.co">b2b@visamundi.co</a>' ); ?>
    </p>
    <?php
}


/**
 * Affilae ID field callback function.
 *
 * @since 0.4.0
 * @author Maël Conan
 *
 * @param array $args       Arguments passed by field definition.
 */
function vmtvw_field_affilae_id_callback( $args ) {
    // Get the value of the setting registered with register_setting()
    $affilae_id = vmtvw_get_option( 'affilae_id', '' );
    ?>
    <input type="text" name="vmtvw_options[affilae_id]" value="<?php echo esc_attr( $affilae_id ); ?>" autocomplete="off" placeholder="aeXX" />
    <p class="description">
        <?php esc_html_e( "If you have a partner identifier, you can fill it in to facilitate the refund.", 'travel-visa-widget' ); ?><br />
        <?php echo sprintf( esc_html__( "More information on %s.", 'travel-visa-widget' ), sprintf( '<a href="https://affilae.com/" target="_blank">%s</a>', __( "the Affilae website", 'travel-visa-widget' ) ) ); ?>
    </p>
    <?php
}
