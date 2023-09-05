<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure;

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
     * Here, an SetIterator is used so that the hashed keys are not available
     * when the Set is iterated, since they are of no practical use outside.
     * @return \Traversable<V>
     */
    public function getIterator(): \Traversable
    {
        return new SetIterator($this->items);
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
            'items' => $this->values(),
        ];
    }

    /**
     * @param iterable<V> $values
     * @return Set<V>
     */
    public function merge(iterable $values): self
    {
        $items = $this->items;
        $count = $this->count();

        foreach ($values as $value) {
            if ($this->contains($value)) {
                continue;
            }

            $items[self::hash($value)] = $value;

            $count++;
        }

        $newSet = new self($items);
        $newSet->count = $count;

        return $newSet;
    }

    private static function hash(mixed $value): string
    {
        if (is_string($value)) {
            return 's_' . $value;
        } elseif (is_object($value)) {
            return 'o_' . spl_object_hash($value);
        } elseif (is_resource($value)) {
            return 'r_' . get_resource_id($value);
        } elseif (is_int($value)) {
            return 'i_' . $value;
        } elseif (is_float($value)) {
            return 'f_' . $value;
        } elseif (is_array($value)) {
            return 'a_' . md5(serialize($value));
        } elseif (is_bool($value)) {
            return 'b_' . ($value ? 'true' : 'false');
        }

        return '0';
    }
}
