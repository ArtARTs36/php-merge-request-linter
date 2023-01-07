<?php

namespace ArtARTs36\MergeRequestLinter\Contracts\CI;

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
