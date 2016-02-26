<?php
/**
 * pspsi-fields.php
 * Adds required Project Panorama fields for integration
 *
 * @package psp_sprout_invoices
 * @since 1.0
 */

/**
 * pspsi_add_client_field
 * Adds a new custom field to the Project Panorama page via a filter
 *
 * @param 	(array) $fields 	Multi dimensional array with existing field data
 * @return 	(array) 			9xzModified array with new field added
 **/

add_filter( 'psp_overview_fields', 'pspsi_add_client_field' );
function pspsi_add_client_field( $fields ) {

	$client_relationship_field	= array(
		'key' 				=> 'field_56c8d3f39b1f8',
		'label' 			=> __( 'Project', 'pspsi' ),
		'name' 				=> 'pspsi_projects',
		'type' 				=> 'relationship',
		'return_format' 	=> 'id',
		'post_type' 		=> array(
			0 => SI_Project::POST_TYPE,
		),
		'taxonomy' 			=> array(
			0 => 'all',
		),
		'filters' 			=> array(
			0 => 'search',
		),
		'result_elements' 	=> array(
			0 => 'post_title',
		),
		'max' => '',
	);

	$new_fields = array();

	foreach ( $fields['fields'] as $field ) {

		$new_fields[] = $field;

		if ( $field['key'] == 'field_532b8d759c46a' ) {

			$new_fields[] = $client_relationship_field;

		}
	}

	$fields['fields'] = $new_fields;

	return $fields;

}
