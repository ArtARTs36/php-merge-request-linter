<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Domain\Note\NoteSeverity;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

final class NonCriticalRule extends OneRuleDecoratorRule
{
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
}
