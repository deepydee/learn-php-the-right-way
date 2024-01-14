<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Factories;

use Synthex\Phptherightway\Core\Factory\Factory;

class InvoiceFactory extends Factory
{
    public static function definition(): array
    {
        return [
            'invoice_number' => static::$faker->randomNumber(5, true),
            'amount' => static::$faker->randomFloat(),
            'status' => static::$faker->numberBetween(0, 3),
        ];
    }
}
