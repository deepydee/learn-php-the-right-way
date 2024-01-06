<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Enums;

enum EmailStatus: int
{
    case Queue = 0;
    case Sent = 1;
    case Failed = 2;

    public function toString(): string
    {
        return match ($this) {
            self::Queue  => 'In Queue',
            self::Sent   => 'Sent',
            self::Failed => 'Failed'
        };
    }
}
