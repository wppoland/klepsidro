<?php

/**
 * The countdown's three sale-specific strings can be replaced through the
 * template args, and fall back to the sale wording when they are not.
 *
 * Rezervo reuses the timer for a pre-order release date; "Sale ends in" above
 * a release date would tell the shopper something untrue.
 *
 * Run: php tests/template-strings-check.php
 */

declare(strict_types=1);

define('ABSPATH', __DIR__);

// phpcs:disable
function __(string $text, string $domain = ''): string
{
    return $text;
}

function esc_attr(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES);
}

function esc_html(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES);
}

function esc_html_e(string $text, string $domain = ''): void
{
    echo esc_html($text);
}

function render(array $args): string
{
    extract($args);
    ob_start();
    include __DIR__ . '/../templates/single-product/countdown.php';
    return (string) ob_get_clean();
}

$failures = 0;
$check = static function (string $label, bool $ok) use (&$failures): void {
    echo ($ok ? 'ok    ' : 'FAIL  ') . $label . "\n";
    $failures += $ok ? 0 : 1;
};

$base = ['ticker_end_ts' => time() + 3600, 'ticker_now' => time()];

$default = render($base);
$check('default lead is the sale wording', str_contains($default, '>Sale ends in<'));
$check('default announce template is the sale wording', str_contains($default, 'data-ticker-announce-template="Sale ends in %s"'));
$check('default label is the sale wording', str_contains($default, 'aria-label="Sale countdown"'));

$custom = render($base + [
    'ticker_lead'     => 'Releases in',
    'ticker_announce' => 'Releases in %s',
    'ticker_label'    => 'Release countdown',
]);
$check('lead is replaced', str_contains($custom, '>Releases in<') && ! str_contains($custom, 'Sale ends in'));
$check('announce template is replaced', str_contains($custom, 'data-ticker-announce-template="Releases in %s"'));
$check('label is replaced', str_contains($custom, 'aria-label="Release countdown"'));

$empty = render($base + ['ticker_lead' => '']);
$check('an empty lead falls back to the sale wording', str_contains($empty, '>Sale ends in<'));

echo 0 === $failures ? "\nAll checks passed.\n" : "\n{$failures} check(s) failed.\n";
exit(0 === $failures ? 0 : 1);
