<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\NullCommenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\Commenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommenterFactory;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;

final class NullCommenterFactory implements CommenterFactory
{
    public function create(CommentsPostStrategy $strategy): Commenter
    {
        return new NullCommenter();
    }
}
