<?php

/**
* Handles all the integration points that PsP needs.
*
*/
abstract class PSP_SI {
	const META_KEY = 'pspsi_projects';

	/**
	 * Query sa_client posts with assigned user ID
	 *
	 * @param 	(int) $user_id 	wp_user ID
	 * @return 	(array) 		sa_client post ID's
	 **/
	public static function get_client_si_projects( $user_id = 0 ) {
		$project_ids = array();

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		if ( ! $user_id ) {
			return $project_ids;
		}

		$client_ids = SI_Client::get_clients_by_user( $user_id );

		if ( empty( $client_ids ) ) {
			return $project_ids;
		}

		foreach ( $client_ids as $client_id ) {
			$project_ids[] = SI_Project::get_projects_by_client( $client_id );
		}

		return $project_ids;
	}

	public static function get_si_project_id_from_psp_project_id( $psp_project_id = 0 ) {
		if ( ! $psp_project_id ) {
			$psp_project_id = get_the_id();
		}

		return get_field( self::META_KEY, $psp_project_id );

	}

	public static function get_current_psp_project_id() {
		return get_field( self::META_KEY, get_the_id() );
	}

	public static function load_addon_view( $view, $args, $allow_theme_override = true ) {
		add_filter( 'si_views_path', array( __CLASS__, 'addons_view_path' ) );
		$view = SI_Controller::load_view( $view, $args, $allow_theme_override );
		remove_filter( 'si_views_path', array( __CLASS__, 'addons_view_path' ) );
		return $view;
	}

	public static function load_addon_view_to_string( $view, $args, $allow_theme_override = true ) {
		ob_start();
		SI_Controller::load_addon_view( $view, $args, $allow_theme_override );
		return ob_get_clean();
	}

	public static function addons_view_path() {
		return PSPSI_PATH . '/views/';
	}
}
