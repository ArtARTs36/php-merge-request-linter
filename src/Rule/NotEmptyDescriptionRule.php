<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Linter\LintError;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class NotEmptyDescriptionRule implements Rule
{
    public function lint(MergeRequest $request): array
    {
        $errors = [];

        if ($request->description->isEmpty()) {
            $errors[] = new LintError('Description must filled');
        }

        return $errors;
    }
}
