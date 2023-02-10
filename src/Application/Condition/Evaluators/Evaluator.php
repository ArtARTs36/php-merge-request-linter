<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Application\Condition\Exceptions\ComparedIncompatibilityTypesException;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyHasDifferentTypeException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;

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
