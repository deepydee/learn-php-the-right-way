<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Core\Collection\Collection;
use Synthex\Phptherightway\Core\View;
use Synthex\Phptherightway\Models\User;
use Synthex\Phptherightway\Services\InvoiceService;

class HomeController
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    public function index(): View
    {
        $user = new User();
        $users = $user->all();

        $userEmails = Collection::make($users)
            ->filter(fn(\StdClass $user) => !is_null($user->email))
            ->map(fn(\StdClass $user) => $user->email)
            ->toArray();

        $items = Collection::make([1, 2, 3]);

        $items[] = 4;

        foreach($items as $item) {
            echo $item;
        }

        $isset = isset($items[3]);

        unset($items[0]);

        $this->invoiceService->process([], 25);

        return View::make('index', compact('users'));
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
