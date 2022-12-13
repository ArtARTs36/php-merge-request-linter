<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;

class IncludesOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'includes';

    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        private int|string|float|bool $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        $val = $this->propertyExtractor->iterable($request, $this->property);

        if (is_array($val)) {
            return in_array($this->value, $val);
        }

        return $val->has("$this->value");
    }
}
