<?php

/**
 * A variable product on sale must count down to its variations' sale end.
 *
 * WooCommerce keeps sale dates on the variations, so reading the parent's
 * get_date_on_sale_to() returned null and no countdown rendered at all.
 *
 * Run: php tests/variable-sale-end-check.php
 */

declare(strict_types=1);

namespace Ticker\Contract {
    interface HasHooks
    {
    }
}

namespace {
    define('ABSPATH', __DIR__);

    class WC_DateTime extends DateTime
    {
    }

    class WC_Product
    {
        public function __construct(public bool $sale = false, public ?int $to = null)
        {
        }

        public function is_on_sale(): bool
        {
            return $this->sale;
        }

        public function get_date_on_sale_to(): ?WC_DateTime
        {
            return null === $this->to ? null : new WC_DateTime('@' . $this->to);
        }
    }

    class WC_Product_Variable extends WC_Product
    {
        public function __construct(public array $children)
        {
            parent::__construct(true, null);
        }

        public function get_children(): array
        {
            return array_keys($this->children);
        }
    }

    $GLOBALS['ticker_products'] = [];

    function wc_get_product(int $id): WC_Product|false
    {
        return $GLOBALS['ticker_products'][$id] ?? false;
    }

    require __DIR__ . '/../src/Service/CountdownService.php';

    $service = (new ReflectionClass(\Ticker\Service\CountdownService::class))->newInstanceWithoutConstructor();
    $method  = new ReflectionMethod($service, 'sale_end_timestamp');

    $GLOBALS['ticker_products'] = [
        11 => new WC_Product(true, 2000),
        12 => new WC_Product(true, 1500),
        13 => new WC_Product(false, 1000), // Not on sale: ignored.
        14 => new WC_Product(true, null),  // On sale, no end date: ignored.
    ];

    $cases = [
        'simple on sale'       => [new WC_Product(true, 3000), 3000],
        'simple not on sale'   => [new WC_Product(false, 3000), null],
        'variable, earliest'   => [new WC_Product_Variable(array_flip([11, 12, 13, 14])), 1500],
        'variable, no end set' => [new WC_Product_Variable(array_flip([14])), null],
    ];

    $failures = 0;
    foreach ($cases as $label => [$product, $want]) {
        $got = $method->invoke($service, $product);
        if ($got !== $want) {
            echo "FAIL: {$label}: got " . var_export($got, true) . ', expected ' . var_export($want, true) . "\n";
            $failures++;
        }
    }

    echo 0 === $failures ? "OK: sale end resolves for simple and variable products\n" : '';
    exit($failures > 0 ? 1 : 0);
}
