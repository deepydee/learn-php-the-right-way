<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

class Collection
{
    private function __construct(
        protected array $items,
    ) {
    }

   public static function make(array $items): static
   {
       return new static($items);
   }

    public function map(callable $callback): static
    {
        return new static(array_map($callback, $this->items));
    }

    public function filter(callable $callback): static
    {
        return new static(array_filter($this->items, $callback));
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
