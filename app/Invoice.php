<?php

declare(strict_types=1);

namespace Synthex\Phptherightway;

use Synthex\Phptherightway\SalesTaxCalculator;

class Invoice
{
    public function __construct(protected SalesTaxCalculator $salesTaxCalculator)
    {
    }

    public function create(array $lineItems): void
    {
        // calculate sub total
        $lineItemsTotal = $this->calclateLineItemsTotal($lineItems);

        // calculate sales tax
        $salesTax = $this->salesTaxCalculator->calculate($lineItemsTotal);

        $total = $lineItemsTotal + $salesTax;

        echo 'Sub Total: $' . $lineItemsTotal . '<br>' .
            'SalesTax: $' . $salesTax . '<br>' .
            'Total: $' . $total . '<br>';
    }

    private function calclateLineItemsTotal(array $items): float|int
    {
        return array_sum(
            array_map(
                fn($item) => $item['unitPrice'] * $item['quantity'],
                $items
            )
        );
    }
}
