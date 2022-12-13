<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;

class SystemFactory implements CiSystemFactory
{
    /** @var array<string, class-string<CiSystem>> */
    public const CI_MAP = [
        GitlabCi::NAME => GitlabCi::class,
        GithubActions::NAME => GithubActions::class,
    ];

    public function __construct(
        protected Config $config,
        protected Environment $environment,
        protected HttpClientFactory $httpClientFactory,
    ) {
        //
    }

    public function createCurrently(): CiSystem
    {
        foreach (self::CI_MAP as $name => $ciClass) {
            if ($ciClass::is($this->environment)) {
                return $this->create($name);
            }
        }

        throw new CiNotSupported('CI not detected');
    }

    public function create(string $ciName): CiSystem
    {
        $targetClass = self::CI_MAP[$ciName] ?? null;

        if ($targetClass === null) {
            throw CiNotSupported::fromCiName($ciName);
        }

        if (! $this->config->getCredentials()->has($targetClass)) {
            throw InvalidCredentialsException::fromCiName($ciName);
        }

        return new $targetClass(
            //@phpstan-ignore-next-line
            $this->config->getCredentials()->get($targetClass),
            $this->environment,
            $this->httpClientFactory->create(
                $this->config->getHttpClient(),
            ),
        );
    }
}
