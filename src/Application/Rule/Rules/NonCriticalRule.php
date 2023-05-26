<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDecorator;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

final class NonCriticalRule implements RuleDecorator
{
    public function __construct(
        private readonly Rule $rule,
    ) {
        //
    }

    public function getName(): string
    {
        return $this->rule->getName();
    }

    public function lint(MergeRequest $request): array
    {
        $notes = $this->rule->lint($request);

        foreach ($notes as $i => $note) {
            if ($note->getSeverity() === NoteSeverity::Error) {
                $notes[$i] = $note->withSeverity(NoteSeverity::Warning);
            }
        }

        return $notes;
    }

    public function getDefinition(): RuleDefinition
    {
        return $this->rule->getDefinition();
    }

    public function getDecoratedRules(): array
    {
        return [$this->rule];
    }
}
