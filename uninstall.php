<?php
/**
 * Ticker uninstall routine.
 *
 * Removes plugin options when the user deletes the plugin. Ticker does not
 * create custom tables; settings live in wp_options only, per site.
 *
 * @package Ticker
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

if ( is_multisite() ) {
	foreach ( get_sites( array( 'fields' => 'ids', 'number' => 0 ) ) as $ticker_site_id ) {
		switch_to_blog( (int) $ticker_site_id );
		delete_option( 'ticker_settings' );
		delete_option( 'ticker_db_version' );
		restore_current_blog();
	}
	unset( $ticker_site_id );
} else {
	delete_option( 'ticker_settings' );
	delete_option( 'ticker_db_version' );
}

// The PRO banner's dismissal is stored per user, so it belongs to the
// plugin rather than to the site content. User meta is global, not
// per-site, which is why this uses delete_metadata's \$delete_all rather
// than a loop over the users of one blog.
delete_metadata('user', 0, 'ticker_pro_banner_dismissed', '', true);
