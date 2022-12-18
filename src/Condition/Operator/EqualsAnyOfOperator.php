<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

/**
 * Check if the field is equal to one of the values.
 */
class EqualsAnyOfOperator extends AbstractOperator
{
    public const NAME = 'equalsAnyOf';

    /**
     * @param array<scalar> $value
     */
    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        private readonly array $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        $property = $this->propertyExtractor->scalar($request, $this->property);

        return in_array($property, $this->value);
    }
}
