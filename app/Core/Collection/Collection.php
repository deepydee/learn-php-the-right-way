<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;

class Collection implements
    ArrayAccess,
    Countable,
    IteratorAggregate
{
    private function __construct(
        protected array $items,
    ) {
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
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

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}
