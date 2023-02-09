<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Gitlab;

use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\EnvironmentVariableNotFoundException;
use ArtARTs36\MergeRequestLinter\Request\Data\Author;
use ArtARTs36\MergeRequestLinter\Request\Data\Change;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\Diff;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
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

    public function getName(): string
    {
        return self::NAME;
    }

    public function isCurrentlyWorking(): bool
    {
        return $this->environment->isWorking();
    }

    public function isCurrentlyMergeRequest(): bool
    {
        try {
            return $this->environment->getMergeRequestId() >= 0;
        } catch (EnvironmentVariableNotFoundException) {
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
            new Author(Str::make($request->authorLogin)),
            $request->isDraft,
            $request->canMerge(),
            $this->mapChanges($request),
        );
    }

    /**
     * @return Map<string, Change>
     */
    private function mapChanges(API\MergeRequest $request): Map
    {
        $changes = [];

        foreach ($request->changes as $change) {
            $changes[$change->newPath] = new Change(
                $change->newPath,
                new Diff($change->diff),
            );
        }

        return new ArrayMap($changes);
    }
}
