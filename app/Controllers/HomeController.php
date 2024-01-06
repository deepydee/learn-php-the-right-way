<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Synthex\Phptherightway\Attributes\Get;
use Synthex\Phptherightway\Attributes\Post;
use Synthex\Phptherightway\Attributes\Put;
use Synthex\Phptherightway\Core\Collection\Collection;
use Synthex\Phptherightway\Core\View;
use Synthex\Phptherightway\Enums\RequestMethod;
use Synthex\Phptherightway\Models\User;
use Synthex\Phptherightway\Services\InvoiceService;

class HomeController
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    #[Get('/')]
    #[Get(path: '/home')]
    public function index(): string
    {
        return 'Hello World';
    }

    #[Post('/', RequestMethod::POST)]
    public function store(): void
    {
        # code...
    }

    #[Put('/', RequestMethod::PUT)]
    public function update(): void
    {
        # code...
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
