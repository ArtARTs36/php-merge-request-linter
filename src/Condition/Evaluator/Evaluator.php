<?php

namespace ArtARTs36\MergeRequestLinter\Condition\Evaluator;

use ArtARTs36\MergeRequestLinter\Contracts\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Contracts\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Exception\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Exception\PropertyNotExists;

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
                    $e->getPropertyName(),
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
                    $e->getPropertyName(),
                ),
                $e->getPropertyName(),
                previous: $e,
            );
        }
    }
}
