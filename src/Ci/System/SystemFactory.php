<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Support\Map;
use OndraM\CiDetector\CiDetector;

class SystemFactory
{
    /** @var array<string, class-string<CiSystem>> */
    protected array $ciMap = [
        CiDetector::CI_GITLAB => GitlabCi::class,
    ];

    public function __construct(
        protected Map $credentials,
        protected Environment $environment,
    ) {
        //
    }

    public function create(string $ciName): CiSystem
    {
        $targetClass = $this->ciMap[$ciName] ?? null;

        if ($targetClass === null) {
            throw new CiNotSupported();
        }

        return new $targetClass($this->credentials->get($targetClass), $this->environment);
    }
}
