<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;

class SystemFactory implements CiSystemFactory
{
    /** @var array<string, class-string<CiSystem>> */
    protected array $ciMap = [
        'gitlab' => GitlabCi::class,
        'github' => GithubActions::class,
    ];

    public function __construct(
        protected Config $config,
        protected Environment $environment,
    ) {
        //
    }

    public function createCurrently(): CiSystem
    {
        foreach ($this->ciMap as $name => $ciClass) {
            if ($ciClass::is($this->environment)) {
                return $this->create($name);
            }
        }

        throw new CiNotSupported();
    }

    public function create(string $ciName): CiSystem
    {
        $targetClass = $this->ciMap[$ciName] ?? null;

        if ($targetClass === null) {
            throw new CiNotSupported();
        }

        if (! $this->config->getCredentials()->has($targetClass)) {
            throw InvalidCredentialsException::fromCiName($ciName);
        }

        return new $targetClass(
            $this->config->getCredentials()->get($targetClass),
            $this->environment,
            $this->config->getHttpClientFactory()($ciName, $this->environment, $targetClass)
        );
    }
}
