<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Entities;

class Invoice
{
    public function __destruct()
    {
        echo 'Invoice destructor' . PHP_EOL;
    }
}
