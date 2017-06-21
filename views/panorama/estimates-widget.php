<?php if ( ! empty( $estimates ) ) :  ?>
	<div class="psp-overview-box cf pspsi-invoices-widget">

		<h4><?php _e( 'Estimates', 'sprout-invoices' ) ?></h4>

		<table id="si_client_dashboard_estimates" class="table table-hover pspsi-table">
			<thead>
				<tr>
					<!--<th><?php _e( 'Number', 'sprout-invoices' ) ?></th>-->
					<th><?php _e( 'Estimate', 'sprout-invoices' ) ?></th>
					<th><?php _e( 'Issued', 'sprout-invoices' ) ?></th>
					<th><?php _e( 'Status', 'sprout-invoices' ) ?></th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( ! empty( $estimates ) ) :  ?>
					<?php foreach ( $estimates as $estimate_id ) :

						$estimate = SI_Estimate::get_instance( $estimate_id );

						if ( ! is_a( $estimate, 'SI_Estimate' ) ) {
							continue;
						}

						if ( 'temp' === si_get_estimate_status( $estimate_id ) ) {
							continue;
						}

						if ( 'future' === si_get_estimate_status( $estimate_id ) ) {
							continue;
						}

						if ( 'archived' === si_get_estimate_status( $estimate_id ) ) {
							continue;
						}

							// Get a label class for the status.
						switch ( si_get_estimate_status( $estimate_id ) ) {
							case 'pending':
								$label = 'warning';
								break;
							case 'request':
								$label = 'default';
								break;
							case 'declined':
								$label = 'danger';
								break;
							case 'temp':
							default:
								$label = 'default';
								break;
						} ?>
						<tr class="status_<?php echo esc_attr( $label ); ?> <?php if ( isset( $_GET['id'] ) && $invoice_id == $_GET['id'] ) { echo 'highlight'; } ?>">
							<td>
								<small><time datetime="<?php si_estimate_issue_date( $estimate_id ) ?>"><?php echo date_i18n( apply_filters( 'si_client_dash_date_format', 'M. jS' ), si_get_estimate_issue_date( $estimate_id ) ) ?></time></small>
							</td>
							<!--<td>
								<?php si_estimate_id( $estimate_id ) ?>
							</td>-->
							<td>
								<?php if ( si_get_estimate_status( $estimate_id ) == 'pending' ) :  ?>
									<a href="<?php echo esc_url( add_query_arg( array( 'dashboard' => 1 ), get_permalink( $estimate_id ) ) ) ?>"><?php echo get_the_title( $estimate_id ) ?></a>
								<?php else : ?>
									<?php echo get_the_title( $estimate_id ) ?>
								<?php endif ?>
							</td>

							<?php if ( si_get_estimate_status( $estimate_id ) == 'pending' ) :  ?>
								<td>
									<?php if ( si_get_estimate_expiration_date( $estimate_id ) ) :  ?>
										<small class="pspsi-estimate-label pspsi-status-exp"><time datetime="<?php si_estimate_expiration_date( $estimate_id ) ?>"><?php printf( __( '<b>Expiration:</b> %s', 'sprout-invoices' ), date_i18n( apply_filters( 'si_client_dash_date_format', 'M. jS' ), si_get_estimate_expiration_date( $estimate_id ) ) ) ?></time></small>
									<?php endif ?>
								</td>
							<?php else : ?>  <!-- Estimate is in review -->
								<td>
									<small class="pspsi-status-pending pspsi-estimate-label"><?php _e( '<b>Pending</b> Review', 'sprout-invoices' ) ?></small>
								</td>
							<?php endif ?>
							<td class="psp-text-right">
								<?php if ( si_get_estimate_status( $estimate_id ) == 'pending' ) :  ?>
									<a href="<?php echo esc_url( add_query_arg( array( 'dashboard' => 'pay' ), get_permalink( $estimate_id ) ) ) ?>" class="est_action_link"><span class="button label"><?php _e( 'Accept/Decline', 'sprout-invoices' ) ?></span></a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach ?>
				<?php else : ?>
					<tr><td colspan="6" rowspan="3"><?php _e( 'No estimates pending action.', 'sprout-invoices' ) ?></td></tr>
				<?php endif ?>
			</tbody>
		</table>

	</div>
<?php endif; ?>
