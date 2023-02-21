<?php

namespace ArtARTs36\MergeRequestLinter\Shared\DataStructure\Traits;

trait ContainsAny
{
    abstract public function contains(mixed $value): bool;

    public function containsAny(iterable $values): bool
    {
        foreach ($values as $value) {
            if ($this->contains($value)) {
                return true;
            }
        }

        return false;
    }
}
