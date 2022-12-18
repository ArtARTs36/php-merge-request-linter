<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Support\ArrayableWrapper\WrapperFactory;

final class MockPropertyExtractor implements PropertyExtractor
{
    public function __construct(
        private mixed $value,
        private WrapperFactory $arrayableFactory = new WrapperFactory(),
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

    public function string(object $object, string $property): string
    {
        return $this->value;
    }

    public function arrayable(object $object, string $property): Arrayable
    {
        return $this->arrayableFactory->create($this->value);
    }
}
