<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\MarkdownCleaner;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\Str\Str;

class GitlabCi implements CiSystem
{
    public const NAME = 'gitlab_ci';

    public function __construct(
        protected GitlabEnvironment     $environment,
        protected GitlabClient          $client,
        protected MarkdownCleaner $markdownCleaner,
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

        $description = Str::make($request->description);

        return new MergeRequest(
            Str::make($request->title),
            $description->markdown(),
            $this->markdownCleaner->clean($description),
            Set::fromList($request->labels),
            $request->hasConflicts,
            Str::make($request->sourceBranch),
            Str::make($request->targetBranch),
            new Author(Str::make($request->authorLogin)),
            $request->isDraft,
            $request->canMerge(),
            $this->mapChanges($request),
            $request->createdAt,
            Str::make($request->uri),
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
                $change->diff,
            );
        }

        return new ArrayMap($changes);
    }
}
