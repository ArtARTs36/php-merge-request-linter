<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments;

use ArtARTs36\MergeRequestLinter\Application\Comments\Exceptions\CommenterNotFoundException;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;

class CommenterFactory
{
    /**
     * @throws \Exception
     */
    public function create(CommentsPostStrategy $strategy): Commenter
    {
        if ($strategy === CommentsPostStrategy::Null) {
            return new NullCommenter();
        }

        throw new CommenterNotFoundException(sprintf('Commenter for strategy %s not found', $strategy->value));
    }
}
