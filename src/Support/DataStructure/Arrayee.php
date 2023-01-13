<?php

namespace ArtARTs36\MergeRequestLinter\Support\DataStructure;

use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Traits\ContainsAll;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Traits\CountProxy;
use Traversable;

/**
 * @template K of array-key
 * @template V
 * @template-implements Collection<K, V>
 */
class Arrayee implements Collection
{
    use CountProxy;
    use ContainsAll;

    /**
     * @param array<K, V> $items
     */
    public function __construct(
        protected array $items,
    ) {
        //
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function containsAny(iterable $values): bool
    {
        foreach ($values as $value) {
            if ($this->contains($value)) {
                return true;
            }
        }

        return false;
    }

    public function contains(mixed $value): bool
    {
        return in_array($value, $this->items);
    }

    /**
     * @return V|null
     */
    public function first(): mixed
    {
        $item = current($this->items);

        if ($item === false) {
            return null;
        }

        return $item;
    }

    public function implode(string $sep): string
    {
        return implode($sep, $this->items);
    }

    public function debugView(): string
    {
        return "[" . $this->implode(', ') . "]";
    }
}
