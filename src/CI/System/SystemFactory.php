<?php

namespace ArtARTs36\MergeRequestLinter\CI\System;

use ArtARTs36\MergeRequestLinter\CI\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Client;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\HTTP\HttpClientFactory;
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
        if ($this->config->getCredentials()->isEmpty()) {
            throw new InvalidCredentialsException('Credentials must be filled');
        }

        foreach ($this->ciSystems as $name => $ciClass) {
            try {
                $ci = $this->create($name);
            } catch (InvalidCredentialsException) {
                continue;
            }

            if ($ci->isCurrentlyWorking()) {
                return $ci;
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
            return new GithubActions(new GithubEnvironment($this->environment), new Client(
                $httpClient,
                $credentials,
                new PullRequestSchema(),
            ));
        }

        if ($targetClass === GitlabCi::class) {
            return new GitlabCi(new GitlabEnvironment($this->environment), new Gitlab\API\Client(
                $credentials,
                $httpClient,
            ));
        }

        return new $targetClass(
            credentials: $credentials,
            httpClient: $this->httpClientFactory->create($this->config->getHttpClient()),
            environment: $this->environment,
        );
    }
}
