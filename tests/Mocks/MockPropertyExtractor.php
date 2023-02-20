<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;

final class MockPropertyExtractor implements PropertyExtractor
{
    public function __construct(
        private mixed $value,
    ) {
        //
    }

    public function scalar(object $object, string $property): int|string|float|bool
    {
        return $this->value;
    }

    public function interface(object $object, string $property, string $interface): mixed
    {
        return $this->value;
    }
}
