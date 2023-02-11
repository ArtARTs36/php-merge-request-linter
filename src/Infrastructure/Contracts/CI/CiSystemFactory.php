<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;

/**
 * Factory for CI Systems.
 */
interface CiSystemFactory
{
    /**
     * Create Currently CI System.
     */
    public function createCurrently(): CiSystem;
}
