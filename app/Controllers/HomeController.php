<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

class HomeController
{
    public function index(): string
    {
        $_SESSION['count'] = ($_SESSION['count'] ?? 0) + 1;

        setcookie(
            name: 'userName',
            value: 'Vito',
            expires_or_options: time() + 10,
            path: '/',
            domain: '',
            secure: false,
            httponly: false,
        );

        return 'Home';
    }
}
