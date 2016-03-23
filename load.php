<?php
/**
 * init.php
 * Initalize the plugin and load any dependencies
 *
 * @package psp_sprout_invoices
 * @since 1.0
 */

function pspsi_load() {

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

