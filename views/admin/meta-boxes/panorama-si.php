<p class="pspsi-meta-project-id"><label for="pspsi_si_project_id"><?php esc_html_e( 'Sprout Invoices Project' ); ?></label> <?php si_projects_select( $si_project_id, 0, true, 'pspsi_si_project_id' ) ?></p>
<table class="widefat psp-admin-table">
	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Invoices', 'sprout-invoices' ) ?></th>
		</tr>
	</thead>
	<tbody>
		<?php if ( ! empty( $invoices ) ) : ?>
			<?php foreach ( $invoices as $invoice_id ) : ?>
				<tr>
					<td class="pspsi-date"><?php echo get_post_time( get_option( 'date_format' ), false, $invoice_id ) ?></td>
					<td><?php printf( '<a href="%s">%s</a>', get_edit_post_link( $invoice_id ), get_the_title( $invoice_id ) ) ?></td>
				</tr>
			<?php endforeach ?>
		<?php else : ?>
			<tr>
				<td colspan="2"><?php _e( 'No invoices', 'sprout-invoices' ) ?></td>
			</tr>
		<?php endif ?>
	</tbody>
</table>

<?php do_action( 'client_submit_pre_estimates' ) ?>

<table class="widefat psp-admin-table">
	<thead>
		<tr>
			<th colspan="2"><?php _e( 'Estimates', 'sprout-invoices' ) ?></th>
		</tr>
	</thead>
	<tbody>
	<?php if ( ! empty( $estimates ) ) : ?>
		<?php foreach ( $estimates as $estimate_id ) : ?>
			<tr>
				<td class="pspsi-date"><?php echo get_post_time( get_option( 'date_format' ), false, $estimate_id ) ?></td>
				<td><?php printf( '<a href="%s">%s</a>', get_edit_post_link( $estimate_id ), get_the_title( $estimate_id ) ) ?></td>
			</tr>
		<?php endforeach ?>
	<?php else : ?>
		<tr>
			<td colspan="2"><?php _e( 'No estimates', 'sprout-invoices' ) ?></td>
		</tr>
	<?php endif ?>
	</tbody>
</table>
<script type="text/javascript">
	jQuery(function() {
		jQuery('.select2').select2();
	});
</script>
