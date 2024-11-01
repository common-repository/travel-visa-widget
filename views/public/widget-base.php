<?php
defined( 'ABSPATH' ) || exit;


$wrapper_data_attributs = '';
if ( isset( $data['agency_id'] ) && ! empty( $data['agency_id'] ) ) {
    $wrapper_data_attributs .= ' data-agency-id="' . esc_attr( $data['agency_id'] ) . '"';
}
if ( isset( $data['affilae_id'] ) && ! empty( $data['affilae_id'] ) ) {
    $wrapper_data_attributs .= ' data-affilae-id="' . esc_attr( $data['affilae_id'] ) . '"';
}
?>
<div class="vmtvw-wrapper"<?php echo $wrapper_data_attributs; ?>>
    <div class="vmtvw-inner">

        <div class="vmtvw-title">
            <p><?php do_action( 'vmtvw/display_widget_title' ); ?></p>
        </div>

        <div class="vmtvw-form">
            <div class="vmtvw-field">
                <label for="vmtvw-nationality-<?php echo esc_attr( $data['widget_id'] ); ?>" class="vmtvw-label vmtvw-nationality-label" title="<?php esc_attr_e( "What is your nationality ?", 'travel-visa-widget' ); ?>">
                    <span class="screen-reader-text"><?php _e( "What is your nationality ?", 'travel-visa-widget' ); ?></span>
                </label>
                <select name="vmtvw-nationality" id="vmtvw-nationality-<?php echo esc_attr( $data['widget_id'] ); ?>" class="vmtvw-select vmtvw-nationality">
                    <option value="" disabled selected><?php _e( "Nationality", 'travel-visa-widget' ); ?></option>
                    <?php do_action( 'vmtvw/display_countries_list' ); ?>
                </select>
            </div>
            <div class="vmtvw-field">
                <label for="vmtvw-destination-<?php echo esc_attr( $data['widget_id'] ); ?>" class="vmtvw-label vmtvw-destination-label" title="<?php esc_attr_e( "What is your destination ?", 'travel-visa-widget' ); ?>">
                    <span class="screen-reader-text"><?php _e( "What is your destination ?", 'travel-visa-widget' ); ?></span>
                </label>
                <select name="vmtvw-nationality" id="vmtvw-destination-<?php echo esc_attr( $data['widget_id'] ); ?>" class="vmtvw-select vmtvw-destination">
                    <option value="" disabled selected><?php _e( "Destination", 'travel-visa-widget' ); ?></option>
                    <?php do_action( 'vmtvw/display_countries_list' ); ?>
                </select>
            </div>
        </div>
        <div class="vmtvw-result" aria-live="polite"></div>
    </div>
</div>
