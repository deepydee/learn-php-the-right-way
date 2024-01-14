<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core\Factory;

use Faker;

abstract class Factory
{
    private const BATCH_SIZE = 10;

    private static array $definitions = [];

    protected static $faker = null;

    private function __construct()
    {
        static::$faker = Faker\Factory::create();
    }

    public static function make(): static
    {
        return new static();
    }

    public static function create(?int $count): \Generator
    {
        for ($i = 0; $i < $count; $i++) {
            static::$definitions[] = static::definition();

            if (count(static::$definitions) >= self::BATCH_SIZE) {
                yield static::$definitions;
                static::$definitions = [];
            }
        }
    }

    abstract public static function definition(): array;
}
