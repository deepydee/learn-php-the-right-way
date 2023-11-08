<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

class FileLogger
{
    static public $loggers = [];
    private float $time;

    private function __construct(string $fname)
    {
        $this->time = microtime(as_float: true);
    }

    public static function create(string $fname): self
    {
        if (isset(self::$loggers[$fname])) {
            return self::$loggers[$fname];
        }

        return self::$loggers[$fname] = new self($fname);
    }

    public function getTime(): float
    {
        return $this->time;
    }
}
