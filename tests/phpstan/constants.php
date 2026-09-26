<?php

declare(strict_types=1);

/**
 * PHPStan bootstrap: define plugin constants so ticker.php and src/ can be
 * analysed without a running WordPress environment.
 */

if (! defined('ABSPATH')) {
    define('ABSPATH', '/tmp/');
}
define('Ticker\VERSION', '0.1.0');
define('Ticker\PLUGIN_FILE', '/tmp/ticker.php');
define('Ticker\PLUGIN_DIR', '/tmp');

// Defined at runtime by the main plugin file; phpstan does not evaluate
// those define() calls, so the ProUpsell panel would read as undefined.
if (! defined('TICKER_DIR')) {
define('TICKER_DIR', '/tmp/ticker/');
}
if (! defined('TICKER_URL')) {
define('TICKER_URL', 'https://example.test/wp-content/plugins/ticker/');
}
