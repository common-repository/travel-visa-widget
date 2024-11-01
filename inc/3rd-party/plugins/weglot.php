<?php
defined( 'ABSPATH' ) || exit;


if ( defined( 'WEGLOT_VERSION' ) ) :

    /**
     * Nodes to ignore in Weglot translation.
     *
     * @since 0.1.0
     * @author Maël Conan
     *
     * @param array $nodes      Current array of nodes to ignore.
     *
     * @return array            Array of nodes to ignore with our addition.
     */
    function vmtvw_weglot_get_parser_ignored_nodes( $nodes ) {
        $nodes[] = '.vmtvw-wrapper';
        return $nodes;
    }
    add_filter( 'weglot_get_parser_ignored_nodes', 'vmtvw_weglot_get_parser_ignored_nodes', 999 );


    /**
     * Ajax actions to ignore in Weglot translation.
     *
     * @since 0.1.0
     * @author Maël Conan
     *
     * @param array $ajax_actions       Current array of ajax actions to ignore.
     *
     * @return array                    Array of ajax actions to ignore with our addition.
     */
    function vmtvw_weglot_ajax_no_translate( $ajax_actions ) {
        $ajax_actions[] = 'vmtvw_get_ajax_requirement_result';
        return $ajax_actions;
    }
    add_filter( 'weglot_ajax_no_translate', 'vmtvw_weglot_ajax_no_translate', 20 );

endif;
