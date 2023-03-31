<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\HasDebugInfo;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits\ContainsAny;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits\CountProxy;

/**
 * @template V
 * @template-implements Collection<int, V>
 */
final class Set implements Collection, HasDebugInfo, \JsonSerializable
{
    use CountProxy;
    use ContainsAny;

    /**
     * @param array<string, V> $items
     */
    public function __construct(
        private readonly array $items,
    ) {
        //
    }

    /**
     * @template LV
     * @param iterable<LV> $list
     * @return Set<LV>
     */
    public static function fromList(iterable $list): self
    {
        $items = [];
        $count = 0;

        foreach ($list as $item) {
            $items[self::hash($item)] = $item;
            $count++;
        }

        $set = new self($items);
        $set->count = $count;

        return $set;
    }

    /**
     * @return array<V>
     */
    public function jsonSerialize(): array
    {
        return $this->values();
    }

    /**
     * @param V $value
     */
    public function contains(mixed $value): bool
    {
        return array_key_exists(self::hash($value), $this->items);
    }

    public function containsAll(iterable $values): bool
    {
        foreach ($values as $value) {
            if (! $this->contains($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Set<V> $that
     * @return Set<V>
     */
    public function diff(Set $that): Set
    {
        $items = $this->items;

        foreach ($that->items as $key => $_) {
            unset($items[$key]);
        }

        return new self($items);
    }

    public function implode(string $separator): string
    {
        return implode($separator, $this->items);
    }

    /**
     * @return \Traversable<V>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @return array<V>
     */
    public function values(): array
    {
        return array_values($this->items);
    }

    /**
     * @return V|null
     */
    public function first()
    {
        return $this->items[array_key_first($this->items)] ?? null;
    }

    public function __debugInfo(): array
    {
        return [
            'count' => $this->count(),
            'items' => array_keys($this->items),
        ];
    }

    /**
     * @param V $value
     */
    private static function hash(mixed $value): string
    {
        if (is_string($value)) {
            return 's_' . $value;
        } else if (is_object($value)) {
            return 'o_' . spl_object_hash($value);
        } else if (is_resource($value)) {
            return 'r_' . get_resource_id($value);
        } else if (is_int($value)) {
            return 'i_' . $value;
        } else if (is_float($value)) {
            return 'f_' . $value;
        } else if (is_array($value)) {
            return 'a_' . md5(serialize($value));
        }

        return '0';
    }
}
