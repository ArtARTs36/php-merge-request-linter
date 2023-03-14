<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Text\Cleaner\LeagueMarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\GithubEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Client;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\CredentialsNotSetException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\HttpClientFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use League\CommonMark\CommonMarkConverter;
use Psr\Log\LoggerInterface;

class SystemFactory implements CiSystemFactory
{
    /** @var array<class-string<CiSystem>, callable(Authenticator, HttpClient): CiSystem> */
    protected array $creators;

    /**
     * @param Map<string, class-string<CiSystem>> $ciSystems
     * @param array<class-string<CiSystem>, callable(Authenticator, HttpClient): CiSystem> $creators
     */
    public function __construct(
        protected Config            $config,
        protected Environment       $environment,
        protected HttpClientFactory $httpClientFactory,
        protected Map          $ciSystems,
        protected LoggerInterface $logger,
        array $creators = []
    ) {
        $this->creators = [
            GithubActions::class => $this->createGithubActions(...),
            GitlabCi::class => $this->createGitlabCi(...),
            BitbucketPipelines::class => $this->createBitbucketPipelines(...),
        ] + $creators;
    }

    public function createCurrently(): CiSystem
    {
        foreach ($this->ciSystems as $name => $ciClass) {
            try {
                $ci = $this->create($name);
            } catch (CredentialsNotSetException) {
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

        // Resolve empty class without difficult constructing

        if (! method_exists($targetClass, '__construct')) {
            return new $targetClass();
        }

        //

        $credentials = $this->config->getSettings()->get($targetClass);

        if ($credentials === null) {
            throw CredentialsNotSetException::create($ciName);
        }

        $httpClient = $this->httpClientFactory->create($this->config->getHttpClient());

        if (isset($this->creators[$targetClass])) {
            return $this->createUsingCreator($this->creators[$targetClass], $credentials, $httpClient);
        }

        return new $targetClass(
            credentials: $credentials,
            httpClient: $httpClient,
            environment: $this->environment,
        );
    }

    /**
     * @param callable(Authenticator, HttpClient): CiSystem $creator
     * @return CiSystem
     */
    protected function createUsingCreator(callable $creator, CiSettings $credentials, HttpClient $client): CiSystem
    {
        return $creator($credentials->credentials, $client);
    }

    protected function createGithubActions(Authenticator $credentials, HttpClient $httpClient): CiSystem
    {
        return new GithubActions(new GithubEnvironment($this->environment), new Client(
            $httpClient,
            $credentials,
            new PullRequestSchema(),
            new DiffMapper(),
            $this->logger,
        ));
    }

    protected function createGitlabCi(Authenticator $credentials, HttpClient $httpClient): CiSystem
    {
        return new GitlabCi(
            new GitlabEnvironment($this->environment),
            new \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Client(
                $credentials,
                $httpClient,
                new DiffMapper(),
                $this->logger,
            ),
            new LeagueMarkdownCleaner(new CommonMarkConverter()),
        );
    }

    protected function createBitbucketPipelines(Authenticator $credentials, HttpClient $httpClient): BitbucketPipelines
    {
        return new BitbucketPipelines(
            new Bitbucket\API\Client($credentials, $httpClient, $this->logger),
            new BitbucketEnvironment($this->environment),
            new LeagueMarkdownCleaner(new CommonMarkConverter()),
        );
    }
}
