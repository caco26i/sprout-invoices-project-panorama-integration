<?php
/**
 * pspsi-projects.php
 * Functionallity on the Project Panorama side
 *
 * @package psp_sprout_invoices
 * @since 1.0
 */

/**
 * pspsi_alter_access_meta_query()
 * Adds additional meta_query conditions to the Panorama project listing access
 *
 * @param 	(array) $args 	Existing meta_query arguments
 * @return 	(array) 		Modified array with additional meta_query arguements
 **/
add_filter( 'psp_project_access_meta_query', 'pspsi_alter_access_meta_query', 10, 1 );
function pspsi_alter_access_meta_query( $args ) {

	$cuser				= wp_get_current_user();
	$client_meta		= pspsi_client_dynamic_meta_query( pspsi_get_my_client_accounts( $cuser->ID ) );
	$args 				= array_merge( $args, $client_meta );

}

/**
 * pspsi_get_my_client_accounts()
 * Query sa_client posts with assigned user ID
 *
 * @param 	(int) $user_id 	wp_user ID
 * @return 	(array) 		sa_client post ID's
 **/
function pspsi_get_my_client_accounts( $user_id = null ) {

	global $wpdb;

	if ( $user_id == null ) {

		$user		= wp_get_current_user();
		$user_id	= $user->ID;

	}

	$client_ids = SI_Client::get_clients_by_user( $user_id );
	if ( empty( $client_ids ) ) {
		return false;
	}
	return $client_ids;

}

/**
 * pspsi_client_dynamic_meta_query()
 * Builds an array of meta_query conditions for projects with assigned sa_clients
 *
 * @param 	(array)	$client_ids	Array of sa_client post IDs
 * @return 	(array)
 **/
function pspsi_client_dynamic_meta_query( $client_ids = null ) {

	if ( $client_ids == null ) {

		$client_ids = pspsi_get_my_client_accounts();

	}

	$meta_query = array();

	if ( ! empty( $client_ids ) ) {

		foreach ( $client_ids as $client_id ) {

			$meta_query[] = array(
				'key'		=> 'pspsi_clients',
				'value'		=> $client_id,
				'compare'	=> 'LIKE',
			);

		}
	}

	return $meta_query;

}

/**
 * pspsi_check_access_on_post()
 * Checks to see if the user is accessing a post they have access to as part of an sa_client
 *
 * @param	(boolean) $result	TRUE or FALSE based on current conditions
 * @param 	(int) $post_id		The current posts ID
 * @return 	(boolean)
 **/
add_filter( 'panorama_check_access', 'pspsi_check_access_on_post', 10, 2 );
function pspsi_check_access_on_post( $result, $post_id ) {

	$cuser		= wp_get_current_user();
	$accounts 	= pspsi_get_my_client_accounts( $cuser->ID );

	// If the result is false, the user is assigned to clients and the project has clients

	if ( ( $result == false ) && ( ! empty( $accounts ) ) && ( get_field( 'pspsi_clients', $post_id ) ) ) {

		$clients = get_field( 'pspsi_clients' );

		foreach ( $accounts as $account ) {

			if ( in_array( $account, $clients ) ) {

				$result = true;

			}
		}
	}

	return $result;

}
