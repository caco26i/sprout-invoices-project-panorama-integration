<?php

/**
* Handles all the integration points that PsP needs.
*
*/
class PSPSI_Project_Panorama_Admin extends PSP_SI {

	public static function init() {
		// Meta boxe
		add_action( 'admin_init', array( __CLASS__, 'register_meta_boxes' ) );
		// stylesheets
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_styles' ) );

	}

	/**
	 * Enqueue admin stylesheet
	 *
	 * @return
	 */

	public static function enqueue_admin_styles( $hook ) {

		$screen = get_current_screen();

		wp_register_style( 'pspsi-admin', PSPSI_URL . '/assets/css/admin.css', false, PSPSI_VER );

		if ( $screen->post_type == 'psp_projects' ) {

			wp_enqueue_style( 'pspsi-admin' );

		}

	}

	/////////////////
	// Meta boxes //
	/////////////////

	/**
	 * Regsiter meta boxes for estimate editing.
	 *
	 * @return
	 */
	public static function register_meta_boxes() {
		// estimate specific
		$args = array(
			'pspsi' => array(
				'title' => __( 'Sprout Invoices Integration', 'sprout-invoices' ),
				'show_callback' => array( __CLASS__, 'show_pspsi_meta_box' ),
				'save_callback' => array( __CLASS__, 'save_meta_box_pspsi' ),
				'context' => 'normal',
				'priority' => 'low',
				'weight' => 0,
				'save_priority' => 0,
			),
		);
		do_action( 'sprout_meta_box', $args, 'psp_projects' );
	}

	public static function show_pspsi_meta_box( $post, $metabox ) {

		$si_project_id = get_post_meta( $post->ID, self::META_KEY, true );
		$invoices = array();
		$estimates = array();
		$payments = array();

		if ( $si_project_id ) {
			$si_project = SI_Project::get_instance( $si_project_id );
			$invoices = $si_project->get_invoices();
			$estimates = $si_project->get_estimates();
			$payments = $si_project->get_payments();
		}

		wp_enqueue_script( 'select2_4.0' );
		wp_enqueue_style( 'select2_4.0_css' );

		self::load_addon_view( 'admin/meta-boxes/panorama-si', array(
				'si_project_id' => $si_project_id,
				'invoices' => $invoices,
				'estimates' => $estimates,
				'payments' => $payments,
		), false );
	}

	public static function save_meta_box_pspsi( $post_id, $post, $callback_args, $invoice_id = null ) {
		$si_project_id = ( isset( $_POST['pspsi_si_project_id'] ) ) ? $_POST['pspsi_si_project_id'] : '' ;
		update_post_meta( $post_id, self::META_KEY, $si_project_id );
	}
}
