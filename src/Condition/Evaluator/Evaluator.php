<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Exception\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Contracts\EvaluatingSubject;

abstract class Evaluator implements ConditionEvaluator
{
    public const NAME = '';

    abstract protected function doEvaluate(EvaluatingSubject $subject): bool;

    public function evaluate(EvaluatingSubject $subject): bool
    {
        try {
            return $this->doEvaluate($subject);
        } catch (PropertyHasDifferentTypeException $e) {
            throw new ComparedIncompatibilityTypesException(
                sprintf(
                    'Operator "%s": attempt compare incompatibility types on property request.%s(%s). Expected type: %s',
                    static::NAME,
                    $subject->property,
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
                    $subject->property,
                ),
                previous: $e,
            );
        }
    }
}
