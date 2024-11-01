<?php
defined( 'ABSPATH' ) || exit;


/**
 * Creates VMTVW_Widget widget.
 *
 * @since 0.1.0
 * @author Maël Conan
 */
class VMTVW_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'vmtvw_widget',
            _x( "Travel Visa Widget", "Name of the plugin", 'travel-visa-widget' ),
            array(
                'description' => __( "A widget to know which countries need a travel visa.", 'travel-visa-widget' )
            )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args           Widget arguments.
     * @param array $instance       Saved values from database.
     */
    function widget( $args, $instance ) {
        // Enqueue script & style only if widget is used.
        wp_enqueue_style( 'vmtvw-style' );
        wp_enqueue_script( 'vmtvw-script' );

        // Data for the main view
        $data = array(
            'widget_id' => uniqid()     // Generates a unique id if widget is loaded multiple times
        );

        // Rendering the widget
        vmtvw_print_view( 'public/widget-base', $data );
    }

}
