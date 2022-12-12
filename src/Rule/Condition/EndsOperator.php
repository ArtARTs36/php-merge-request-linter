<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\Str\Facade\Str;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;

class EndsOperator extends AbstractOperator implements ConditionOperator
{
    public const NAME = 'ends';

    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        private mixed $ends,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        $value = $this->propertyExtractor->scalar($request, $this->property);

        return Str::endsWith("$value", $this->ends);
    }
}
