<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Collection;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;

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

    public function collection(): Collection
    {
        return new Arrayee($this->value);
    }

    public function propertyName(): string
    {
        return 'mock_property';
    }
}
