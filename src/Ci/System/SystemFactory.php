<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

class SystemFactory implements CiSystemFactory
{
    /**
     * @param Map<string, class-string<CiSystem>> $ciSystems
     */
    public function __construct(
        protected Config $config,
        protected Environment $environment,
        protected HttpClientFactory $httpClientFactory,
        protected Map $ciSystems,
    ) {
        //
    }

    public function createCurrently(): CiSystem
    {
        foreach ($this->ciSystems as $name => $ciClass) {
            if ($ciClass::is($this->environment)) {
                return $this->create($name);
            }
        }

        throw new CiNotSupported('CI not detected');
    }

    public function create(string $ciName): CiSystem
    {
        $targetClass = $this->ciSystems->get($ciName);

        if ($targetClass === null) {
            throw CiNotSupported::fromCiName($ciName);
        }

        if (! method_exists($targetClass, '__construct')) {
            return new $targetClass();
        }

        $credentials = $this->config->getCredentials()->get($targetClass);

        if ($credentials === null) {
            throw InvalidCredentialsException::fromCiName($ciName);
        }

        $httpClient = $this->httpClientFactory->create($this->config->getHttpClient());

        if ($targetClass === GithubActions::class) {
            return new GithubActions($credentials, new GithubEnvironment($this->environment), $httpClient);
        }

        if ($targetClass === GitlabCi::class) {
            return new GitlabCi($credentials, new GitlabEnvironment($this->environment), $httpClient);
        }

        return new $targetClass(
            credentials: $credentials,
            httpClient: $this->httpClientFactory->create($this->config->getHttpClient()),
            environment: $this->environment,
        );
    }
}
