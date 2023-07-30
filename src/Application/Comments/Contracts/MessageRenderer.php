<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Contracts;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * Interface for message renderers.
 */
interface MessageRenderer
{
    /**
     * Render message.
     */
    public function render(MergeRequest $request, LintResult $result, CommentsMessage $config): string;
}
