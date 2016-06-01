<?php
/**
 * init.php
 * Initalize the plugin and load any dependencies
 *
 * @package psp_sprout_invoices
 * @since 1.0
 */

function pspsi_load() {
	if ( ! class_exists( 'SI_Project' ) ) {
		add_action( 'admin_head', 'pspsi_compatibility_check_fail_notices' );
		return;
	}
	require_once PSPSI_DIR . '/controllers/PSP_SI.php';
	require_once PSPSI_DIR . '/controllers/Project_Panorama_Access.php';
	require_once PSPSI_DIR . '/controllers/Project_Panorama_Admin.php';
	require_once PSPSI_DIR . '/controllers/Project_Panorama_View.php';
	require_once PSPSI_DIR . '/controllers/Sprout_Invoices_Admin.php';

	do_action( 'pspsi_load_classes' );

	PSPSI_Project_Panorama_Access::init();
	PSPSI_Project_Panorama_Admin::init();
	PSPSI_Project_Panorama_View::init();
	PSPSI_Sprout_Invoices_Admin::init();

	do_action( 'pspsi_loaded' );

}

/**
 * Error messaging for compatibility check.
 * @return string error messages
 */
function pspsi_compatibility_check_fail_notices() {
	if ( ! class_exists( 'SI_Project' ) ) {
		printf( '<div class="error"><p>The free or paid version of <a href="%s"><strong>Sprout Invoices</strong></a> is required for "Panorama Sprout Invoices" to be useful.</p></div>', 'http://sproutapps.co/sprout-invoices/' );
	}
}

