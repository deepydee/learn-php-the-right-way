<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Enums;

enum Color: string
{
    case Red = 'red';
    case Green = 'green';
    case Gray = 'gray';
    case Orange = 'orange';

    public function getClass(): string
    {
        return 'color-' . $this->value;
    }
}
