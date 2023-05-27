<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\Str\Str;

/**
 * Check if a string not contains a prefixes.
 */
final class NotStartsAnyEvaluator extends Evaluator
{
    public const NAME = 'notStartsAny';

    /**
     * @param array<string> $value
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
            ->interface(Str::class)
            ->startsWithAnyOf($this->value);
    }
}
