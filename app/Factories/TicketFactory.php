<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Factories;

use Synthex\Phptherightway\Core\Factory\Factory;

class TicketFactory extends Factory
{
    public static function definition(): array
    {
        return [
            'title' => static::$faker->sentence(3),
            'content' => static::$faker->text(100),
            'user_id' => static::$faker->unique()->randomNumber(),
            'template_id' => static::$faker->unique()->randomNumber(),
        ];
    }
}
