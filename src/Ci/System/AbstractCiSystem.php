<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;

abstract class AbstractCiSystem implements CiSystem
{
    public function __construct(protected RemoteCredentials $credentials, protected Environment $environment)
    {
        //
    }
}
