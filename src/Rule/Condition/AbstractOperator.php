<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Exception\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;

abstract class AbstractOperator implements ConditionOperator
{
    public const NAME = '';

    abstract protected function doEvaluate(MergeRequest $request): bool;

    public function __construct(
        protected PropertyExtractor $propertyExtractor,
        protected string $property,
    ) {
        //
    }

    public function evaluate(MergeRequest $request): bool
    {
        try {
            return $this->doEvaluate($request);
        } catch (PropertyHasDifferentTypeException $e) {
            throw new ComparedIncompatibilityTypesException(
                sprintf(
                    'Operator "%s": attempt compare incompatibility types on property request.%s(%s). Expected type: %s',
                    static::NAME,
                    $this->property,
                    $e->getRealPropertyType(),
                    $e->getExpectedPropertyType(),
                ),
                previous: $e,
            );
        } catch (PropertyNotExists $e) {
            throw new PropertyNotExists(
                sprintf(
                    'Operator "%s": property request.%s not exists',
                    static::NAME,
                    $this->property,
                ),
                previous: $e,
            );
        }
    }
}
