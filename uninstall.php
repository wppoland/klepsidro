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

// An add-on keeps its own settings inside ticker_settings. While it is
// installed, active or not, that option is the add-on's to remove when it is
// uninstalled; with no add-on on disk it is ours. Matched on the text domain,
// so a renamed folder still counts. The plugin list is cached per request and
// a bulk delete runs both uninstalls in one request, so drop the cache first.
if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
wp_cache_delete( 'plugins', 'plugins' );
$ticker_addon_installed = in_array( 'klepsidro-pro', array_column( get_plugins(), 'TextDomain' ), true );

if ( is_multisite() ) {
	foreach ( get_sites( array( 'fields' => 'ids', 'number' => 0 ) ) as $ticker_site_id ) {
		switch_to_blog( (int) $ticker_site_id );
		if ( ! $ticker_addon_installed ) {
			delete_option( 'ticker_settings' );
		}
		delete_option( 'ticker_db_version' );
		restore_current_blog();
	}
	unset( $ticker_site_id );
} else {
	if ( ! $ticker_addon_installed ) {
		delete_option( 'ticker_settings' );
	}
	delete_option( 'ticker_db_version' );
}

// The PRO banner's dismissal is stored per user, so it belongs to the
// plugin rather than to the site content. User meta is global, not
// per-site, which is why this uses delete_metadata's \$delete_all rather
// than a loop over the users of one blog.
delete_metadata('user', 0, 'ticker_pro_banner_dismissed', '', true);
