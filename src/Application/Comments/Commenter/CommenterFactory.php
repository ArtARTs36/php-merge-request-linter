<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;

/**
 * Interface for commenter factory.
 */
interface CommenterFactory
{
    /**
     * Create a commenter instance.
     */
    public function create(CommentsPostStrategy $strategy): Commenter;
}
