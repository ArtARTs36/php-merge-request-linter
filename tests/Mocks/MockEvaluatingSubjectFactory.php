<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;

class MockEvaluatingSubjectFactory implements EvaluatingSubjectFactory
{
    public function __construct(
        private readonly EvaluatingSubject $subject,
    ) {
        //
    }

    public function createForProperty(object $object, string $property): EvaluatingSubject
    {
        return $this->subject;
    }

    public function createForValue(string $name, mixed $value): EvaluatingSubject
    {
        return $this->subject;
    }
}
