<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Attributes\Get;
use Synthex\Phptherightway\Invoice;
use Synthex\Phptherightway\SalesTaxCalculator;

class InvoiceController
{
    #[Get('/invoices')]
    public function index(): void
    {
        (new Invoice(new SalesTaxCalculator()))->create([
            ['description' => 'Item 1', 'quantity' => 1, 'unitPrice' => 15.25],
            ['description' => 'Item 2', 'quantity' => 2, 'unitPrice' => 10.50],
            ['description' => 'Item 3', 'quantity' => 3, 'unitPrice' => 5.75],
        ]);
    }
}
