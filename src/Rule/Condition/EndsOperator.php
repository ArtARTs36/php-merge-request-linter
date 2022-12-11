<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\Str\Facade\Str;

class EndsOperator implements ConditionOperator
{
    public const NAME = 'ends';

    public function __construct(
        private PropertyExtractor $propertyExtractor,
        private string $property,
        private mixed $ends,
    ) {
        //
    }

    public function evaluate(MergeRequest $request): bool
    {
        return Str::endsWith($this->propertyExtractor->scalar($request, $this->property), $this->ends);
    }
}
