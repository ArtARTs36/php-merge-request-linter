<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab;

use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Exception\EnvironmentVariableNotFound;
use ArtARTs36\MergeRequestLinter\Request\Data\Author;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\Str\Str;

class GitlabCi implements CiSystem
{
    public const NAME = 'gitlab_ci';

    public function __construct(
        protected GitlabEnvironment $environment,
        protected GitlabClient $client,
    ) {
        //
    }

    public function isCurrentlyWorking(): bool
    {
        return $this->environment->isWorking();
    }

    public function isCurrentlyMergeRequest(): bool
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
