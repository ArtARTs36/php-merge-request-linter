<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class ContainsOperator implements ConditionOperator
{
    public const NAME = 'contains';

    public function __construct(
        private PropertyExtractor $propertyExtractor,
        private string $property,
        private int|string|float|bool $value,
    ) {
        //
    }

    public function evaluate(MergeRequest $request): bool
    {
        $val = $this->propertyExtractor->iterable($request, $this->property);

        if (is_array($val)) {
            return in_array($this->value, $val);
        }

        return $val->has($this->value) !== null;
    }
}
