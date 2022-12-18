<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Condition\Attribute\EvaluatesGenericType;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

/**
 * Check if an array contains some value of list.
 */
class HasAnyOperator extends AbstractOperator
{
    public const NAME = 'hasAny';

    /**
     * @param array<scalar> $value
     */
    public function __construct(
        PropertyExtractor $propertyExtractor,
        string $property,
        #[Generic(Generic::OF_STRING)]
        private readonly array $value,
    ) {
        parent::__construct($propertyExtractor, $property);
    }

    protected function doEvaluate(MergeRequest $request): bool
    {
        return $this
            ->propertyExtractor
            ->arrayable($request, $this->property)
            ->hasAny($this->value);
    }
}
