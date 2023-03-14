<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\BitbucketPipelines;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Env\BitbucketEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActionsCreator;
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
    /**
     * @param Map<string, SystemCreator> $creators
     */
    public function __construct(
        private readonly Config $config,
        private readonly Map $creators,
    ) {
        //
    }

    public function createCurrently(): CiSystem
    {
        foreach ($this->creators as $name => $ciClass) {
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
        $creator = $this->creators->get($ciName);

        if ($creator === null) {
            throw CiNotSupported::fromCiName($ciName);
        }

        $settings = $this->config->getSettings()->get($ciName);

        if ($settings === null) {
            throw CredentialsNotSetException::create($ciName);
        }

        return $creator->create($settings);
    }
}
