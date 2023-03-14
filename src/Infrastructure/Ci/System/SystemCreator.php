<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;

/**
 * Interface CI System creators.
 */
interface SystemCreator
{
    /**
     * Create CI System.
     */
    public function create(CiSettings $settings): CiSystem;
}
