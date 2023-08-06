<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;

final class CachedSystemFactory implements CiSystemFactory
{
    private ?CiSystem $ciSystem = null;

    /**
     * @param \Closure(): CiSystem $creator
     */
    public function __construct(
        private readonly \Closure $creator,
    ) {
        //
    }

    public function createCurrently(): CiSystem
    {
        return $this->ciSystem ??= ($this->creator)();
    }
}
