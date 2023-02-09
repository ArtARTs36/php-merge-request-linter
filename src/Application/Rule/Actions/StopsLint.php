<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Actions;

use ArtARTs36\MergeRequestLinter\Exception\StopLintException;

trait StopsLint
{
    /**
     * @throws StopLintException
     */
    protected function stop(string $reason): void
    {
        throw new StopLintException($reason);
    }
}
