<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * The description must have a link to YouTrack issue on a {domain} with {projectCode}.
 */
class HasLinkToYouTrackIssueRule extends SimpleRule
{
    public const NAME = '@mr-linter/youtrack/has_issue_link';

    public function __construct(protected string $domain, protected string $projectCode)
    {
        parent::__construct('The description must have a link to YouTrack on ' . $this->domain);
    }

    protected function doLint(MergeRequest $request): bool|array|null
    {
        $domain = str_replace(['.'], ['\.'], $this->domain);

        return $request->description->match("#$domain\/issue/$this->projectCode-\d#")->isNotEmpty();
    }
}
