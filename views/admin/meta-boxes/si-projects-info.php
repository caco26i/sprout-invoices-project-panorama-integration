<?php if ( $psp_project_id ) :  ?>
	<p>
		<a href="<?php echo get_edit_post_link( $psp_project_id ); ?>"><b><?php echo get_the_title( $psp_project_id ); ?></b></a> <small><?php the_field( 'client', $psp_project_id ); ?></small>
	</p>

	<?php $completed = psp_compute_progress( $psp_project_id ); ?>
	<?php if ( $completed > 10 ) :  ?>
		<p class="psp-progress"><span class="psp-<?php echo $completed ?>"><strong>%<?php echo $completed ?></strong></span></p>
	<?php else : ?>
		<p class="psp-progress"><span class="psp-<?php echo $completed ?>"></span></p>
	<?php endif ?>

	<?php if ( $project_logo = get_field( 'client_project_logo', $psp_project_id ) ) :  ?>
		<p><?php printf( '<img src="%s" class="psp-client-project-logo" style="%s"', $project_logo['sizes']['medium'], 'width:100%;height:auto' ) ?></p>
	<?php endif ?>
<?php else : ?>
	<select name="psp_project_id_selection" class="select2">
		<option></option>
		<?php foreach ( $psp_all_project_ids as $project_id ) :  ?>
			<option value="<?php echo $project_id ?>"><?php echo get_the_title( $project_id ) ?></option>
		<?php endforeach ?>
	</select>
	<p class="description"><?php _e( 'Select a Project Panamora that you want to link with this Sprout Invoices Project.', 'sprout-invoices' ) ?></p>
<?php endif ?>
