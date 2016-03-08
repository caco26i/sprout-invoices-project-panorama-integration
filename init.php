<?php
/**
 * init.php
 * Initalize the plugin and load any dependencies
 *
 * @package psp_sprout_invoices
 * @since 1.0
 */

add_action( 'plugins_loaded', 'pspsi_init', 999 );
function pspsi_init() {

	$reqs = array(
		'models/panorama/pspsi-fields',			// Project Panorama fields
		'views/panorama/pspsi-dashboard-widget',	// Start of the dashboard widget
		'controllers/panorama/pspsi-projects'	// Project Panorama controllers
	);

	foreach( $reqs as $req ) {

		require_once( $req . '.php' );

	}

}
