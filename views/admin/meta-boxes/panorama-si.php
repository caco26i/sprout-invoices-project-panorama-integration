<?php si_projects_select( $si_project_id, 0, true, 'pspsi_si_project_id' ) ?>

<p>
	<b><?php _e( 'Invoices', 'sprout-invoices' ) ?></b>
	<?php if ( ! empty( $invoices ) ) : ?>
		<dl>
			<?php foreach ( $invoices as $invoice_id ) : ?>
				<dt><?php echo get_post_time( get_option( 'date_format' ), false, $invoice_id ) ?></dt>
				<dd><?php printf( '<a href="%s">%s</a>', get_edit_post_link( $invoice_id ), get_the_title( $invoice_id ) ) ?></dd>
			<?php endforeach ?>
		</dl>
	<?php else : ?>
		<em><?php _e( 'No invoices', 'sprout-invoices' ) ?></em>
	<?php endif ?>
</p>
<hr/>
<?php do_action( 'client_submit_pre_estimates' ) ?>
<p>
	<b><?php _e( 'Estimates', 'sprout-invoices' ) ?></b>
	<?php if ( ! empty( $estimates ) ) : ?>
		<dl>
			<?php foreach ( $estimates as $estimate_id ) : ?>
				<dt><?php echo get_post_time( get_option( 'date_format' ), false, $estimate_id ) ?></dt>
				<dd><?php printf( '<a href="%s">%s</a>', get_edit_post_link( $estimate_id ), get_the_title( $estimate_id ) ) ?></dd>
			<?php endforeach ?>
		</dl>
	<?php else : ?>
		<em><?php _e( 'No estimates', 'sprout-invoices' ) ?></em>
	<?php endif ?>
</p>

