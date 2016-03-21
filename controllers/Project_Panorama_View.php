<?php

/**
* Handles all the integration points that PsP needs.
*
*/
class PSPSI_Project_Panorama_View extends PSP_SI {

	public static function init() {
		add_action( 'psp_before_quick_overview', array( __CLASS__, 'widget_dashboard_invoices' ) );
		add_action( 'psp_head', array( __CLASS__, 'pspsi_frontend_assets' ) );
	}

	public static function pspsi_frontend_assets() {

		if( function_exists( 'psp_register_style' ) ) {
			psp_register_style( 'pspsi-front', PSPSI_URL . '/assets/css/front.css', NULL, PSPSI_VER );
		} else {
			echo '<link rel="stylesheet" type="text/css" id="pspsi-front-css" href="' . PSPSI_URL . '/assets/css/front.css?v=' . PSPSI_VER . '">';
		}

	}

	public static function widget_dashboard_invoices() {
		$si_project_id = self::get_si_project_id_from_psp_project_id();
		if ( is_a( $si_project_id, 'WP_Post' ) ) {
			$si_project_id = $si_project_id->ID;
		}

		$si_project = SI_Project::get_instance( $si_project_id );

		if ( ! is_a( $si_project, 'SI_Project' ) ) {
			return;
		}

		$invoices 	= $si_project->get_invoices();
		$estimates 	= $si_project->get_estimates();
		$payments 	= $si_project->get_payments();

		if ( $invoices ) {
			self::load_addon_view( 'panorama/invoices-widget', array(
				'invoices' 	=> $invoices,
				'estimates' => $estimates,
				'payments' 	=> $payments,
			), true );
		}

		/**
		 * By default we are only going to show estimates
		 * that do not have invoices associated. That estimate can
		 * be linked from the invoices table instead.
		 */
		$estimates_to_show = array();
		foreach ( $estimates as $estimate_id ) {
			$ass_invoice_id = si_get_estimate_invoice_id( $estimate_id );
			if ( ! $ass_invoice_id || get_post_type( $ass_invoice_id ) != SI_Invoice::POST_TYPE ) {
				$estimates_to_show[] = $estimate_id;
			}
		}

		if ( $estimates ) {
			self::load_addon_view( 'panorama/estimates-widget', array(
				'invoices' => $invoices,
				'estimates' => $estimates_to_show,
				'payments' => $payments,
			), true );
		}

	}
}
