<?php

namespace ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Strings\Markdown;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Evaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubject;
use ArtARTs36\Str\Markdown;

final class ContainsHeadingEvaluator extends Evaluator
{
    public const PREFIX_NAME = 'containsHeading';
    public const NAME = 'containsHeading1';
    public const NAME_HEADING_2 = 'containsHeading2';
    public const NAME_HEADING_3 = 'containsHeading3';
    public const NAME_HEADING_4 = 'containsHeading4';
    public const NAME_HEADING_5 = 'containsHeading5';
    public const NAME_HEADING_6 = 'containsHeading6';

    public function __construct(
        private readonly string $value,
        private readonly int $level,
    ) {
        //
    }

    protected function doEvaluate(EvaluatingSubject $subject): bool
    {
        return $subject
            ->interface(Markdown::class)
            ->containsHeadingWithLevel($this->value, $this->level);
    }
}
