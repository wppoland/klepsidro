=== Plogins Ticker - Countdown Timer for WooCommerce ===
Contributors: motylanogha
Tags: woocommerce, countdown, sale, urgency, timer
Requires at least: 6.5
Tested up to: 7.0
Requires PHP: 8.1
Stable tag: 1.0.2
Requires Plugins: woocommerce
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Fügt WooCommerce-Produktseiten einen Live-Verkaufs-Countdown hinzu. Kein jQuery, keine Layout-Verschiebung, barrierefreies Markup.

== Description ==

Ticker zeigt direkt auf der Produktseite, wie viel Zeit im Sale noch übrig ist. Es liest den Endzeitpunkt aus den WooCommerce-Verkaufsdaten jedes Produkts oder aus einem einzigen Kampagnen-Datum, das du für den gesamten Shop festlegst, und zählt bis dahin herunter.

Der Endzeitpunkt wird serverseitig berechnet, sodass es eine einzige Quelle der Wahrheit gibt und die falsche Systemuhr eines Besuchers nicht ändert, wann der Sale tatsächlich endet. Der Browser formatiert nur die verbleibende Zeit mit einem kleinen Skript in reinem JavaScript – ohne jQuery und ohne weitere Abhängigkeiten.

Der Countdown baut auf dem WooCommerce-Sale auf, den du bereits führst, sodass nichts Zusätzliches geplant werden muss:

* Liest die nativen „Verkaufspreis-Daten“ jedes Produkts sofort aus. Lege ein Verkaufsende fest und der Countdown erscheint auf diesem Produkt.
* Oder lege ein shopweites Kampagnen-Enddatum fest, wenn du alles bis zum gleichen Moment herunterzählen lassen willst. Du kannst beides mischen: Das Verkaufsende pro Produkt hat Vorrang, das Kampagnen-Datum füllt Produkte ohne eigenes Datum auf.
* Wähle, wo der Timer erscheint: in der Produktzusammenfassung (unter dem Preis), vor oder nach dem Formular „In den Warenkorb“ oder im Produkt-Meta-Bereich.
* Drei Zeitformate: Tage/Stunden/Minuten/Sekunden, Stunden/Minuten/Sekunden oder kompakte Stunden/Minuten ohne tickende Sekunden bei längeren Kampagnen.
* Optionaler Überschrift über der Uhr und eigener Wortlaut für die Meldung, die sie nach Sale-Ende ersetzt.
* Das Markup wird serverseitig mit bereits dimensionierten Ziffernfeldern gerendert, sodass der Timer dein Layout nicht verschiebt, wenn JavaScript die Zahlen einsetzt (kein CLS).
* Mit `role="timer"` und einer höflichen Live-Region markiert, damit Screenreader es ansagen können; der Beschriftungstext ist übersetzbar.
* Gestalte es mit CSS Custom Properties neu oder kopiere die Vorlage in dein Theme nach `yourtheme/ticker/single-product/countdown.php`, um das Markup zu ändern.
* Keine benutzerdefinierten Datenbanktabellen. Einstellungen liegen in `wp_options` und werden beim Entfernen des Plugins gelöscht.
* Deklariert HPOS- sowie Warenkorb-/Kassen-Block-Kompatibilität.

Quellcode und Issue-Tracker liegen auf GitHub: https://github.com/wppoland/plogins-ticker

== Installation ==

1. Installiere und aktiviere WooCommerce 8.0 oder neuer.
2. Lade den Ordner `ticker` nach `/wp-content/plugins/` hoch oder installiere ihn über den Plugins-Bildschirm.
3. Aktiviere Ticker über den Bildschirm <strong>Plugins</strong>.
4. Gehe zu <strong>WooCommerce → Ticker</strong> und aktiviere „Countdown einschalten“.
5. Lege auf einem Produkt ein Verkaufsende fest (Produktdaten → Allgemein → Verkaufspreis-Daten) oder ein Kampagnen-Enddatum in den Ticker-Einstellungen. Der Countdown erscheint dann auf der Produktseite.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentation</strong> - https://plogins.com/de/plogins-ticker/docs/
* <strong>Plugin-Seite</strong> - https://plogins.com/de/plogins-ticker/
* <strong>Quellcode</strong> - https://github.com/wppoland/plogins-ticker
* <strong>Fehlerberichte und Funktionswünsche</strong> - https://github.com/wppoland/plogins-ticker/issues


= Does Ticker need WooCommerce? =
Ja. Es bindet sich in WooCommerce-Produktseiten und Verkaufsdaten ein und benötigt WooCommerce 8.0 oder neuer. Wenn WooCommerce nicht aktiv ist, bleibt Ticker still und zeigt einen Admin-Hinweis.

= Where does the end time come from? =
Standardmäßig liest Ticker den Wert „Verkaufspreis-Daten → Bis“ jedes Produkts. Du kannst die Quelle auf ein einziges Kampagnen-Datum für den gesamten Shop umstellen oder beim Verkaufsdatum bleiben und zusätzlich ein Kampagnen-Datum setzen: Das eigene Verkaufsende des Produkts wird verwendet, wenn eines gesetzt ist, andernfalls das Kampagnen-Datum.

= Will the timer move my page content around? =
Nein. Der Countdown wird serverseitig mit bereits dimensionierten Ziffernfeldern gerendert, sodass der Browser die Zahlen in reservierten Platz setzt, statt die Seite neu zu fließen. Das hält den Cumulative Layout Shift für den Timer bei null.

= What if the visitor's computer clock is wrong? =
Der Endzeitpunkt wird vom Server als fester UTC-Zeitstempel gesendet. Der Browser zählt nur bis dahin herunter, sodass eine falsch eingestellte Uhr des Besuchers nichts am tatsächlichen Sale-Ende ändert.

= What shows after the sale ends? =
Die Uhr wird ausgeblendet und durch eine kurze Zeile „Sale beendet“ ersetzt. Du kannst einen eigenen Wortlaut festlegen oder den Standard belassen.

= What happens when I delete Ticker? =
Seine zwei Optionen werden entfernt und es bleiben keine Tabellen zurück, da Ticker nie welche erstellt.


= Does this plugin work on WordPress Multisite? =

Ja. Dieses Plugin ist mit WordPress Multisite kompatibel. Aktiviere es netzwerkweit oder auf einzelnen Websites; jede Website behält ihre eigenen Einstellungen und Daten.

== Screenshots ==

1. Der Verkaufs-Countdown-Timer auf einer Produktseite.
2. Die Einstellungsseite: Countdown-Quelle, Format und Platzierung.

== External Services ==

Ticker stellt keine Verbindung zu externen Diensten her. Es ermittelt den Countdown-Endzeitpunkt vollständig auf deinem eigenen Server aus den WooCommerce-„Verkaufspreis-Daten“ jedes Produkts oder einem von dir gesetzten shopweiten Kampagnen-Datum, und sein Skript `assets/js/ticker.js` formatiert diese Zeit nur im Browser – ohne Anfragen an Dritte. Deine Einstellungen werden in den Optionen `ticker_settings` und `ticker_db_version` in der `wp_options`-Tabelle deiner Website gespeichert; es werden keine benutzerdefinierten Tabellen erstellt und keine Daten verlassen deine Website.

== Translations ==

Plogins Ticker enthält deutsche, polnische und spanische Übersetzungen für die Plugin-Oberfläche. Die Textdomain ist `plogins-ticker`, sodass Sprachpakete von WordPress.org diese mitgelieferten Übersetzungen ebenfalls überschreiben oder erweitern können.

== Changelog ==

= 1.0.2 =
* Deutsche, polnische und spanische Übersetzungen für die Plugin-Oberfläche mitgeliefert.

= 1.0.1 =
* Erste stabile Version.

= 0.1.3 =
* Für einen eindeutigeren Plugin-Namen in Plogins Ticker für WooCommerce umbenannt.

= 0.1.2 =
* Fügt die Aktion `ticker/countdown_rendered` und `data-ticker-product-id` im Countdown-Markup für PRO-Analysen hinzu.

= 0.1.1 =
* Fügt den Filter `ticker/end_timestamp` hinzu, damit PRO und eigener Code den ermittelten Countdown-Endzeitpunkt überschreiben können.

= 0.1.0 =
* Erstveröffentlichung. Zählt bis zum WooCommerce-Verkaufsende eines Produkts oder einem shopweiten Kampagnen-Datum herunter, mit konfigurierbarer Platzierung, drei Zeitformaten, optionaler Überschrift und eigener Sale-beendet-Meldung. Serverseitig gerendert, kein jQuery, keine Layout-Verschiebung.
