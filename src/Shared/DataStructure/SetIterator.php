<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

/**
 * @template V
 * @template-implements \Iterator<int, V>
 */
final class SetIterator implements \Iterator
{
    private int $index = 0;

    /**
     * @var mixed|false
     */
    private mixed $currentValue = false;

    /**
     * @param array<V> $items
     */
    public function __construct(
        private array $items,
    ) {
        //
    }

    public function current(): mixed
    {
        return $this->currentValue;
    }

    public function next(): void
    {
        $this->currentValue = next($this->items);

        ++$this->index;
    }

    public function key(): mixed
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return $this->currentValue !== false;
    }

    public function rewind(): void
    {
        $this->currentValue = reset($this->items);

        $this->index = 0;
    }
}
