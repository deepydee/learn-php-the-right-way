<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Services;

class EmailService
{
    public function send(array $to, string $template): bool
    {
        sleep(1);

        return true;
    }
}
