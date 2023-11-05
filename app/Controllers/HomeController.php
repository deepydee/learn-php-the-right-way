<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Actions\SignUpAction;
use Synthex\Phptherightway\Core\App;
use Synthex\Phptherightway\Core\View;
use Synthex\Phptherightway\Models\Invoice;
use Synthex\Phptherightway\Models\User;

class HomeController
{
    public function index(): View
    {
        $email = 'vito777@hooligan11.com';
        $name = 'Vitalii Hooligan';
        $amount = 250;

        $user = new User();
        $invoice = new Invoice();

        $invoiceId = (new SignUpAction($user, $invoice))->register(
            [
                'email' => $email,
                'name' => $name,
            ],
            [
                'amount' => $amount,
            ]
        );

        return View::make('index', ['invoice' => $invoice->find($invoiceId)]);
    }

    public function download()
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="invoice.pdf"');

        readfile(STORAGE_PATH . '/Пример.pdf');
    }

    public function upload(): void
    {
        $filePath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];

        move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath);

        header('Location: /');

        exit;
    }
}
