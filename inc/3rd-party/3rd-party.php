<?php
defined( 'ABSPATH' ) || exit;


// 3rd party paths
define( 'VMTVW_3RD_PARTY_HOSTING_PATH',   VMTVW_3RD_PARTY_PATH . 'hosting' . DIRECTORY_SEPARATOR );
define( 'VMTVW_3RD_PARTY_PLUGINS_PATH',   VMTVW_3RD_PARTY_PATH . 'plugins' . DIRECTORY_SEPARATOR );
define( 'VMTVW_3RD_PARTY_THEMES_PATH',    VMTVW_3RD_PARTY_PATH . 'themes' . DIRECTORY_SEPARATOR );


/**
 * Plugins
 */
require_once VMTVW_3RD_PARTY_PLUGINS_PATH . 'weglot.php';
require_once VMTVW_3RD_PARTY_PLUGINS_PATH . 'wp-rocket.php';
