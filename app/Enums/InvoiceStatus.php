<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Enums;

enum InvoiceStatus: int
{
     case Pending = 0;
     case Paid = 1;
     case Void = 2;
     case Failed = 3;

    public function toString(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Paid => 'Paid',
            self::Void => 'Void',
            self::Failed => 'Failed',
        };
    }

    public function color(): Color
    {
        return match ($this) {
            self::Paid => Color::Green,
            self::Void => Color::Gray,
            self::Failed => Color::Red,
            default => Color::Orange,
        };
    }

    public static function fromColor(Color $color): static
    {
        return match($color) {
            Color::Green => self::Paid,
            Color::Gray => self::Void,
            Color::Red => self::Failed,
            default => self::Pending
        };
    }
}
