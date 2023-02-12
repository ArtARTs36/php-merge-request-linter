<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;
use ArtARTs36\Str\Str;

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

    public function string(object $object, string $property): Str
    {
        return Str::make($this->value);
    }

    public function collection(object $object, string $property): Collection
    {
        if (is_array($this->value)) {
            return new Arrayee($this->value);
        }

        return $this->value;
    }

    public function interface(object $object, string $property, string $interface): mixed
    {
        return $this->value;
    }
}
