<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

class HomeController
{
    public function index(): string
    {
        $form = <<<HTML
        <form action="/upload" method="post" enctype="multipart/form-data">
            <input type="file" name="receipt">
            <button type="submit">Upload</button>
        </form>
        HTML;

        return $form;
    }

    public function upload(): void
    {
        var_dump($_FILES);
        var_dump(pathinfo($_FILES['receipt']['tmp_name']));

        $filePath = STORAGE_PATH . '/' . $_FILES['receipt']['name'];

        move_uploaded_file($_FILES['receipt']['tmp_name'], $filePath);

        var_dump($filePath);
    }
}
