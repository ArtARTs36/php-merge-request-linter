<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\Commenter;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use Psr\Log\LoggerInterface;

abstract class CiCommenter implements Commenter
{
    public function __construct(
        protected readonly CiSystem $ci,
        protected readonly LoggerInterface $logger,
    ) {
    }
}
