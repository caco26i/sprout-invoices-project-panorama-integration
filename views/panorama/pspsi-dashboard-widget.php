<?php
/**
 * pspsi-dashboard-widget.php
 * Places a list of invoices on the clients dashboard
 *
 * @package psp_sprout_invoices
 * @since 1.0
 */

add_action( 'psp_dashboard_widgets', 'pspsi_widget_dashboard_invoices' );
function pspsi_widget_dashboard_invoices() { ?>

    <div class="psp-archive-widget cf pspsi-invoices-widget">

        <h2><?php _e( 'Invoices', 'pspsi' ); ?></h2>

    </div>

<?php
}
