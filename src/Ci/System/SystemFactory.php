<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Ci\System\Github\GithubActions;
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

        if ($this->config->getCredentials()->missing($targetClass)) {
            throw InvalidCredentialsException::fromCiName($ciName);
        }

        $credentials = $this->config->getCredentials()->get($targetClass);
        $httpClient = $this->httpClientFactory->create($this->config->getHttpClient());

        if ($targetClass === GithubActions::class) {
            return new GithubActions($credentials, new GithubEnvironment($this->environment), $httpClient);
        }

        if ($targetClass === GitlabCi::class) {
            return new GitlabCi($credentials, $this->environment, $httpClient);
        }

        return $this->construct($targetClass);
    }

    /**
     * @param class-string<CiSystem> $class
     */
    protected function construct(string $class): CiSystem
    {
        if (method_exists($class, '__construct')) {
            return call_user_func_array([$class, '__construct'], [
                'credentials' => $this->config->getCredentials()->get($class),
                'httpClient' => $this->httpClientFactory->create($this->config->getHttpClient()),
                'environment' => $this->environment,
            ]);
        }

        return new $class;
    }
}
