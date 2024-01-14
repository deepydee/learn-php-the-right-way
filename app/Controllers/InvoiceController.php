<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Attributes\Get;
use Synthex\Phptherightway\Attributes\Post;
use Synthex\Phptherightway\Core\View;
use Synthex\Phptherightway\Enums\InvoiceStatus;
use Synthex\Phptherightway\Models\Invoice;

class InvoiceController
{
    #[Get('/invoices')]
    public function index(): View
    {
        // (new Invoice())->seed();
        $invoices = (new Invoice())->all(InvoiceStatus::Paid);

        return View::make('invoices/index', ['invoices' => $invoices]);
    }

    #[Get('/invoices/create')]
    public function create(): View
    {
        return View::make('invoices/create');
    }

    #[Post('/invoices/create')]
    public function store()
    {
        $amount = $_POST['amount'];

        var_dump($amount);
    }
}
