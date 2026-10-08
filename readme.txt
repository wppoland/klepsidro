=== Klepsidro - Countdown Timer for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, countdown, sale, urgency, timer
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 8.1
Stable tag: 1.1.3
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds a live sale countdown to WooCommerce product pages. No jQuery, no layout shift, accessible markup.

== Description ==

Klepsidro shows how much time is left on a sale, right on the product page. It reads the end time from each product's WooCommerce sale dates, or from a single campaign date you set for the whole store, and counts down to it.

The end time is worked out on the server, so there is one source of truth and a visitor's wrong system clock can't change when the sale actually ends. The browser only formats the remaining time, using a small vanilla-JavaScript script with no jQuery and no other dependencies.

The countdown is built around the WooCommerce sale you already run, so there is nothing extra to schedule:

* Reads each product's native "Sale price dates" out of the box. Set a sale end date and the countdown shows up on that product. On a variable product it counts down to the earliest sale end among its variations.
* Or set one store-wide campaign end date if you'd rather count everything down to the same moment. You can mix the two: the per-product sale date wins, and the campaign date fills in for products that don't have one.
* Pick where the timer goes: the product summary (below the price), before or after the add-to-cart form, or the product meta area.
* Three time formats: days/hours/minutes/seconds, hours/minutes/seconds, or a compact hours/minutes that drops the ticking seconds on longer campaigns.
* Optional heading above the clock, and your own wording for the message that replaces it once the sale is over.
* The markup is rendered server-side with the digit boxes already sized, so the timer doesn't push your layout around when JavaScript fills in the numbers (no CLS).
* Marked up with `role="timer"` and a polite live region so screen readers can announce it, and the label text is translatable.
* Restyle it with CSS custom properties, or copy the template into your theme at `yourtheme/ticker/single-product/countdown.php` to change the markup.
* No custom database tables. Settings sit in `wp_options` and are deleted when you remove the plugin.
* Declares HPOS and Cart/Checkout Blocks compatibility.

Source code and issue tracker live on GitHub: [github.com/wppoland/plogins-ticker](https://github.com/wppoland/plogins-ticker)

== Installation ==

1. Install and activate WooCommerce 8.0 or later.
2. Upload the `klepsidro` folder to `/wp-content/plugins/`, or install it from the Plugins screen.
3. Activate Klepsidro through the **Plugins** screen.
4. Go to **WooCommerce > Klepsidro** and tick "Enable countdown".
5. Set a sale end date on a product (Product data > General > Sale price dates), or set a campaign end date in Klepsidro's settings. The countdown then appears on the product page.

== Frequently Asked Questions ==

= Documentation and links =

* **Documentation**: [plogins.com/plogins-ticker/docs/](https://plogins.com/plogins-ticker/docs/)
* **Plugin page**: [plogins.com/plogins-ticker/](https://plogins.com/plogins-ticker/)
* **Source code**: [github.com/wppoland/plogins-ticker](https://github.com/wppoland/plogins-ticker)
* **Bug reports and feature requests**: [github.com/wppoland/plogins-ticker/issues](https://github.com/wppoland/plogins-ticker/issues)


= Does Klepsidro need WooCommerce? =
Yes. It hooks into WooCommerce product pages and sale dates, and needs WooCommerce 8.0 or later. If WooCommerce isn't active, Klepsidro stays quiet and shows an admin notice.

= Where does the end time come from? =
By default Klepsidro reads each product's "Sale price dates > To" value. You can switch the source to a single campaign date that applies across the store, or leave it on the sale date and set a campaign date as well: the product's own sale end is used when it has one, otherwise the campaign date.

= Will the timer move my page content around? =
No. The countdown is rendered on the server with the digit boxes already sized, so the browser drops the numbers into reserved space instead of reflowing the page. That keeps Cumulative Layout Shift at zero for the timer.

= What if the visitor's computer clock is wrong? =
The end moment is sent from the server as a fixed UTC timestamp. The browser only counts down to it, so a visitor's misconfigured clock changes nothing about when the sale ends.

= What shows after the sale ends? =
The clock is hidden and replaced by a short "sale ended" line. You can set your own wording for it, or leave it on the default.

= What happens when I delete Klepsidro? =
Its two options are removed, on every site of a multisite network, and no tables are left behind, since Klepsidro never creates any.


= Does this plugin work on WordPress Multisite? =

Yes. This plugin is compatible with WordPress Multisite. Network activate it or activate it on individual sites; each site keeps its own settings and data.

== Screenshots ==

1. The sale countdown timer on a product page.
2. The settings page: countdown source, format, and placement.

== External Services ==

Klepsidro does not connect to any external services. It resolves the countdown end time entirely on your own server from each product's WooCommerce "Sale price dates" or a store-wide campaign date you set, and its `assets/js/ticker.js` script only formats that time in the browser, with no requests to any third party. Your settings are stored in the `ticker_settings` and `ticker_db_version` options in your site's `wp_options` table; no custom tables are created and no data leaves your site.

== Translations ==

Klepsidro is fully translatable and ships the `klepsidro.pot` template. Translations are delivered by WordPress.org language packs from translate.wordpress.org, which is where Polish, German and Spanish are being contributed; the package itself carries no compiled translation files.

== Changelog ==

= 1.1.3 =
* Fixed: the time format setting had no visible effect. The countdown's own layout styles kept the days and seconds boxes on screen, so the hours/minutes/seconds and compact formats still showed them.
* Fixed: a sale that had already ended when the page loaded showed a frozen "-- days -- hrs" clock instead of the sale-ended message.
* Fixed: variable products on sale never got a countdown, because their sale dates live on the variations. The countdown now runs to the earliest sale end among the variations on sale.
* Fixed: deleting the plugin on a multisite network removed its settings from the current site only. They are now removed from every site.

= 1.1.2 =
* The upgrade notice's "Coming soon" and "Get notified" labels are English source strings for every language; Polish sites used to get their own Polish source text, which translators in other languages then saw untranslated.

= 1.1.1 =
* The settings screen is reachable by a shop manager, but saving it went through options.php, which checks manage_options. A shop manager could fill the form in and be told they were not allowed to manage options for this site. Saving now uses the same capability as the menu.
* The sidebar upgrade promo follows the banner's dismissal, so dismissing it no longer leaves a permanent advert on the screen.

= 1.1.0 =
* Renamed to Klepsidro. The WordPress.org review team asks a plugin name to lead with a distinctive, coined identifier rather than a generic descriptive word. Klepsidro is Esperanto for an hourglass. The text domain follows the name; the stored data, the settings and every hook are unchanged.

= 1.0.10 =
* Fixed: the PRO upgrade promo kept selling to people who had already bought the paid edition. Only the banner could be dismissed, so the sidebar promo and the locked feature cards followed a paying customer around for good. The promo now checks whether the paid edition is active and steps aside when it is.
* Fixed: arrow glyphs in the admin menu paths, and in the strings handed to translators. An arrow inside a translatable string makes the glyph every translator's problem and changes the layout in any locale that drops it.

= 1.0.9 =
* Fixed: deleting the plugin left the per-user "dismiss" flag from the PRO notice in the database. Uninstall now removes it for every user, not just the one who dismissed it.

= 1.0.8 =
* The translation template was regenerated. It still named an older version of the plugin and pointed at source lines that had since moved, which is what translation tools read to show a string in context.

= 1.0.7 =
* Renamed to Plogins Ticker - Countdown Timer for WooCommerce so the name leads with the brand rather than a generic word, which is what the WordPress.org plugin review team asks for. The plugin slug is unchanged.

= 1.0.6 =
* Tested against WordPress 7.1. Verified by activating this build on a clean 7.1 install with WooCommerce 11.1, not by editing the header.

= 1.0.5 =
* Fixed the PRO promo on the settings screen quoting a price in PLN. PRO is priced and charged in EUR, so an admin on a Polish site was shown a zloty amount and then billed in euro, and the zloty figure was a fixed conversion that drifted from the real charge as the rate moved. The promo now shows the euro price that is actually taken.

= 1.0.3 =
* Translations: completed Polish, German and Spanish for the PRO upgrade panel.

= 1.0.2 =
* Added bundled Polish, German and Spanish translations for the plugin interface.

= 1.0.1 =
* First stable release.

= 0.1.3 =
* Renamed to Plogins Ticker for WooCommerce for a more distinctive plugin name.

= 0.1.2 =
* Add `ticker/countdown_rendered` action and `data-ticker-product-id` on the countdown markup for PRO analytics.

= 0.1.1 =
* Add `ticker/end_timestamp` filter so PRO and custom code can override the resolved countdown end time.

= 0.1.0 =
* First release. Counts down to a product's WooCommerce sale end date or a store-wide campaign date, with configurable placement, three time formats, an optional heading, and a custom sale-ended message. Server-rendered, no jQuery, no layout shift.
