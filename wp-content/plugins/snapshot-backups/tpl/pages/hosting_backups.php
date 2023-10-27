<?php // phpcs:ignore
/**
 * Hosting backups page.
 *
 * @package snapshot
 */

use WPMUDEV\Snapshot4\Helper\Assets;
use WPMUDEV\Snapshot4\Helper\Settings;

$assets = new Assets();

wp_nonce_field( 'snapshot_list_hosting_backups', '_wpnonce-list-hosting-backups' );
wp_nonce_field( 'snapshot_download_hosting_backup', '_wpnonce-download-hosting-backup' );

?>
<div class="sui-wrap snapshot-page-hosting-backups">
	<?php $this->render( 'common/header' ); ?>

	<div class="sui-header">
		<h1 class="sui-header-title"><?php esc_html_e( 'Hosting Backups', 'snapshot' ); ?></h1>
		<?php if ( ! Settings::get_branding_hide_doc_link() ) { ?>
			<div class="sui-actions-right">
				<a href="https://wpmudev.com/docs/wpmu-dev-plugins/snapshot-4-0/?utm_source=snapshot&utm_medium=plugin&utm_campaign=snapshot_hosting_docs#hosting-backups" target="_blank" class="sui-button sui-button-ghost">
					<span class="sui-icon-academy" aria-hidden="true"></span>
					<?php esc_html_e( 'Documentation', 'snapshot' ); ?>
				</a>
			</div>
		<?php } ?>
	</div>
	<?php
	$this->render(
		'common/v3-prompt',
		array(
			'active_v3'          => $active_v3,
			'v3_local'           => $v3_local,
			'assets'             => $assets,
			'is_branding_hidden' => $is_branding_hidden,
		)
	);
	?>

	<div class="sui-box sui-summary snapshot-hosting-backups-summary<?php echo esc_html( $sui_branding_class ); ?>">

		<div class="sui-summary-image-space" aria-hidden="true" style="background-image: url( '<?php echo esc_url( apply_filters( 'wpmudev_branding_hero_image', '' ) ); ?>' )"></div>

		<div class="sui-summary-segment">

			<div class="sui-summary-details snapshot-backups-number">

				<span class="sui-summary-large snapshot-hosting-backup-count"></span>
				<span class="sui-icon-loader sui-loading snapshot-loading" aria-hidden="true"></span>
				<span class="sui-summary-sub"><?php esc_html_e( 'Backups available', 'snapshot' ); ?></span>

			</div>

		</div>

		<div class="sui-summary-segment">

			<ul class="sui-list">

				<li>
					<span class="sui-list-label"><?php esc_html_e( 'Last backup', 'snapshot' ); ?></span>
					<span class="sui-list-detail"><i class="sui-icon-loader sui-loading snapshot-loading" aria-hidden="true"></i><span class="snapshot-last-hosting-backup"></span></span>
				</li>

				<li>
					<span class="sui-list-label"><?php esc_html_e( 'Next scheduled backup', 'snapshot' ); ?></span>
					<span class="sui-list-detail"><i class="sui-icon-loader sui-loading snapshot-loading" aria-hidden="true"></i><span class="snapshot-next-hosting-backup"></span></span>
				</li>

				<li>
					<span class="sui-list-label"><?php esc_html_e( 'Backup schedule', 'snapshot' ); ?></span>
					<span class="sui-list-detail">
						<span class="sui-icon-loader sui-loading snapshot-loading" aria-hidden="true"></span>
						<span class="snapshot-hosting-backup-schedule sui-tooltip sui-tooltip-top-right sui-tooltip-constrained"></span>
					</span>
				</li>

			</ul>

		</div>

	</div>

	<div class="snapshot-page-main">

		<div class="sui-box snapshot-hosting-backups-backups">
			<div class="sui-box-header">
				<h2 class="sui-box-title"><?php esc_html_e( 'Available backups', 'snapshot' ); ?></h2>
			</div>
			<div class="sui-box-body" style="padding-bottom: 0;">
				<p><?php esc_html_e( 'Here are all of your available hosting backups.', 'snapshot' ); ?></p>

				<div class="api-error" style="display: none;">
					<div class="sui-notice sui-notice-error" style="margin-bottom: 10px;">
						<div class="sui-notice-content">
							<div class="sui-notice-message">
								<span class="sui-notice-icon sui-icon-warning-alert sui-md" aria-hidden="true"></span>
								<p><?php echo wp_kses_post( sprintf( 'We were unable to fetch backup data from the API due to a connection problem. Give it another try below, or <a href="%s" target="_blank">contact our support team</a> if the problem persists.', 'https://wpmudev.com/hub2/support#get-support' ) ); ?></p>
							</div>
						</div>
					</div>
					<button class="sui-button sui-button-ghost reload-backups" role="button"><span class="sui-icon-refresh" aria-hidden="true"></span><?php esc_html_e( 'Reload', 'snapshot' ); ?></button>
				</div>

				<div class="sui-message snapshot-backup-list-loader">
					<div class="sui-message-content">
						<p><span class="sui-icon-loader sui-loading" aria-hidden="true"></span> <?php esc_html_e( 'Loading backups...', 'snapshot' ); ?></p>
					</div>
				</div>
			</div>

			<table class="sui-table sui-table-flushed sui-accordion snapshot-hosting-backups-table" style="display: none;">

				<thead>
					<tr>
						<td class="render-pagination-top" colspan="3" style="border-bottom: none;"></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Title', 'snapshot' ); ?></th>
						<th><?php esc_html_e( 'Destination', 'snapshot' ); ?></th>
						<th><?php esc_html_e( 'Time', 'snapshot' ); ?></th>
					</tr>
				</thead>
				<tbody></tbody>
				<tfoot>
					<tr>
						<td class="render-pagination" colspan="3"></td>
					</tr>
				</tfoot>
			</table>

			<div style="height: 30px;"></div>

		</div>

	</div>

	<?php

	// Snapshot getting started dialog.
	$this->render(
		'modals/welcome-activation',
		array(
			'errors'             => $errors,
			'welcome_modal'      => $welcome_modal,
			'welcome_modal_alt'  => $welcome_modal_alt,
			'is_branding_hidden' => $is_branding_hidden,
		)
	);

	$this->render( 'modals/confirm-wpmudev-password' );

	$this->render( 'modals/confirm-v3-uninstall' );
	$this->render( 'common/footer' );

	?>

</div> <?php // .sui-wrap ?>