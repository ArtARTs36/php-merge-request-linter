<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\MergeRequestLinter\Support\Set;

final class MockPropertyExtractor implements PropertyExtractor
{
    public function __construct(
        private mixed $value,
    ) {
        //
    }

    public function numeric(object $object, string $property): int|float
    {
        return $this->value;
    }

    public function scalar(object $object, string $property): int|string|float|bool
    {
        return $this->value;
    }

    public function iterable(object $object, string $property): array|Set|Map
    {
        return $this->value;
    }
}
