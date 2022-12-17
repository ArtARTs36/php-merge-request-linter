<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

#[EvaluatesGenericType]
class HasOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'has';

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

        if ($val instanceof Set) {
            return $val->has($this->value);
        }

        return $val->search($this->value) !== null;
    }
}
