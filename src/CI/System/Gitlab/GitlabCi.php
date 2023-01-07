<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab;

use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\Env\VarName;
use ArtARTs36\MergeRequestLinter\CI\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Request\Data\Author;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\Str\Str;

class GitlabCi implements CiSystem
{
    use InteractsWithResponse;

    public const NAME = 'gitlab_ci';

    public function __construct(
        protected GitlabEnvironment $environment,
        protected GitlabClient $client,
    ) {
        //
    }

    public static function is(Environment $environment): bool
    {
        return $environment->has(VarName::Identity->value);
    }

    public function isMergeRequest(): bool
    {
        try {
            return $this->environment->getMergeRequestId() >= 0;
        } catch (EnvironmentVariableNotFound) {
            return false;
        }
    }

    public function getCurrentlyMergeRequest(): MergeRequest
    {
        $request = $this->client->getMergeRequest(
            new MergeRequestInput(
                $this->environment->getGitlabServerUrl(),
                $this->environment->getProjectId(),
                $this->environment->getMergeRequestId(),
            ),
        );

        return new MergeRequest(
            Str::make($request->title),
            Str::make($request->description),
            Set::fromList($request->labels),
            $request->hasConflicts,
            Str::make($request->sourceBranch),
            Str::make($request->targetBranch),
            $request->changedFilesCount,
            new Author($request->authorLogin),
            $request->isDraft,
            $request->canMerge(),
        );
    }
}
