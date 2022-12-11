<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\Str\Facade\Str;

class StartsOperator implements ConditionOperator
{
    public function __construct(
        private PropertyExtractor $propertyExtractor,
        private string $field,
        private mixed $starts,
    ) {
        //
    }

    public function evaluate(MergeRequest $request): bool
    {
        return Str::startsWith($this->propertyExtractor->scalar($request, $this->field), $this->starts);
    }
}