<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Controllers;

use Symfony\Component\Mime\Address;
use Synthex\Phptherightway\Attributes\Get;
use Synthex\Phptherightway\Attributes\Post;
use Synthex\Phptherightway\Core\View;

class UserController
{
    #[Get('/users/create')]
    public function create(): View
    {
        return View::make('users/register');
    }

    #[Post('/users')]
    public function register()
    {
        $name      = $_POST['name'];
        $email     = $_POST['email'];
        $firstName = explode(' ', $name)[0];

        $text = <<<Body
Hello $firstName,

Thank you for signing up!
Body;

        $html = <<<HTMLBody
<h1 style="text-align: center; color: blue;">Welcome</h1>
Hello $firstName,
<br /><br />
Thank you for signing up!
HTMLBody;

        (new \Synthex\Phptherightway\Models\Email())->queue(
            new Address($email),
            new Address('support@example.com', 'Support'),
            'Welcome!',
            $html,
            $text
        );
    }
}
