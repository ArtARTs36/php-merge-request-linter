<?php

namespace ArtARTs36\MergeRequestLinter\Request;

class Labels implements \IteratorAggregate
{
    public function __construct(protected array $items)
    {
        //
    }

    public static function fromList(array $list): self
    {
        $items = [];

        foreach ($list as $item) {
            $items[$item] = $item;
        }

        return new self($items);
    }

    public function has(string $label): bool
    {
        return array_key_exists($label, $this->items);
    }

    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->items);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function count(): int
    {
        return count($this->items);
    }
}
