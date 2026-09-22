<?php
/**
 * PRO upsell content, generated from the plogins.com registry by
 * scripts/gen-pro-upsell.mjs. The admin upsell renders this; curate the
 * feature list to fit this plugin's settings screen (do not invent features).
 *
 * @package plogins-ticker-pro
 */

defined('ABSPATH') || exit;

return [
    'name'       => 'Klepsidro Pro',
    'url'        => 'https://plogins.com/plogins-ticker-pro/pricing/',
    'sellable'   => true,
    'price_from' => 19,
    'currency'   => 'EUR',
    'lead'       => [
        'en' => 'Per-product campaign dates, scheduled windows, recurring campaigns, product targeting and analytics are available today.',
        'pl' => 'Per-produktowa data kampanii, zaplanowane okna, cykliczne kampanie, targetowanie i analityka są już dostępne.',
    ],
    'features'   => [
        [
            'en' => ['title' => 'Per-product campaign end date', 'desc' => 'A Klepsidro campaign end field on each product, countdown to a chosen date without native WooCommerce sale dates.'],
            'pl' => ['title' => 'Data końca kampanii per produkt', 'desc' => 'Pole „Klepsidro campaign end” na karcie produktu, odliczanie do wybranej daty bez natywnych dat wyprzedaży WooCommerce.'],
        ],
        [
            'en' => ['title' => 'Scheduled campaign windows', 'desc' => 'Hide the countdown before a global or per-product campaign start time.'],
            'pl' => ['title' => 'Zaplanowane okna kampanii', 'desc' => 'Ukryj licznik przed startem kampanii globalnie lub per produkt.'],
        ],
        [
            'en' => ['title' => 'Recurring countdown campaigns', 'desc' => 'Weekly or monthly flash-sale windows that reset automatically and hide the timer between cycles.'],
            'pl' => ['title' => 'Cykliczne kampanie odliczania', 'desc' => 'Tygodniowe lub miesięczne okna wyprzedaży, które resetują się automatycznie i ukrywają timer między cyklami.'],
        ],
        [
            'en' => ['title' => 'Product targeting', 'desc' => 'Show or hide the countdown on selected products, categories or tags on WooCommerce > Klepsidro.'],
            'pl' => ['title' => 'Targetowanie produktów', 'desc' => 'Pokaż lub ukryj odliczanie na wybranych produktach, kategoriach lub tagach na WooCommerce > Klepsidro.'],
        ],
        [
            'en' => ['title' => 'Countdown analytics', 'desc' => 'Track aggregate views and add-to-cart counts per product on WooCommerce > Klepsidro Analytics.'],
            'pl' => ['title' => 'Analityka odliczania', 'desc' => 'Zliczaj wyświetlenia i dodania do koszyka per produkt na WooCommerce > Klepsidro Analytics.'],
        ],
        [
            'en' => ['title' => 'Extends free Klepsidro', 'desc' => 'Requires the active free Klepsidro plugin; delivered through Freemius with licensing and automatic updates.'],
            'pl' => ['title' => 'Rozszerza darmowy Klepsidro', 'desc' => 'Wymaga aktywnej darmowej wtyczki Klepsidro; dostarczany przez Freemius z licencją i automatycznymi aktualizacjami.'],
        ],
    ],
];
