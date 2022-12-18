<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Operator;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionOperator;
use ArtARTs36\MergeRequestLinter\Contracts\PropertyExtractor;
use ArtARTs36\MergeRequestLinter\Exception\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;

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

    public function evaluate(object $subject): bool
    {
        try {
            return $this->doEvaluate($subject);
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
