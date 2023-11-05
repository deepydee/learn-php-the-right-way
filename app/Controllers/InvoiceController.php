<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

class InvoiceController
{
    public function index(): string
    {
        unset($_SESSION['count']);

         // remove coolie - pass negative to expire
         setcookie(
            name: 'userName',
            value: 'Vito',
            expires_or_options: time() - 10,
            path: '/',
            domain: '',
            secure: false,
            httponly: false,
        );

        return 'Invoice';
    }

    public function create(): string
    {
        $form = <<<HTML
        <form action="/invoices/create" method="post">
            <label for="amount">Amount</label>
            <input type="text" name="amount" id="amount" />
            <button type="submit">Create</button>
        </form>
        HTML;

        return $form;
    }

    public function store()
    {
        $amount = $_POST['amount'];

        var_dump($amount);
    }
}
