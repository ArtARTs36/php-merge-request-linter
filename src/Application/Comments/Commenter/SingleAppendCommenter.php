<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\MakingComment;
use ArtARTs36\MergeRequestLinter\Domain\Request\Comment;

final class SingleAppendCommenter extends AbstractSingleCommenter
{
    protected function createUpdatingMessage(Comment $comment, MakingComment $makingComment): string
    {
        return $comment->message . "\n---\n" . $makingComment->message;
    }
}
