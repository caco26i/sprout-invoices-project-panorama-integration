<?php

/**
* Handles all the integration points that PsP needs.
*
*/
class PSPSI_Project_Panorama_Access extends PSP_SI {

	public static function init() {
		add_filter( 'psp_project_access_meta_query', array( __CLASS__, 'alter_access_meta_query' ) );

		add_filter( 'panorama_check_access', array( __CLASS__, 'check_access_on_post' ), 10, 2 );

	}

	/**
	 * Checks to see if the user is accessing a post they have access to as part of an sa_client
	 * @param  boolean $result Current pass/fail of access
	 * @param  integer $psp_id The project id of the current viewed psp project
	 * @return boolean         Access or not.
	 */
	public static function check_access_on_post( $result = false, $psp_id = 0 ) {

		$current_user_id = get_current_user_id();
		$user_associated_clients = SI_Client::get_clients_by_user( $current_user_id );

		// If the result is true, then nothing will override it below
		// Plus if there are not associated clients than tough luck.
		if ( $result || empty( $user_associated_clients ) ) {
			return $result;
		}

		$si_project_id = get_field( self::META_KEY, $psp_id );

		// what si_project is assigned to this project access
		if ( ! $si_project_id || '' === $si_project_id ) {
			return false;
		}

		$si_project = SI_Project::get_instance( $si_project_id );
		$project_associated_clients = $si_project->get_associated_clients();

		$matches = array_intersect( $project_associated_clients, $user_associated_clients );

		// If there are no matches
		if ( empty( $matches ) ) {
			return false;
		}

		// there were matches
		return true;

	}


	/**
	 * Adds additional meta_query conditions to the Panorama project listing access
	 * @param  array  $args Existing meta_query args
	 * @return array       Modified array...
	 */
	public static function alter_access_meta_query( $args = array() ) {

		$user_id = get_current_user_id();
		$project_meta = self::client_dynamic_meta_query( self::get_client_si_projects( $user_id ) );
		$args = array_merge( $args, $project_meta );

		return $args;
	}

	/**
	 * Builds an array of meta_query conditions for projects with assigned sa_clients
	 *
	 * @param 	(array)	$project_ids	Array of sa_project post IDs
	 * @return 	(array)
	 **/
	public static function client_dynamic_meta_query( $project_ids = null ) {

		if ( null === $project_ids ) {
			$project_ids = self::get_client_si_projects();
		}

		$meta_query = array();
		if ( ! empty( $project_ids ) ) {
			foreach ( $project_ids as $project_id ) {

				if( !empty( $project_id ) ) {

					$meta_query[] = array(
						'key'		=> self::META_KEY,
						'value'		=> $project_id, // TODO this should just be an array?
					);

				}

			}
		}
		return $meta_query;
	}
}
