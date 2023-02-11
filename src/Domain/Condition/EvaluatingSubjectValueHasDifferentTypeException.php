<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Condition;

interface EvaluatingSubjectValueHasDifferentTypeException extends \Throwable
{
    public function getPropertyName(): string;

    public function getRealPropertyType(): string;

    public function getExpectedPropertyType(): string;
}
