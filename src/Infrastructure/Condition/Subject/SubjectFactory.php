<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Subject;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;

class SubjectFactory implements EvaluatingSubjectFactory
{
    public function __construct(
        private readonly PropertyExtractor $propertyExtractor,
    ) {
    }

    public function createForValue(string $name, mixed $value): EvaluatingSubject
    {
        return new StaticEvaluatingSubject($name, $value);
    }

    public function createForProperty(object $object, string $property): EvaluatingSubject
    {
        return new PropertyEvaluatingSubject($object, $this->propertyExtractor, $property);
    }
}
