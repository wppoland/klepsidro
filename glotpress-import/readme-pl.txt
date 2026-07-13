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

Dodaje na stronach produktów WooCommerce odliczanie promocji na żywo. Bez jQuery, bez przeskoków układu, dostępny markup.

== Description ==

Ticker pokazuje, ile czasu zostało do końca promocji, bezpośrednio na stronie produktu. Odczytuje czas zakończenia z dat promocji WooCommerce każdego produktu albo z jednej daty kampanii ustawionej dla całego sklepu i odlicza do niej.

Czas zakończenia jest wyliczany po stronie serwera, więc jest jedno źródło prawdy, a błędny zegar systemowy odwiedzającego nie zmienia momentu faktycznego zakończenia promocji. Przeglądarka tylko formatuje pozostały czas, używając małego skryptu w czystym JavaScripcie, bez jQuery i bez innych zależności.

Odliczanie opiera się na promocji WooCommerce, którą już prowadzisz, więc nie trzeba nic dodatkowo planować:

* Odczytuje natywne „Daty ceny promocyjnej” każdego produktu od razu po instalacji. Ustaw datę końca promocji, a odliczanie pojawi się na tym produkcie.
* Albo ustaw jedną datę końca kampanii dla całego sklepu, jeśli wolisz odliczać wszystko do tego samego momentu. Możesz łączyć oba podejścia: wygrywa data promocji produktu, a data kampanii uzupełnia produkty bez własnej daty.
* Wybierz, gdzie ma się pojawić timer: w podsumowaniu produktu (pod ceną), przed lub po formularzu „dodaj do koszyka”, albo w obszarze meta produktu.
* Trzy formaty czasu: dni/godziny/minuty/sekundy, godziny/minuty/sekundy albo zwarte godziny/minuty bez tykających sekund przy dłuższych kampaniach.
* Opcjonalny nagłówek nad zegarem i własne sformułowanie komunikatu, który zastępuje go po zakończeniu promocji.
* Markup jest renderowany po stronie serwera z już wymiarowanymi polami cyfr, więc timer nie przesuwa układu, gdy JavaScript wypełnia liczby (brak CLS).
* Oznaczony `role="timer"` i uprzejmym regionem live, aby czytniki ekranu mogły go ogłaszać; tekst etykiety jest przetłumaczalny.
* Przestylowuj go własnymi właściwościami CSS albo skopiuj szablon do motywu pod `yourtheme/ticker/single-product/countdown.php`, aby zmienić markup.
* Bez niestandardowych tabel w bazie danych. Ustawienia trafiają do `wp_options` i są usuwane po odinstalowaniu wtyczki.
* Deklaruje zgodność z HPOS oraz blokami koszyka i kasy.

Kod źródłowy i tracker zgłoszeń są na GitHubie: https://github.com/wppoland/plogins-ticker

== Installation ==

1. Zainstaluj i włącz WooCommerce 8.0 lub nowsze.
2. Prześlij folder `ticker` do `/wp-content/plugins/` albo zainstaluj go z ekranu Wtyczki.
3. Aktywuj Ticker na ekranie <strong>Wtyczki</strong>.
4. Przejdź do <strong>WooCommerce → Ticker</strong> i zaznacz „Włącz odliczanie”.
5. Ustaw datę końca promocji na produkcie (Dane produktu → Ogólne → Daty ceny promocyjnej) albo datę końca kampanii w ustawieniach Ticker. Odliczanie pojawi się na stronie produktu.

== Frequently Asked Questions ==

= Documentation and links =

* <strong>Dokumentacja</strong> - https://plogins.com/pl/plogins-ticker/docs/
* <strong>Strona wtyczki</strong> - https://plogins.com/pl/plogins-ticker/
* <strong>Kod źródłowy</strong> - https://github.com/wppoland/plogins-ticker
* <strong>Zgłoszenia błędów i propozycje funkcji</strong> - https://github.com/wppoland/plogins-ticker/issues


= Does Ticker need WooCommerce? =
Tak. Podpina się pod strony produktów i daty promocji WooCommerce i wymaga WooCommerce 8.0 lub nowszego. Gdy WooCommerce nie jest aktywne, Ticker pozostaje cichy i pokazuje powiadomienie w panelu.

= Where does the end time come from? =
Domyślnie Ticker odczytuje wartość „Daty ceny promocyjnej → Do” każdego produktu. Możesz przełączyć źródło na jedną datę kampanii obowiązującą w całym sklepie albo zostawić datę promocji i dodatkowo ustawić datę kampanii: używana jest własna data końca promocji produktu, gdy jest ustawiona, w przeciwnym razie data kampanii.

= Will the timer move my page content around? =
Nie. Odliczanie jest renderowane po stronie serwera z już wymiarowanymi polami cyfr, więc przeglądarka wstawia liczby w zarezerwowane miejsce zamiast przebudowywać stronę. Dzięki temu Cumulative Layout Shift dla timera wynosi zero.

= What if the visitor's computer clock is wrong? =
Moment zakończenia jest wysyłany z serwera jako stały znacznik czasu UTC. Przeglądarka tylko odlicza do niego, więc źle ustawiony zegar odwiedzającego nic nie zmienia w faktycznym zakończeniu promocji.

= What shows after the sale ends? =
Zegar jest ukrywany i zastępowany krótką linią „promocja zakończona”. Możesz ustawić własne sformułowanie albo zostawić domyślne.

= What happens when I delete Ticker? =
Jego dwie opcje są usuwane i nie zostają żadne tabele, ponieważ Ticker nigdy żadnych nie tworzy.


= Does this plugin work on WordPress Multisite? =

Tak. Ta wtyczka jest kompatybilna z WordPress Multisite. Włącz ją dla całej sieci lub w poszczególnych witrynach; każda witryna zachowuje własne ustawienia i dane.

== Screenshots ==

1. Timer odliczania promocji na stronie produktu.
2. Strona ustawień: źródło odliczania, format i położenie.

== External Services ==

Ticker nie łączy się z żadnymi usługami zewnętrznymi. Czas zakończenia odliczania jest w całości wyliczany na Twoim serwerze z „Dat ceny promocyjnej” WooCommerce każdego produktu albo ze sklepowej daty kampanii, którą ustawiasz, a skrypt `assets/js/ticker.js` tylko formatuje ten czas w przeglądarce, bez żądań do podmiotów trzecich. Ustawienia są przechowywane w opcjach `ticker_settings` i `ticker_db_version` w tabeli `wp_options` Twojej witryny; nie tworzy się niestandardowych tabel i żadne dane nie opuszczają witryny.

== Translations ==

Plogins Ticker zawiera polskie, niemieckie i hiszpańskie tłumaczenia interfejsu wtyczki. Domena tekstowa to `plogins-ticker`, więc pakiety językowe z WordPress.org mogą też nadpisywać lub rozszerzać te dołączone tłumaczenia.

== Changelog ==

= 1.0.2 =
* Dodano dołączone polskie, niemieckie i hiszpańskie tłumaczenia interfejsu wtyczki.

= 1.0.1 =
* Pierwsza stabilna wersja.

= 0.1.3 =
* Zmieniono nazwę na Plogins Ticker dla WooCommerce, aby uzyskać bardziej charakterystyczną nazwę wtyczki.

= 0.1.2 =
* Dodaje akcję `ticker/countdown_rendered` i `data-ticker-product-id` w markupie odliczania dla analityki PRO.

= 0.1.1 =
* Dodaje filtr `ticker/end_timestamp`, aby PRO i własny kod mogły nadpisać ustalony czas zakończenia odliczania.

= 0.1.0 =
* Pierwsze wydanie. Odlicza do daty końca promocji WooCommerce produktu albo sklepowej daty kampanii, z konfigurowalnym położeniem, trzema formatami czasu, opcjonalnym nagłówkiem i własnym komunikatem o zakończeniu promocji. Renderowane po stronie serwera, bez jQuery, bez przeskoków układu.
