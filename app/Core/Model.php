<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

abstract class Model
{
    protected DB $db;

    public function __construct()
    {
        $this->db = App::db();
    }

    protected function fetchLazy(\PDOStatement $stmt): \Generator
    {
        foreach ($stmt as $record) {
            yield $record;
        }
    }
}
