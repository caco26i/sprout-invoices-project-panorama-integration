<?php

/**
* Handles all the integration points that PsP needs.
*
*/
class PSPSI_Sprout_Invoices_Admin extends PSP_SI {

	public static function init() {

		// register metaboxes for client and project

		if ( is_admin() ) {
			// Admin columns
			add_filter( 'manage_edit-'.SI_Project::POST_TYPE.'_columns', array( __CLASS__, 'register_columns' ) );
			add_filter( 'manage_'.SI_Project::POST_TYPE.'_posts_custom_column', array( __CLASS__, 'column_display' ), 10, 2 );

			add_action( 'admin_init', array( __CLASS__, 'register_meta_boxes' ), 50 );
		}

	}

	////////////////////
	// Admin Columns //
	////////////////////

	/**
	 * Overload the columns for the invoice post type admin
	 *
	 * @param array   $columns
	 * @return array
	 */
	public static function register_columns( $columns ) {
		$columns['psp'] = __( 'Project Panorama', 'sprout-invoices' );
		return $columns;
	}

	/**
	 * Display the content for the column
	 *
	 * @param string  $column_name
	 * @param int     $id          post_id
	 * @return string
	 */
	public static function column_display( $column_name, $id ) {
		$project = SI_Project::get_instance( $id );

		if ( ! is_a( $project, 'SI_Project' ) ) {
			return; // return for that temp post
		}
		switch ( $column_name ) {

			case 'psp':
				$psp_project_id = self::get_psp_project_id_from_si_project_id( $id );
				printf( '<a href="%s">%s</a>', get_edit_post_link( $psp_project_id ), get_the_title( $psp_project_id ) );

				$completed = psp_compute_progress( $psp_project_id );

				if ( $completed > 10 ) {

		            echo '<p class="psp-progress"><span class="psp-' . $completed . '"><strong>%' . $completed . '</strong></span></p>';

				} else {

				    echo '<p class="psp-progress"><span class="psp-' . $completed . '"></span></p>';

				}

			break;

			default:
				// code...
			break;
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
			'psp_project_info' => array(
				'title' => 'Project Panorama',
				'show_callback' => array( __CLASS__, 'show_meta_box' ),
				'save_callback' => array( __CLASS__, 'save_meta_box' ),
				'context' => 'side',
				'priority' => 'low',
			),
		);
		do_action( 'sprout_meta_box', $args, SI_Project::POST_TYPE );
	}

	/**
	 * Show custom submit box.
	 * @param  WP_Post $post
	 * @param  array $metabox
	 * @return
	 */
	public static function show_meta_box( $post, $metabox ) {
		$psp_project_id = self::get_psp_project_id_from_si_project_id( $post->ID );

		$psp_project_ids = array();
		if ( ! $psp_project_id ) {
			$args = array(
				'post_type' => 'psp_projects',
				'post_status' => 'any',
				'posts_per_page' => -1,
				'fields' => 'ids',
			);
			$psp_project_ids = get_posts( $args );
		}

		self::load_addon_view( 'admin/meta-boxes/si-projects-info', array(
				'id' => $post->ID,
				'psp_project_id' => $psp_project_id,
				'psp_all_project_ids' => $psp_project_ids,
		), false );
	}

	/**
	 * Saving submit meta
	 * @param  int $post_id
	 * @param  object $post
	 * @param  array $callback_args
	 * @param  int $project_id
	 * @return
	 */
	public static function save_meta_box( $post_id, $post, $callback_args, $project_id = null ) {
		$psp_project_id = ( isset( $_POST['psp_project_id_selection'] ) && $_POST['psp_project_id_selection'] !== '' ) ? $_POST['psp_project_id_selection'] : '' ;
		update_post_meta( $psp_project_id, self::META_KEY, $post_id );
	}
}
