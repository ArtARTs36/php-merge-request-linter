<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators;

use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Collection;

#[Description('Check if an array not contains values of list.')]
final class NotHasAnyEvaluator extends Evaluator
{
    public const NAME = 'notHasAny';

    /**
     * @param array<scalar> $value
     */
    public function __construct(
        #[Generic(Generic::OF_STRING)]
        private readonly array $value,
    ) {
        //
    }

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return ! $subject
            ->interface(Collection::class)
            ->containsAny($this->value);
    }
}
