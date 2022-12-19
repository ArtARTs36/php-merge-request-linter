<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Contracts\Arrayable;
use ArtARTs36\MergeRequestLinter\Contracts\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Support\ArrayableWrapper\ArrayWrapper;

class MockEvaluatingSubject implements EvaluatingSubject
{
    public function __construct(
        private mixed $value,
    ) {
        //
    }

    public function numeric(): int|float
    {
        return $this->value;
    }

    public function scalar(): int|string|float|bool
    {
        return $this->value;
    }

    public function string(): string
    {
        return $this->value;
    }

    public function arrayable(): Arrayable
    {
        return new ArrayWrapper($this->value);
    }

    public function propertyName(): string
    {
        return 'mock_property';
    }
}
