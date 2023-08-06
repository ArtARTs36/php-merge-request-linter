<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Contracts;

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
