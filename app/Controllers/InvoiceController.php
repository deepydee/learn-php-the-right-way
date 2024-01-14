<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;
use Synthex\Phptherightway\Core\View;

class InvoiceController
{
    public function index(): View
    {
        return View::make('invoices/index');
    }

    public function create(): View
    {
        return View::make('invoices/create');
    }

    public function store()
    {
        $amount = $_POST['amount'];

        var_dump($amount);
    }
}
